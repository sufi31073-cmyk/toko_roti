<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Roti Manis & Bun (category_id 1)
            [
                'category_id' => 1,
                'name' => 'Classic Butter Milk Bun',
                'description' => 'Roti manis bantal super lembut dengan isian mentega wijen dan vanila manis alami.',
                'price' => 18000,
                'discount_price' => 15000,
                'stock' => 45,
                'image_url' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=600&q=80',
                'is_popular' => true,
                'rating' => 4.9,
            ],
            [
                'category_id' => 1,
                'name' => 'Cinnamon Sugar Roll',
                'description' => 'Gulungan roti rempah kayu manis khas Skandinavia dilapisi gula glazed hangat.',
                'price' => 22000,
                'discount_price' => null,
                'stock' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1509365465985-25d11c17e812?auto=format&fit=crop&w=600&q=80',
                'is_popular' => true,
                'rating' => 4.8,
            ],
            [
                'category_id' => 1,
                'name' => 'Choco Melt Fluffy Bread',
                'description' => 'Roti manis isi cokelat 벨기에 leleh berlimpah yang sangat menggugah selera.',
                'price' => 20000,
                'discount_price' => 18000,
                'stock' => 50,
                'image_url' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&w=600&q=80',
                'is_popular' => true,
                'rating' => 4.9,
            ],

            // Pastry & Croissant (category_id 2)
            [
                'category_id' => 2,
                'name' => 'French Butter Croissant',
                'description' => 'Croissant autentik Perancis dengan 81 lapisan renyah dan aroma Elle & Vire butter.',
                'price' => 28000,
                'discount_price' => 24000,
                'stock' => 40,
                'image_url' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=600&q=80',
                'is_popular' => true,
                'rating' => 5.0,
            ],
            [
                'category_id' => 2,
                'name' => 'Almond Cream Croissant',
                'description' => 'Croissant renyah bertabur irisan almond panggang dan isian frangipane manis gurih.',
                'price' => 34000,
                'discount_price' => null,
                'stock' => 25,
                'image_url' => 'https://images.unsplash.com/photo-1530610476181-d83430b64dcd?auto=format&fit=crop&w=600&q=80',
                'is_popular' => true,
                'rating' => 4.9,
            ],
            [
                'category_id' => 2,
                'name' => 'Pain au Chocolat Premium',
                'description' => 'Pastry puff klasik dengan dua batang cokelat hitam Belgium kualitas ekspor.',
                'price' => 30000,
                'discount_price' => null,
                'stock' => 35,
                'image_url' => 'https://images.unsplash.com/photo-1608198093002-ad4e005484ec?auto=format&fit=crop&w=600&q=80',
                'is_popular' => false,
                'rating' => 4.7,
            ],

            // Artisan & Sourdough (category_id 3)
            [
                'category_id' => 3,
                'name' => 'Country Rustic Sourdough',
                'description' => 'Roti fermentasi alami ragi liar 36 jam. Rendah gula, ramah pencernaan dan tinggi serat.',
                'price' => 45000,
                'discount_price' => 40000,
                'stock' => 20,
                'image_url' => 'https://images.unsplash.com/photo-1585478259715-876acc5be8eb?auto=format&fit=crop&w=600&q=80',
                'is_popular' => true,
                'rating' => 4.9,
            ],
            [
                'category_id' => 3,
                'name' => 'Multigrain Seeded Loaf',
                'description' => 'Roti tawar gandum utuh dengan biji bunga matahari, chia seed, dan flaxseed sehat.',
                'price' => 38000,
                'discount_price' => null,
                'stock' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=600&q=80',
                'is_popular' => false,
                'rating' => 4.8,
            ],

            // Cake & Tart (category_id 4)
            [
                'category_id' => 4,
                'name' => 'Signature Basque Cheesecake',
                'description' => 'Cheesecake panggang ala Spanyol dengan permukaan gosong caramelized & tengah creamy lembut.',
                'price' => 65000,
                'discount_price' => 58000,
                'stock' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&w=600&q=80',
                'is_popular' => true,
                'rating' => 5.0,
            ],
            [
                'category_id' => 4,
                'name' => 'Fresh Berry Fruit Tart',
                'description' => 'Pie crusted garing berisi custard vanila lembut dan topping strawberry & blueberry segar.',
                'price' => 42000,
                'discount_price' => null,
                'stock' => 18,
                'image_url' => 'https://images.unsplash.com/photo-1519869325930-281384150729?auto=format&fit=crop&w=600&q=80',
                'is_popular' => false,
                'rating' => 4.7,
            ],

            // Kopi & Minuman (category_id 5)
            [
                'category_id' => 5,
                'name' => 'Iced Gula Aren Latte',
                'description' => 'Espresso house blend 100% Arabika disajikan dengan susu segar dan sirup gula aren asli.',
                'price' => 25000,
                'discount_price' => 20000,
                'stock' => 60,
                'image_url' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&w=600&q=80',
                'is_popular' => true,
                'rating' => 4.9,
            ],
            [
                'category_id' => 5,
                'name' => 'Matcha Oat Milk Latte',
                'description' => 'Teh matcha Ceremonial grade dari Uji, Jepang dikocok halus dengan susu gandum gurih.',
                'price' => 32000,
                'discount_price' => null,
                'stock' => 40,
                'image_url' => 'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?auto=format&fit=crop&w=600&q=80',
                'is_popular' => false,
                'rating' => 4.8,
            ],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}
