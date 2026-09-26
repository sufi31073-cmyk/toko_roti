import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'dart:async';
import '../../theme/app_theme.dart';
import '../main_navigation.dart';

class SplashScreen extends StatefulWidget {
  const SplashScreen({Key? key}) : super(key: key);

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  @override
  void initState() {
    super.initState();
    Timer(const Duration(seconds: 3), () {
      Navigator.of(context).pushReplacement(
        MaterialPageRoute(builder: (context) => const MainNavigation()),
      );
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        width: double.infinity,
        height: double.infinity,
        decoration: const BoxDecoration(
          gradient: AppTheme.splashGradient,
        ),
        child: Stack(
          children: [
            // Decorative frosting drip at the top
            Positioned(
              top: 0,
              left: 0,
              right: 0,
              height: 150,
              child: CustomPaint(
                painter: FrostingPainter(),
              ),
            ),
            
            // Elegant background accents
            Positioned(
              top: 150, left: 40, 
              child: Icon(Icons.bakery_dining_rounded, size: 36, color: Colors.white.withValues(alpha: 0.15)),
            ),
            Positioned(
              top: 220, right: 50, 
              child: Icon(Icons.cookie_outlined, size: 42, color: Colors.white.withValues(alpha: 0.15)),
            ),
            Positioned(
              bottom: 180, left: 60, 
              child: Icon(Icons.cake_outlined, size: 38, color: Colors.white.withValues(alpha: 0.15)),
            ),
            Positioned(
              bottom: 250, right: 40, 
              child: Icon(Icons.lunch_dining_outlined, size: 32, color: Colors.white.withValues(alpha: 0.15)),
            ),
            
            // Center Logo & Text
            Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Container(
                    width: 88,
                    height: 88,
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(28),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withValues(alpha: 0.15),
                          blurRadius: 20,
                          offset: const Offset(0, 8),
                        ),
                      ],
                    ),
                    child: const Icon(
                      Icons.bakery_dining_rounded,
                      size: 48,
                      color: AppTheme.primary,
                    ),
                  ),
                  const SizedBox(height: 20),
                  Text(
                    'Dea Bakery',
                    style: GoogleFonts.playfairDisplay(
                      fontSize: 44,
                      fontWeight: FontWeight.bold,
                      color: Colors.white,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    'Freshly Baked with Love',
                    style: GoogleFonts.plusJakartaSans(
                      fontSize: 15,
                      color: Colors.white.withValues(alpha: 0.9),
                      fontWeight: FontWeight.w600,
                      letterSpacing: 0.5,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class FrostingPainter extends CustomPainter {
  @override
  void paint(Canvas canvas, Size size) {
    final paint = Paint()
      ..color = Colors.white
      ..style = PaintingStyle.fill;

    final path = Path();
    path.moveTo(0, 0);
    path.lineTo(0, 80);
    
    path.quadraticBezierTo(size.width * 0.125, 120, size.width * 0.25, 70);
    path.quadraticBezierTo(size.width * 0.375, 40, size.width * 0.5, 90);
    path.quadraticBezierTo(size.width * 0.625, 130, size.width * 0.75, 60);
    path.quadraticBezierTo(size.width * 0.875, 20, size.width, 100);
    
    path.lineTo(size.width, 0);
    path.close();

    canvas.drawPath(path, paint);
  }

  @override
  bool shouldRepaint(covariant CustomPainter oldDelegate) => false;
}
