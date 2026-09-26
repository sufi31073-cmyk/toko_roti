import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:provider/provider.dart';
import 'package:url_launcher/url_launcher.dart';
import '../../providers/auth_provider.dart';
import '../../providers/cart_provider.dart';
import '../../providers/order_provider.dart';
import '../../theme/app_theme.dart';
import '../orders/order_detail_screen.dart';

class CheckoutScreen extends StatefulWidget {
  const CheckoutScreen({Key? key}) : super(key: key);

  @override
  State<CheckoutScreen> createState() => _CheckoutScreenState();
}

class _CheckoutScreenState extends State<CheckoutScreen> {
  String _selectedPaymentMethod = 'Midtrans Automatic Payment (QRIS / GoPay / ShopeePay / Bank Transfer)';
  final _addressController = TextEditingController();
  final _formKey = GlobalKey<FormState>();

  final List<Map<String, dynamic>> _paymentOptions = [
    {
      'title': 'Midtrans Payment Gateway (Otomatis)',
      'subtitle': 'QRIS, GoPay, ShopeePay, Bank BCA/Mandiri/BNI/BRI, Indomaret',
      'icon': Icons.payment_rounded,
      'isDefault': true,
    },
    {
      'title': 'Bayar di Tempat (COD)',
      'subtitle': 'Bayar tunai saat roti diantarkan ke alamat Anda',
      'icon': Icons.local_shipping_rounded,
      'isDefault': false,
    },
  ];

  @override
  void initState() {
    super.initState();
    final auth = Provider.of<AuthProvider>(context, listen: false);
    if (auth.user?.address != null) {
      _addressController.text = auth.user!.address!;
    }
  }

  Future<void> _launchMidtransUrl(String urlString) async {
    final Uri url = Uri.parse(urlString);
    try {
      bool launched = await launchUrl(url, mode: LaunchMode.inAppBrowserView);
      if (!launched) {
        launched = await launchUrl(url, mode: LaunchMode.inAppWebView);
      }
      if (!launched) {
        await launchUrl(url, mode: LaunchMode.platformDefault);
      }
    } catch (_) {
      try {
        await launchUrl(url, mode: LaunchMode.inAppWebView);
      } catch (_) {}
    }
  }

  @override
  Widget build(BuildContext context) {
    final cartProvider = Provider.of<CartProvider>(context);
    final authProvider = Provider.of<AuthProvider>(context);
    final orderProvider = Provider.of<OrderProvider>(context);

    final currencyFormatter = NumberFormat.currency(
      locale: 'id_ID',
      symbol: 'Rp ',
      decimalDigits: 0,
    );

    return Scaffold(
      backgroundColor: AppTheme.background,
      appBar: AppBar(
        title: const Text('Pembayaran & Pengiriman', style: TextStyle(fontWeight: FontWeight.w900, fontSize: 18)),
        backgroundColor: Colors.transparent,
      ),
      body: Form(
        key: _formKey,
        child: ListView(
          padding: const EdgeInsets.all(20),
          physics: const BouncingScrollPhysics(),
          children: [
            // Delivery Address Card
            const Text('Alamat Pengiriman Roti', style: TextStyle(fontWeight: FontWeight.w800, fontSize: 15)),
            const SizedBox(height: 10),
            Container(
              padding: const EdgeInsets.all(16),
              decoration: AppTheme.cardDecoration,
              child: Row(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Container(
                    padding: const EdgeInsets.all(8),
                    decoration: BoxDecoration(
                      color: AppTheme.primarySoft,
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: const Icon(Icons.location_on_rounded, color: AppTheme.primary, size: 22),
                  ),
                  const SizedBox(width: 14),
                  Expanded(
                    child: TextFormField(
                      controller: _addressController,
                      maxLines: 2,
                      style: const TextStyle(fontWeight: FontWeight.w600, fontSize: 13.5),
                      decoration: const InputDecoration(
                        hintText: 'Tuliskan alamat lengkap pengiriman...',
                        hintStyle: TextStyle(fontSize: 12.5, color: AppTheme.textMuted),
                        border: InputBorder.none,
                        enabledBorder: InputBorder.none,
                        focusedBorder: InputBorder.none,
                        contentPadding: EdgeInsets.zero,
                        filled: false,
                      ),
                      validator: (v) => v == null || v.trim().isEmpty ? 'Mohon isi alamat pengiriman' : null,
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 24),

            // Payment Method
            const Text('Metode Pembayaran', style: TextStyle(fontWeight: FontWeight.w800, fontSize: 15)),
            const SizedBox(height: 10),
            ..._paymentOptions.map((option) {
              final title = option['title'] as String;
              final isSelected = _selectedPaymentMethod == title;
              return GestureDetector(
                onTap: () => setState(() => _selectedPaymentMethod = title),
                child: Container(
                  margin: const EdgeInsets.only(bottom: 12),
                  padding: const EdgeInsets.all(16),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(color: isSelected ? AppTheme.primary : const Color(0xFFF3ECE5), width: 1.5),
                    boxShadow: [
                      if (isSelected) BoxShadow(color: AppTheme.primary.withValues(alpha: 0.12), blurRadius: 10, offset: const Offset(0, 3))
                    ],
                  ),
                  child: Row(
                    children: [
                      Container(
                        padding: const EdgeInsets.all(10),
                        decoration: BoxDecoration(
                          color: isSelected ? AppTheme.primarySoft : const Color(0xFFF5F5F4),
                          shape: BoxShape.circle,
                        ),
                        child: Icon(option['icon'] as IconData, color: isSelected ? AppTheme.primary : AppTheme.textSecondary, size: 20),
                      ),
                      const SizedBox(width: 14),
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(title, style: const TextStyle(fontWeight: FontWeight.w800, fontSize: 13.5)),
                            const SizedBox(height: 3),
                            Text(option['subtitle'] as String, style: const TextStyle(fontSize: 11, color: AppTheme.textSecondary)),
                          ],
                        ),
                      ),
                      Radio<String>(
                        value: title,
                        groupValue: _selectedPaymentMethod,
                        activeColor: AppTheme.primary,
                        onChanged: (val) {
                          if (val != null) setState(() => _selectedPaymentMethod = val);
                        },
                      )
                    ],
                  ),
                ),
              );
            }).toList(),
            const SizedBox(height: 24),

            // Order Summary Readonly
            const Text('Ringkasan Pesanan', style: TextStyle(fontWeight: FontWeight.w800, fontSize: 15)),
            const SizedBox(height: 10),
            Container(
              padding: const EdgeInsets.all(18),
              decoration: AppTheme.cardDecoration,
              child: Column(
                children: [
                  ...cartProvider.items.map((item) => Padding(
                    padding: const EdgeInsets.only(bottom: 10),
                    child: Row(
                      children: [
                        Text('${item.quantity}x', style: const TextStyle(fontWeight: FontWeight.w900, color: AppTheme.primary, fontSize: 13)),
                        const SizedBox(width: 10),
                        Expanded(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(item.product.name, style: const TextStyle(fontWeight: FontWeight.w700, fontSize: 13)),
                              if (item.note != null && item.note!.isNotEmpty)
                                Text(item.note!, style: const TextStyle(fontSize: 10.5, color: AppTheme.textSecondary)),
                            ],
                          ),
                        ),
                        Text(currencyFormatter.format(item.product.effectivePrice * item.quantity), style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 13)),
                      ],
                    ),
                  )),
                  const Divider(color: Color(0xFFF3ECE5), thickness: 1.2, height: 20),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      const Text('Total Pembayaran', style: TextStyle(fontWeight: FontWeight.w800, fontSize: 14)),
                      Text(currencyFormatter.format(cartProvider.grandTotal), style: const TextStyle(fontWeight: FontWeight.w900, fontSize: 18, color: AppTheme.primary)),
                    ],
                  ),
                ],
              ),
            ),
            const SizedBox(height: 32),

            // Place Order Button
            InkWell(
              onTap: orderProvider.isLoading
                  ? null
                  : () async {
                      if (_formKey.currentState!.validate()) {
                        final itemsData = cartProvider.items
                            .map((item) => {
                                  'product_id': item.product.id,
                                  'quantity': item.quantity,
                                })
                            .toList();

                        final result = await orderProvider.createOrder(
                          token: authProvider.token!,
                          items: itemsData,
                          paymentMethod: _selectedPaymentMethod,
                          shippingAddress: _addressController.text.trim(),
                        );

                        if (result['success'] == true) {
                          cartProvider.clearCart();
                          final order = result['order'];
                          final paymentUrl = result['payment_url'];

                          if (paymentUrl != null) {
                            _launchMidtransUrl(paymentUrl);
                          }

                          if (mounted) {
                            Navigator.pushReplacement(
                              context,
                              MaterialPageRoute(
                                builder: (_) => OrderDetailScreen(
                                  order: order,
                                  isNewOrder: true,
                                ),
                              ),
                            );
                          }
                        } else {
                          ScaffoldMessenger.of(context).showSnackBar(
                            SnackBar(content: Text(result['message'] ?? 'Gagal membuat pesanan'), backgroundColor: Colors.red),
                          );
                        }
                      }
                    },
              borderRadius: BorderRadius.circular(24),
              child: Container(
                width: double.infinity,
                height: 54,
                decoration: BoxDecoration(
                  gradient: AppTheme.primaryGradient,
                  borderRadius: BorderRadius.circular(24),
                  boxShadow: [
                    BoxShadow(
                      color: AppTheme.primary.withValues(alpha: 0.35),
                      blurRadius: 12,
                      offset: const Offset(0, 4),
                    ),
                  ],
                ),
                alignment: Alignment.center,
                child: orderProvider.isLoading
                    ? const SizedBox(width: 22, height: 22, child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2.5))
                    : const Text(
                        'Konfirmasi & Bayar Sekarang →',
                        style: TextStyle(color: Colors.white, fontSize: 15, fontWeight: FontWeight.w800),
                      ),
              ),
            ),
            const SizedBox(height: 24),
          ],
        ),
      ),
    );
  }
}
