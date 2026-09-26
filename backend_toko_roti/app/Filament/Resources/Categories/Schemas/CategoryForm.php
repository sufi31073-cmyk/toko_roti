<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('URL Slug')
                    ->required()
                    ->maxLength(255),

                TextInput::make('icon')
                    ->label('Ikon (Material/Bakery)')
                    ->placeholder('bakery_dining'),

                Textarea::make('description')
                    ->label('Deskripsi Kategori')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
