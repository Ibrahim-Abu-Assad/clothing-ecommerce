<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection; // Add this import if not already present

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'brand_id',
        'category_id',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'product_color_size', 'product_id', 'color_id')
                    ->withPivot('size_id')
                    ->distinct(); // ADD THIS LINE
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'product_color_size', 'product_id', 'size_id')
                    ->withPivot('color_id')
                    ->distinct(); // ADD THIS LINE
    }

    public function firstImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->oldestOfMany();
    }
}
