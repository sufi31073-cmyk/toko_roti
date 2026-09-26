class ProductModel {
  final int id;
  final int categoryId;
  final String name;
  final String description;
  final double price;
  final double? discountPrice;
  final int stock;
  final String imageUrl;
  final bool isPopular;
  final double rating;
  final String? categoryName;

  ProductModel({
    required this.id,
    required this.categoryId,
    required this.name,
    required this.description,
    required this.price,
    this.discountPrice,
    required this.stock,
    required this.imageUrl,
    this.isPopular = false,
    this.rating = 4.5,
    this.categoryName,
  });

  factory ProductModel.fromJson(Map<String, dynamic> json) {
    return ProductModel(
      id: json['id'] is int ? json['id'] : int.parse(json['id'].toString()),
      categoryId: json['category_id'] is int
          ? json['category_id']
          : int.parse(json['category_id'].toString()),
      name: json['name'] ?? '',
      description: json['description'] ?? '',
      price: (json['price'] as num?)?.toDouble() ?? 0.0,
      discountPrice: json['discount_price'] != null
          ? (json['discount_price'] as num).toDouble()
          : null,
      stock: json['stock'] is int
          ? json['stock']
          : int.tryParse(json['stock'].toString()) ?? 0,
      imageUrl: json['image_url'] ?? '',
      isPopular: json['is_popular'] == true || json['is_popular'] == 1,
      rating: (json['rating'] as num?)?.toDouble() ?? 4.8,
      categoryName: json['category'] != null ? json['category']['name'] : null,
    );
  }

  bool get hasDiscount => discountPrice != null && discountPrice! < price;
  double get effectivePrice => hasDiscount ? discountPrice! : price;

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'category_id': categoryId,
      'name': name,
      'description': description,
      'price': price,
      'discount_price': discountPrice,
      'stock': stock,
      'image_url': imageUrl,
      'is_popular': isPopular,
      'rating': rating,
    };
  }
}
