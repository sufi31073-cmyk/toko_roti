<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;
use App\Models\StockHistory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'discount_price',
        'stock',
        'image_url',
        'is_popular',
        'rating',
    ];

    protected $casts = [
        'price' => 'float',
        'discount_price' => 'float',
        'is_popular' => 'boolean',
        'rating' => 'float',
        'stock' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product images relationship
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Stock history relationship
    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class);
    }
}
