<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Roti Manis & Bun',
                'slug' => 'roti-manis-bun',
                'icon' => 'bakery_dining',
                'description' => 'Berbagai varian roti manis dengan isian lembut dan aroma harum butter.'
            ],
            [
                'name' => 'Pastry & Croissant',
                'slug' => 'pastry-croissant',
                'icon' => 'breakfast_dining',
                'description' => 'Pastry berlapis renyah luar dengan lelehan butter khas Perancis.'
            ],
            [
                'name' => 'Artisan Bread & Sourdough',
                'slug' => 'artisan-sourdough',
                'icon' => 'grain',
                'description' => 'Roti sehat hasil fermentasi alami dengan crust renyah dan tekstur chewy.'
            ],
            [
                'name' => 'Cake & Tart',
                'slug' => 'cake-tart',
                'icon' => 'cake',
                'description' => 'Kue ulang tahun & dessert manis yang cantik serta meleleh di mulut.'
            ],
            [
                'name' => 'Kopi & Minuman',
                'slug' => 'kopi-minuman',
                'icon' => 'local_cafe',
                'description' => 'Minuman pendamping sempurna untuk menikmati sajian roti kesukaanmu.'
            ],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
