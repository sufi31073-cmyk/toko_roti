import 'package:flutter/material.dart';
import '../config/api_config.dart';
import '../models/category_model.dart';
import '../models/product_model.dart';
import '../services/api_service.dart';

class ProductProvider with ChangeNotifier {
  List<CategoryModel> _categories = [];
  List<ProductModel> _products = [];
  List<ProductModel> _popularProducts = [];
  
  int? _selectedCategoryId;
  String _searchQuery = '';
  bool _isLoading = false;
  String? _errorMessage;

  List<CategoryModel> get categories => _categories;
  List<ProductModel> get products => _products;
  List<ProductModel> get popularProducts => _popularProducts;
  int? get selectedCategoryId => _selectedCategoryId;
  String get searchQuery => _searchQuery;
  bool get isLoading => _isLoading;
  String? get errorMessage => _errorMessage;

  Future<void> fetchCategories() async {
    final result = await ApiService.get(ApiConfig.categories);
    if (result['success'] == true) {
      final List raw = result['data'];
      _categories = raw.map((c) => CategoryModel.fromJson(c)).toList();
      notifyListeners();
    }
  }

  Future<void> fetchPopularProducts() async {
    final result = await ApiService.get(ApiConfig.popularProducts);
    if (result['success'] == true) {
      final List raw = result['data'];
      _popularProducts = raw.map((p) => ProductModel.fromJson(p)).toList();
      notifyListeners();
    }
  }

  Future<void> fetchProducts({int? categoryId, String? search}) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    String url = ApiConfig.products;
    List<String> queryParams = [];

    if (categoryId != null) {
      queryParams.add('category_id=$categoryId');
      _selectedCategoryId = categoryId;
    } else {
      _selectedCategoryId = null;
    }

    if (search != null && search.isNotEmpty) {
      queryParams.add('search=${Uri.encodeComponent(search)}');
      _searchQuery = search;
    } else {
      _searchQuery = '';
    }

    if (queryParams.isNotEmpty) {
      url += '?${queryParams.join('&')}';
    }

    final result = await ApiService.get(url);
    if (result['success'] == true) {
      final List raw = result['data'];
      _products = raw.map((p) => ProductModel.fromJson(p)).toList();
    } else {
      _errorMessage = result['message'];
    }

    _isLoading = false;
    notifyListeners();
  }

  void selectCategory(int? categoryId) {
    if (_selectedCategoryId == categoryId) {
      _selectedCategoryId = null;
    } else {
      _selectedCategoryId = categoryId;
    }
    fetchProducts(categoryId: _selectedCategoryId, search: _searchQuery);
  }

  void searchProducts(String query) {
    _searchQuery = query;
    fetchProducts(categoryId: _selectedCategoryId, search: query);
  }
}
