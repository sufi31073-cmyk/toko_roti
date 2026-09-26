import 'product_model.dart';

class CartItemModel {
  final ProductModel product;
  int quantity;
  String? note;

  CartItemModel({
    required this.product,
    this.quantity = 1,
    this.note,
  });

  double get totalPrice => product.effectivePrice * quantity;

  Map<String, dynamic> toJson() {
    return {
      'product_id': product.id,
      'quantity': quantity,
      'price': product.effectivePrice,
      'note': note,
    };
  }
}
