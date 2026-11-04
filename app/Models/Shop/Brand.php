<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brands';
    protected $fillable = [
        'slug',
        'brand',
        'description',
        'logo',
    ];

    // uuid
    protected static function booted(): void
    {
        static::creating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = 'brand-' . Str::uuid();
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
