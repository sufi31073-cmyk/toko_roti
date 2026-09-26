import 'package:flutter/material.dart';
import '../../models/category_model.dart';
import '../../theme/app_theme.dart';

class CategoryChip extends StatelessWidget {
  final CategoryModel? category;
  final bool isSelected;
  final VoidCallback onTap;

  const CategoryChip({
    Key? key,
    required this.category,
    required this.isSelected,
    required this.onTap,
  }) : super(key: key);

  IconData _getCategoryIcon(String? slug) {
    switch (slug) {
      case 'roti-manis-bun':
        return Icons.bakery_dining_rounded;
      case 'pastry-croissant':
        return Icons.breakfast_dining_rounded;
      case 'artisan-sourdough':
        return Icons.lunch_dining_rounded;
      case 'cake-tart':
        return Icons.cake_rounded;
      case 'kopi-minuman':
        return Icons.local_cafe_rounded;
      default:
        return Icons.fastfood_rounded;
    }
  }

  @override
  Widget build(BuildContext context) {
    final title = category == null ? 'Semua Menu' : category!.name;
    final iconData = category == null ? Icons.grid_view_rounded : _getCategoryIcon(category!.slug);

    return Container(
      margin: const EdgeInsets.only(right: 10),
      child: Material(
        color: Colors.transparent,
        child: InkWell(
          onTap: onTap,
          borderRadius: BorderRadius.circular(24),
          child: AnimatedContainer(
            duration: const Duration(milliseconds: 200),
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
            decoration: BoxDecoration(
              gradient: isSelected
                  ? const LinearGradient(
                      colors: [AppTheme.primary, AppTheme.primaryDark],
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight,
                    )
                  : null,
              color: isSelected ? null : Colors.white,
              borderRadius: BorderRadius.circular(24),
              border: Border.all(
                color: isSelected
                    ? Colors.transparent
                    : AppTheme.primaryLight.withOpacity(0.4),
                width: 1.2,
              ),
              boxShadow: isSelected
                  ? [
                      BoxShadow(
                        color: AppTheme.primary.withOpacity(0.28),
                        blurRadius: 8,
                        offset: const Offset(0, 3),
                      )
                    ]
                  : [
                      BoxShadow(
                        color: Colors.black.withOpacity(0.02),
                        blurRadius: 4,
                        offset: const Offset(0, 1),
                      )
                    ],
            ),
            child: Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                Icon(
                  iconData,
                  size: 18,
                  color: isSelected ? Colors.white : AppTheme.primary,
                ),
                const SizedBox(width: 8),
                Text(
                  title,
                  style: TextStyle(
                    fontSize: 13,
                    fontWeight: isSelected ? FontWeight.bold : FontWeight.w600,
                    color: isSelected ? Colors.white : AppTheme.textPrimary,
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}

