<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Pelanggan')
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('order_number')
                    ->label('Nomor Pesanan')
                    ->readOnly()
                    ->required(),

                TextInput::make('total_amount')
                    ->label('Total Pembayaran')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'midtrans' => 'Midtrans Payment Gateway',
                        'cod' => 'Bayar di Tempat (COD)',
                    ])
                    ->required(),

                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Belum Dibayar',
                        'paid' => 'Sudah Dibayar (Lunas)',
                        'failed' => 'Gagal / Dibatalkan',
                    ])
                    ->required(),

                Select::make('status')
                    ->label('Status Pesanan Toko')
                    ->options([
                        'pending' => 'Menunggu Pembayaran',
                        'processing' => 'Sedang Diproses (Dipanggang)',
                        'shipped' => 'Dalam Pengiriman (Kurir)',
                        'completed' => 'Pesanan Selesai',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->required(),

                TextInput::make('snap_token')
                    ->label('Midtrans Snap Token')
                    ->readOnly(),

                TextInput::make('payment_url')
                    ->label('Midtrans Payment URL')
                    ->url()
                    ->readOnly(),

                Textarea::make('shipping_address')
                    ->label('Alamat Pengiriman Lengkap')
                    ->rows(3)
                    ->columnSpanFull()
                    ->required(),
            ]);
    }
}
