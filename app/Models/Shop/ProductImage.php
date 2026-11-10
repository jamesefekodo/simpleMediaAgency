<?php

namespace App\Models\Shop;

use App\Models\Shop\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = [
        'product_slug',
        'path',
        'alt_text',
        'position',
        'is_primary',
    ];

    protected $casts = [
        'position' => 'integer',
        'is_primary' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_slug', 'slug');
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
