<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Admin User
        User::create([
            'name' => 'Admin Bakery Store',
            'email' => 'admin@bakery.com',
            'password' => Hash::make('admin123'),
            'phone' => '081122334455',
            'address' => 'Kantor Pusat Toko Roti, Jakarta',
            'is_admin' => true,
        ]);

        // Seed Default Customer User
        User::create([
            'name' => 'Ahmad Bakery User',
            'email' => 'user@bakery.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567890',
            'address' => 'Jl. Mawar No. 12, Jakarta Selatan',
            'is_admin' => false,
        ]);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
