import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../config/api_config.dart';
import '../models/user_model.dart';
import '../services/api_service.dart';

class AuthProvider with ChangeNotifier {
  UserModel? _user;
  String? _token;
  bool _isLoading = false;

  UserModel? get user => _user;
  String? get token => _token;
  bool get isAuthenticated => _token != null && _token!.isNotEmpty;
  bool get isLoading => _isLoading;

  AuthProvider() {
    _loadTokenFromPrefs();
  }

  Future<void> _loadTokenFromPrefs() async {
    final prefs = await SharedPreferences.getInstance();
    _token = prefs.getString('auth_token');
    if (_token != null) {
      await fetchUserProfile();
    }
    notifyListeners();
  }

  Future<Map<String, dynamic>> login(String email, String password) async {
    _isLoading = true;
    notifyListeners();

    final result = await ApiService.post(
      ApiConfig.login,
      {'email': email, 'password': password},
    );

    if (result['success'] == true) {
      final resData = result['data'];
      _token = resData['token'];
      _user = UserModel.fromJson(resData['user']);

      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('auth_token', _token!);

      _isLoading = false;
      notifyListeners();
      return {'success': true, 'message': 'Login berhasil!'};
    } else {
      _isLoading = false;
      notifyListeners();
      return {'success': false, 'message': result['message']};
    }
  }

  Future<Map<String, dynamic>> register(
      String name, String email, String password, String phone, String address) async {
    _isLoading = true;
    notifyListeners();

    final result = await ApiService.post(
      ApiConfig.register,
      {
        'name': name,
        'email': email,
        'password': password,
        'phone': phone,
        'address': address,
      },
    );

    if (result['success'] == true) {
      final resData = result['data'];
      _token = resData['token'];
      _user = UserModel.fromJson(resData['user']);

      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('auth_token', _token!);

      _isLoading = false;
      notifyListeners();
      return {'success': true, 'message': 'Pendaftaran berhasil!'};
    } else {
      _isLoading = false;
      notifyListeners();
      return {'success': false, 'message': result['message']};
    }
  }

  Future<void> fetchUserProfile() async {
    if (_token == null) return;
    final result = await ApiService.get(ApiConfig.userProfile, token: _token);
    if (result['success'] == true) {
      _user = UserModel.fromJson(result['data']);
      notifyListeners();
    } else {
      logout();
    }
  }

  Future<void> logout() async {
    if (_token != null) {
      await ApiService.post(ApiConfig.logout, {}, token: _token);
    }
    _user = null;
    _token = null;
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
    notifyListeners();
  }
}
