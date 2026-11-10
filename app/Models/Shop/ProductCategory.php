<?php

namespace App\Models\Shop;

use App\Models\Shop\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'product_categories';
    protected $fillable = [
        'slug',
        'name',
        'description',
        // 'is_active',
        'image'
    ];

    // uuid
    protected static function booted(): void
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = 'prcat-' . Str::uuid();
            }
        });
    }

    protected function casts(): array
    {
        return [
            // 'is_active' => 'boolean',
        ];
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'category_product',
            'product_category_slug',
            'product_slug',
            'slug',
            'slug'
        );
    }
}
