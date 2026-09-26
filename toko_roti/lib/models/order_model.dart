class OrderItemModel {
  final int id;
  final int productId;
  final String productName;
  final String? productImage;
  final int quantity;
  final double price;

  OrderItemModel({
    required this.id,
    required this.productId,
    required this.productName,
    this.productImage,
    required this.quantity,
    required this.price,
  });

  factory OrderItemModel.fromJson(Map<String, dynamic> json) {
    return OrderItemModel(
      id: json['id'] is int ? json['id'] : int.parse(json['id'].toString()),
      productId: json['product_id'] is int
          ? json['product_id']
          : int.parse(json['product_id'].toString()),
      productName: json['product'] != null
          ? json['product']['name']
          : (json['product_name'] ?? 'Roti Bakery'),
      productImage: json['product'] != null ? json['product']['image_url'] : null,
      quantity: json['quantity'] is int
          ? json['quantity']
          : int.tryParse(json['quantity'].toString()) ?? 1,
      price: (json['price'] as num?)?.toDouble() ?? 0.0,
    );
  }
}

class OrderModel {
  final int id;
  final String orderNumber;
  final double totalAmount;
  final String paymentMethod;
  final String paymentStatus; // pending, paid, failed, expired
  final String? snapToken;
  final String? paymentUrl;
  final String status; // pending, processing, completed, cancelled
  final String shippingAddress;
  final String createdAt;
  final List<OrderItemModel> items;

  OrderModel({
    required this.id,
    required this.orderNumber,
    required this.totalAmount,
    required this.paymentMethod,
    this.paymentStatus = 'pending',
    this.snapToken,
    this.paymentUrl,
    required this.status,
    required this.shippingAddress,
    required this.createdAt,
    required this.items,
  });

  factory OrderModel.fromJson(Map<String, dynamic> json) {
    var rawItems = json['items'] as List? ?? [];
    List<OrderItemModel> itemList =
        rawItems.map((i) => OrderItemModel.fromJson(i)).toList();

    return OrderModel(
      id: json['id'] is int ? json['id'] : int.parse(json['id'].toString()),
      orderNumber: json['order_number'] ?? '',
      totalAmount: (json['total_amount'] as num?)?.toDouble() ?? 0.0,
      paymentMethod: json['payment_method'] ?? 'Midtrans',
      paymentStatus: json['payment_status'] ?? 'pending',
      snapToken: json['snap_token'],
      paymentUrl: json['payment_url'],
      status: json['status'] ?? 'pending',
      shippingAddress: json['shipping_address'] ?? '',
      createdAt: json['created_at'] ?? '',
      items: itemList,
    );
  }
}
