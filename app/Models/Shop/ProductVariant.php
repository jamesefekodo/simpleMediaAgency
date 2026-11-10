<?php

namespace App\Models\Shop;

use App\Models\Shop\Colour;
use App\Models\Shop\Product;
use App\Models\Shop\ProductImage;
use App\Models\Shop\Weight;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory
    // , SoftDeletes
    ;

    protected $fillable = [
        'product_slug',
        'name',
        'sku',
        'barcode',
        'price',
        'compare_at_price',
        'cost_price',
        'currency',
        'track_stock',
        'stock_quantity',
        'reserved_quantity',
        'allow_backorder',
        'colour_hex_code',
        'weight_id',
        'is_default',
        'position',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'track_stock' => 'boolean',
        'stock_quantity' => 'integer',
        'reserved_quantity' => 'integer',
        'allow_backorder' => 'boolean',
        'is_default' => 'boolean',
        'position' => 'integer',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_slug', 'slug');
    }

    public function colour(): BelongsTo
    {
        return $this->belongsTo(Colour::class, 'colour_hex_code', 'hex_code');
    }

    public function weight(): BelongsTo
    {
        return $this->belongsTo(Weight::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_variant_id');
    }

    public function attributeValues()
    {
        return $this->belongsToMany(
            OtherAttributeValue::class,
            'product_variant_attribute_values',
            'product_variant_id',
            'other_attribute_value_id'
        );
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getAvailableQuantityAttribute(): int
    {
        return max(0, $this->stock_quantity - $this->reserved_quantity);
    }

    public function getIsInStockAttribute(): bool
    {
        if (! $this->track_stock) {
            return true;
        }

        return $this->available_quantity > 0 || $this->allow_backorder;
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
}
