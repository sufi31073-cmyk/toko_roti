import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:intl/intl.dart';
import 'package:url_launcher/url_launcher.dart';
import '../../models/order_model.dart';
import '../../theme/app_theme.dart';
import '../main_navigation.dart';

class OrderDetailScreen extends StatelessWidget {
  final OrderModel order;
  final bool isNewOrder;

  const OrderDetailScreen({
    Key? key,
    required this.order,
    this.isNewOrder = false,
  }) : super(key: key);

  Future<void> _launchPaymentUrl(BuildContext context, String urlString) async {
    final Uri url = Uri.parse(urlString);
    try {
      bool launched = await launchUrl(url, mode: LaunchMode.inAppBrowserView);
      if (!launched) launched = await launchUrl(url, mode: LaunchMode.inAppWebView);
      if (!launched) launched = await launchUrl(url, mode: LaunchMode.platformDefault);
      if (!launched && context.mounted) _showPaymentLinkDialog(context, urlString);
    } catch (_) {
      try {
        await launchUrl(url, mode: LaunchMode.inAppWebView);
      } catch (_) {
        if (context.mounted) _showPaymentLinkDialog(context, urlString);
      }
    }
  }

  void _showPaymentLinkDialog(BuildContext context, String urlString) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Midtrans Payment Link'),
        content: SelectableText(urlString),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text('Close')),
          ElevatedButton(
            onPressed: () {
              Clipboard.setData(ClipboardData(text: urlString));
              Navigator.pop(context);
            },
            child: const Text('Copy Link'),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final currencyFormatter = NumberFormat.currency(locale: 'id_ID', symbol: 'Rp ', decimalDigits: 0);
    final isPaid = order.paymentStatus.toLowerCase() == 'paid';
    
    // Status mapping
    int currentStep = 0;
    final status = order.status.toLowerCase();
    if (status == 'processing') currentStep = 1;
    if (status == 'completed') currentStep = 3; // For demo purpose let's assume it jumps to delivered.

    return Scaffold(
      backgroundColor: AppTheme.background,
      appBar: AppBar(
        title: const Text('Order Tracking', style: TextStyle(fontWeight: FontWeight.w900, color: AppTheme.primary)),
        backgroundColor: Colors.transparent,
        iconTheme: const IconThemeData(color: AppTheme.primary),
        actions: [
          IconButton(
            icon: const Icon(Icons.home_rounded, color: AppTheme.primary),
            onPressed: () => Navigator.pushAndRemoveUntil(context, MaterialPageRoute(builder: (_) => const MainNavigation()), (route) => false),
          ),
        ],
      ),
      body: ListView(
        padding: const EdgeInsets.all(20),
        physics: const BouncingScrollPhysics(),
        children: [
          // Delivery Illustration
          Container(
            padding: const EdgeInsets.all(24),
            decoration: BoxDecoration(
              gradient: AppTheme.primaryGradient,
              borderRadius: BorderRadius.circular(30),
            ),
            child: Column(
              children: const [
                Icon(Icons.delivery_dining_rounded, size: 56, color: Colors.white),
                SizedBox(height: 12),
                Text('Your order is on its way!', style: TextStyle(color: Colors.white, fontSize: 16, fontWeight: FontWeight.bold)),
                SizedBox(height: 4),
                Text('Arriving in 25-30 min', style: TextStyle(color: Colors.white, fontSize: 24, fontWeight: FontWeight.w900)),
              ],
            ),
          ),
          const SizedBox(height: 32),

          // Timeline Stepper
          _buildStepper('Order Confirmed', currentStep >= 0, currentStep == 0),
          _buildStepperLine(),
          _buildStepper('Preparing Your Order', currentStep >= 1, currentStep == 1),
          _buildStepperLine(),
          _buildStepper('Out for Delivery', currentStep >= 2, currentStep == 2),
          _buildStepperLine(),
          _buildStepper('Delivered', currentStep >= 3, currentStep == 3),
          const SizedBox(height: 32),

          // Midtrans Payment Action if pending
          if (!isPaid && order.paymentUrl != null)
            InkWell(
              onTap: () => _launchPaymentUrl(context, order.paymentUrl!),
              borderRadius: BorderRadius.circular(20),
              child: Container(
                margin: const EdgeInsets.only(bottom: 24),
                padding: const EdgeInsets.all(20),
                decoration: BoxDecoration(
                  color: AppTheme.primarySoft,
                  borderRadius: BorderRadius.circular(20),
                  border: Border.all(color: AppTheme.primary, width: 2),
                ),
                child: Row(
                  children: const [
                    Icon(Icons.payment_rounded, color: AppTheme.primary, size: 30),
                    SizedBox(width: 16),
                    Expanded(
                      child: Text(
                        'Complete Payment via Midtrans',
                        style: TextStyle(color: AppTheme.primary, fontWeight: FontWeight.w900, fontSize: 16),
                      ),
                    ),
                    Icon(Icons.chevron_right_rounded, color: AppTheme.primary),
                  ],
                ),
              ),
            ),

          // Delivery Address Card
          const Text('Delivery Address', style: TextStyle(fontWeight: FontWeight.w900, fontSize: 16)),
          const SizedBox(height: 12),
          Container(
            padding: const EdgeInsets.all(20),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(20),
              border: Border.all(color: AppTheme.primarySoft, width: 2),
            ),
            child: Row(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Icon(Icons.location_on_rounded, color: AppTheme.primary, size: 28),
                const SizedBox(width: 16),
                Expanded(child: Text(order.shippingAddress, style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 14))),
              ],
            ),
          ),
          const SizedBox(height: 24),

          // Item list with thumbnails
          const Text('Items', style: TextStyle(fontWeight: FontWeight.w900, fontSize: 16)),
          const SizedBox(height: 12),
          Container(
            padding: const EdgeInsets.all(20),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(20),
            ),
            child: Column(
              children: order.items.map((item) {
                return Padding(
                  padding: const EdgeInsets.only(bottom: 16),
                  child: Row(
                    children: [
                      Container(
                        width: 50,
                        height: 50,
                        decoration: const BoxDecoration(
                          color: AppTheme.primarySoft,
                          shape: BoxShape.circle,
                        ),
                        child: const Icon(Icons.bakery_dining_rounded, color: AppTheme.primary),
                      ),
                      const SizedBox(width: 16),
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(item.productName, style: const TextStyle(fontWeight: FontWeight.w900, fontSize: 15)),
                            const SizedBox(height: 4),
                            Text('${item.quantity}x @ ${currencyFormatter.format(item.price)}', style: const TextStyle(color: AppTheme.textSecondary, fontWeight: FontWeight.bold, fontSize: 12)),
                          ],
                        ),
                      ),
                      Text(currencyFormatter.format(item.price * item.quantity), style: const TextStyle(fontWeight: FontWeight.w900, fontSize: 15, color: AppTheme.primary)),
                    ],
                  ),
                );
              }).toList(),
            ),
          ),
          const SizedBox(height: 32),
        ],
      ),
    );
  }

  Widget _buildStepper(String title, bool isCompleted, bool isActive) {
    return Row(
      children: [
        Container(
          width: 32,
          height: 32,
          decoration: BoxDecoration(
            color: isCompleted ? AppTheme.success : (isActive ? AppTheme.primarySoft : Colors.grey.shade300),
            shape: BoxShape.circle,
          ),
          child: isCompleted 
            ? const Icon(Icons.check_rounded, color: Colors.white, size: 20)
            : (isActive ? const Icon(Icons.circle, color: AppTheme.primary, size: 12) : null),
        ),
        const SizedBox(width: 16),
        Text(
          title,
          style: TextStyle(
            fontWeight: isActive || isCompleted ? FontWeight.w900 : FontWeight.bold,
            fontSize: 16,
            color: isActive ? AppTheme.primary : (isCompleted ? AppTheme.textPrimary : Colors.grey),
          ),
        ),
      ],
    );
  }

  Widget _buildStepperLine() {
    return Container(
      margin: const EdgeInsets.only(left: 15, top: 4, bottom: 4),
      width: 2,
      height: 30,
      color: Colors.grey.shade300,
    );
  }
}
