import 'dart:async';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class ApiConfig {
  static const String _storageKey = 'custom_backend_base_url';

  // Default fallback baseUrl (Supports ADB reverse, Web, Android Emulator & LAN)
  static String _baseUrl = 'http://127.0.0.1:8000/api';

  static String get baseUrl => _baseUrl;

  static set baseUrl(String newUrl) {
    _baseUrl = newUrl.replaceAll(RegExp(r'/+$'), ''); // Strip trailing slash
    _saveToStorage(_baseUrl);
  }

  // Candidate hosts to auto-probe
  static final List<String> candidateHosts = [
    'http://127.0.0.1:8000/api',     // ADB reverse / Localhost
    'http://10.74.113.182:8000/api',  // Current Wi-Fi LAN IP
    'http://10.63.44.182:8000/api',   // Alternative Wi-Fi IP
    'http://192.168.1.70:8000/api',   // Alternative Home Wi-Fi IP
    'http://192.168.1.54:8000/api',   // Alternative Wi-Fi IP
    'http://10.0.2.2:8000/api',       // Android Emulator host
    'http://localhost:8000/api',
  ];

  // Initialize from SharedPreferences & run background probe
  static Future<void> initialize() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final savedUrl = prefs.getString(_storageKey);
      if (savedUrl != null && savedUrl.isNotEmpty) {
        _baseUrl = savedUrl;
      }
    } catch (_) {}

    // Run auto-detect in background
    await autoDetectServer();
  }

  static Future<void> _saveToStorage(String url) async {
    try {
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString(_storageKey, url);
    } catch (_) {}
  }

  // Test if a specific URL is responsive
  static Future<bool> testConnection(String url) async {
    try {
      final cleanUrl = url.replaceAll(RegExp(r'/+$'), '');
      final testUri = Uri.parse('$cleanUrl/categories');
      final response = await http.get(testUri).timeout(const Duration(milliseconds: 1800));
      return response.statusCode >= 200 && response.statusCode < 400;
    } catch (_) {
      return false;
    }
  }

  // Auto-detect the fastest active server
  static Future<String?> autoDetectServer() async {
    // 1. If current _baseUrl is already responding, keep it!
    if (await testConnection(_baseUrl)) {
      return _baseUrl;
    }

    // 2. Otherwise probe candidate hosts in parallel
    for (final host in candidateHosts) {
      if (await testConnection(host)) {
        baseUrl = host;
        return host;
      }
    }

    return null;
  }

  // Auth Endpoints
  static String get login => '$baseUrl/login';
  static String get register => '$baseUrl/register';
  static String get logout => '$baseUrl/logout';
  static String get userProfile => '$baseUrl/user';

  // Catalog Endpoints
  static String get categories => '$baseUrl/categories';
  static String get products => '$baseUrl/products';
  static String get popularProducts => '$baseUrl/products/popular';

  // Orders Endpoints
  static String get orders => '$baseUrl/orders';
}
