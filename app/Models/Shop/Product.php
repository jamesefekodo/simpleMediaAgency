<?php

namespace App\Models\Shop;

use App\Models\Shop\Brand;
use App\Models\Shop\ProductCategory;
use App\Models\Shop\ProductImage;
use App\Models\Shop\ProductVariant;
use App\Models\Shop\Weight;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory
        , SoftDeletes
    ;

    protected $fillable = [
        'brand_slug',
        'name',
        'slug',
        'short_description',
        'description',
        'sku',
        'barcode',
        'type',
        'price',
        'compare_at_price',
        'cost_price',
        'currency',
        'track_stock',
        'stock_quantity',
        'allow_backorder',
        'low_stock_threshold',
        'weight_id',
        'is_active',
        'is_featured',
        'published_at',
        'meta_title',
        'meta_description',
        'metadata',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'track_stock' => 'boolean',
        'stock_quantity' => 'integer',
        'allow_backorder' => 'boolean',
        'low_stock_threshold' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'metadata' => 'array',
    ];

    // uuid
    protected static function booted(): void
    {
        static::creating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = 'prod-' . now()->format('Ym') . '-' . Str::uuid();
            }
        });
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_slug', 'slug');
    }

    public function weight()
    {
        return $this->belongsTo(Weight::class);
    }

    public function categories()
    {
        return $this->belongsToMany(
            ProductCategory::class,
            'category_product',
            'product_slug',
            'product_category_slug',
            'slug',
            'slug'
        );
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_slug', 'slug');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_slug', 'slug');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class, 'product_slug', 'slug')
            ->where('is_primary', true)
            ->orderBy('position');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->price ?? 0);
    }

    public function getDiscountPercentageAttribute(): ?float
    {
        if (! $this->compare_at_price || $this->compare_at_price <= $this->price) {
            return null;
        }

        return round(
            (($this->compare_at_price - $this->price) / $this->compare_at_price) * 100,
            2
        );
    }

    public function getIsInStockAttribute(): bool
    {
        if (! $this->track_stock) {
            return true;
        }

        return $this->stock_quantity > 0 || $this->allow_backorder;
    }

    public function getIsLowStockAttribute(): bool
    {
        if (! $this->track_stock) {
            return false;
        }

        return $this->stock_quantity > 0
            && $this->stock_quantity <= $this->low_stock_threshold;
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_slug', 'slug');
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class, 'product_slug', 'slug')
            ->where('is_approved', true);
    }

    public function updateRatingSummary(): void
    {
        $summary = $this->reviews()
            ->where('is_approved', true)
            ->selectRaw('COUNT(*) as total, AVG(rating) as average')
            ->first();

        $this->update([
            'reviews_count' => (int) ($summary->total ?? 0),
            'rating_average' => round((float) ($summary->average ?? 0), 2),
        ]);
    }
}
