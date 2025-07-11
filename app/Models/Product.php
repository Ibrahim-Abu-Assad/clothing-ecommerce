<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'brand_id',
        'category_id',
        'price',
        'stock',
    ];

    // Product relationship with brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Product relationship with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product relationship with images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Product relationship with variations
    public function variations()
    {
        return $this->hasMany(ProductColorSize::class);
    }

    // Product relationship with colors
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color_size')->withTimestamps();
    }

    // Product relationship with sizes
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_color_size')->withTimestamps();
    }
}
