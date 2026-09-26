import 'package:flutter/material.dart';
import '../config/api_config.dart';
import '../models/order_model.dart';
import '../services/api_service.dart';

class OrderProvider with ChangeNotifier {
  List<OrderModel> _orders = [];
  bool _isLoading = false;
  String? _errorMessage;

  List<OrderModel> get orders => _orders;
  bool get isLoading => _isLoading;
  String? get errorMessage => _errorMessage;

  Future<void> fetchOrders(String? token) async {
    if (token == null) return;
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    final result = await ApiService.get(ApiConfig.orders, token: token);
    if (result['success'] == true) {
      final List raw = result['data'];
      _orders = raw.map((o) => OrderModel.fromJson(o)).toList();
    } else {
      _errorMessage = result['message'];
    }

    _isLoading = false;
    notifyListeners();
  }

  Future<Map<String, dynamic>> createOrder({
    required String token,
    required List<Map<String, dynamic>> items,
    required String paymentMethod,
    required String shippingAddress,
  }) async {
    _isLoading = true;
    notifyListeners();

    final result = await ApiService.post(
      ApiConfig.orders,
      {
        'items': items,
        'payment_method': paymentMethod,
        'shipping_address': shippingAddress,
      },
      token: token,
    );

    _isLoading = false;
    notifyListeners();

    if (result['success'] == true) {
      await fetchOrders(token);
      final data = result['data'];
      return {
        'success': true,
        'message': data['message'] ?? 'Pesanan berhasil dibuat!',
        'order': OrderModel.fromJson(data['order']),
        'snap_token': data['snap_token'],
        'payment_url': data['payment_url'],
      };
    } else {
      return {'success': false, 'message': result['message']};
    }
  }
}
