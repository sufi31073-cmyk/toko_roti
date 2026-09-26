<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::count();

        return [
            Stat::make('Total Pendapatan (Lunas)', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Pendapatan dari transaksi lunas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Pesanan Masuk', $totalOrders . ' Order')
                ->description('Jumlah transaksi pesanan toko')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning'),

            Stat::make('Produk Katalog Roti', $totalProducts . ' Item')
                ->description('Variasi roti & cake tersedia')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('primary'),

            Stat::make('Pelanggan Terdaftar', $totalUsers . ' Pengguna')
                ->description('Akun terdaftar di Dea Bakery')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
        ];
    }
}
