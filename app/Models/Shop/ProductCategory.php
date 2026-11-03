<?php

namespace App\Models\Shop;

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

    // public function categoryProducts()
    // {
    //     return $this->hasMany(Product::class, 'category', 'id');
    // }
}
