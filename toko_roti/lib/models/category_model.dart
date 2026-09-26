class CategoryModel {
  final int id;
  final String name;
  final String slug;
  final String? icon;
  final String? description;

  CategoryModel({
    required this.id,
    required this.name,
    required this.slug,
    this.icon,
    this.description,
  });

  factory CategoryModel.fromJson(Map<String, dynamic> json) {
    return CategoryModel(
      id: json['id'] is int ? json['id'] : int.parse(json['id'].toString()),
      name: json['name'] ?? '',
      slug: json['slug'] ?? '',
      icon: json['icon'],
      description: json['description'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'slug': slug,
      'icon': icon,
      'description': description,
    };
  }
}
