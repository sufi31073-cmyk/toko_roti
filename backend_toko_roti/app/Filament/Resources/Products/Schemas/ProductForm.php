<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori Roti')
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('name')
                    ->label('Nama Produk Roti')
                    ->required()
                    ->maxLength(255),

                TextInput::make('price')
                    ->label('Harga Utama')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                TextInput::make('discount_price')
                    ->label('Harga Coret / Promo (Opsional)')
                    ->numeric()
                    ->prefix('Rp'),

                TextInput::make('stock')
                    ->label('Stok Stok Roti')
                    ->numeric()
                    ->default(100)
                    ->required(),

                TextInput::make('rating')
                    ->label('Rating Produk')
                    ->numeric()
                    ->default(5.0)
                    ->step(0.1),

                Toggle::make('is_popular')
                    ->label('Tampilkan sebagai Produk Promo Terpopuler')
                    ->default(true),

                TextInput::make('image_url')
                    ->label('URL Gambar Produk (Unsplash / Cloud)')
                    ->url()
                    ->placeholder('https://images.unsplash.com/photo-...')
                    ->columnSpanFull()
                    ->required(),

                Textarea::make('description')
                    ->label('Deskripsi Lengkap Roti')
                    ->rows(4)
                    ->columnSpanFull()
                    ->required(),
            ]);
    }
}
