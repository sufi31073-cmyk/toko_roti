<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class OrdersChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Transaksi Penjualan Toko (7 Hari Terakhir)';

    protected function getData(): array
    {
        $dates = collect(range(6, 0))->map(fn ($days) => Carbon::now()->subDays($days)->format('Y-m-d'));
        
        $data = $dates->map(function ($date) {
            return Order::whereDate('created_at', $date)->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pesanan Roti',
                    'data' => $data->toArray(),
                    'fill' => 'start',
                    'borderColor' => '#E91E63',
                    'backgroundColor' => 'rgba(233, 30, 99, 0.1)',
                ],
            ],
            'labels' => $dates->map(fn ($date) => Carbon::parse($date)->format('d M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
