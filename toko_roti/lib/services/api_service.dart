import 'dart:convert';
import 'package:http/http.dart' as http;
import '../config/api_config.dart';

class ApiService {
  static Map<String, String> _headers(String? token) {
    return {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      if (token != null && token.isNotEmpty) 'Authorization': 'Bearer $token',
    };
  }

  static Future<Map<String, dynamic>> post(
    String url,
    Map<String, dynamic> body, {
    String? token,
    bool autoRetry = true,
  }) async {
    try {
      final response = await http
          .post(
            Uri.parse(url),
            headers: _headers(token),
            body: jsonEncode(body),
          )
          .timeout(const Duration(seconds: 8));
      return _processResponse(response);
    } catch (e) {
      if (autoRetry) {
        // Attempt auto-detecting the active host and retry once
        final newBase = await ApiConfig.autoDetectServer();
        if (newBase != null) {
          final newUrl = _rebuildUrlWithNewBase(url, newBase);
          return post(newUrl, body, token: token, autoRetry: false);
        }
      }
      return {'success': false, 'message': 'Koneksi gagal ke server ($url): $e'};
    }
  }

  static Future<Map<String, dynamic>> get(
    String url, {
    String? token,
    bool autoRetry = true,
  }) async {
    try {
      final response = await http
          .get(
            Uri.parse(url),
            headers: _headers(token),
          )
          .timeout(const Duration(seconds: 8));
      return _processResponse(response);
    } catch (e) {
      if (autoRetry) {
        // Attempt auto-detecting the active host and retry once
        final newBase = await ApiConfig.autoDetectServer();
        if (newBase != null) {
          final newUrl = _rebuildUrlWithNewBase(url, newBase);
          return get(newUrl, token: token, autoRetry: false);
        }
      }
      return {'success': false, 'message': 'Koneksi gagal ke server ($url): $e'};
    }
  }

  static String _rebuildUrlWithNewBase(String originalUrl, String newBase) {
    try {
      final uri = Uri.parse(originalUrl);
      final path = uri.path; // e.g. /api/login
      final query = uri.hasQuery ? '?${uri.query}' : '';
      return '$newBase${path.replaceFirst('/api', '')}$query';
    } catch (_) {
      return originalUrl;
    }
  }

  static Map<String, dynamic> _processResponse(http.Response response) {
    try {
      final data = jsonDecode(response.body);
      if (response.statusCode >= 200 && response.statusCode < 300) {
        return {'success': true, 'data': data};
      } else {
        return {
          'success': false,
          'message': data['message'] ?? 'Terjadi kesalahan pada server (${response.statusCode})',
          'errors': data['errors'],
        };
      }
    } catch (e) {
      return {
        'success': false,
        'message': 'Format respons tidak valid dari server',
      };
    }
  }
}
