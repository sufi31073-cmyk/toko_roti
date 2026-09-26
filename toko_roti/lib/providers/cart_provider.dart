import 'package:flutter/material.dart';
import '../models/cart_item_model.dart';
import '../models/product_model.dart';

class CartProvider with ChangeNotifier {
  final List<CartItemModel> _items = [];
  String? _appliedVoucherCode;
  double _discountAmount = 0.0;

  List<CartItemModel> get items => _items;

  String? get appliedVoucherCode => _appliedVoucherCode;

  double get discountAmount => _discountAmount;

  int get itemCount => _items.fold(0, (sum, item) => sum + item.quantity);

  double get subtotal => _items.fold(0, (sum, item) => sum + item.totalPrice);

  double get shippingFee => _items.isEmpty ? 0.0 : 10000.0; // Flat Rp 10.000

  double get grandTotal {
    final total = subtotal + shippingFee - _discountAmount;
    return total < 0 ? 0.0 : total;
  }

  double get totalAmount => grandTotal;

  bool applyVoucher(String code) {
    final cleanCode = code.trim().toUpperCase();
    if (cleanCode == 'ROTIHEMAT20') {
      _appliedVoucherCode = cleanCode;
      _discountAmount = subtotal * 0.20; // 20% OFF
      notifyListeners();
      return true;
    } else if (cleanCode == 'BEBASONGKIR') {
      _appliedVoucherCode = cleanCode;
      _discountAmount = shippingFee; // Free shipping
      notifyListeners();
      return true;
    } else if (cleanCode == 'ROTIHEMAT10') {
      _appliedVoucherCode = cleanCode;
      _discountAmount = subtotal * 0.10; // 10% OFF
      notifyListeners();
      return true;
    }
    return false;
  }

  void removeVoucher() {
    _appliedVoucherCode = null;
    _discountAmount = 0.0;
    notifyListeners();
  }

  void addToCart(ProductModel product, {int quantity = 1, String? note}) {
    int index = _items.indexWhere((item) => item.product.id == product.id);

    if (index >= 0) {
      _items[index].quantity += quantity;
      if (note != null) _items[index].note = note;
    } else {
      _items.add(CartItemModel(product: product, quantity: quantity, note: note));
    }
    _recalculateDiscount();
    notifyListeners();
  }

  void incrementQuantity(int productId) {
    int index = _items.indexWhere((item) => item.product.id == productId);
    if (index >= 0) {
      _items[index].quantity++;
      _recalculateDiscount();
      notifyListeners();
    }
  }

  void decrementQuantity(int productId) {
    int index = _items.indexWhere((item) => item.product.id == productId);
    if (index >= 0) {
      if (_items[index].quantity > 1) {
        _items[index].quantity--;
      } else {
        _items.removeAt(index);
      }
      _recalculateDiscount();
      notifyListeners();
    }
  }

  void removeFromCart(int productId) {
    _items.removeWhere((item) => item.product.id == productId);
    _recalculateDiscount();
    notifyListeners();
  }

  void clearCart() {
    _items.clear();
    _appliedVoucherCode = null;
    _discountAmount = 0.0;
    notifyListeners();
  }

  void _recalculateDiscount() {
    if (_appliedVoucherCode != null) {
      applyVoucher(_appliedVoucherCode!);
    }
  }
}
