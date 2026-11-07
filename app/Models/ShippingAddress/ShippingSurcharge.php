<?php

namespace App\Models\ShippingAddress;

use App\Models\ShippingAddress\ShippingRateSurcharge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ShippingSurcharge extends Model
{
    use HasFactory;
    protected $table = 'shipping_surcharges';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'value',
        'is_active',
    ];


    // slug
    protected static function booted(): void
    {
        static::creating(function ($surcharge) {
            if (empty($surcharge->slug)) {
                $surcharge->slug = 'shsrch-' . Str::uuid();
            }
        });
    }

    protected $casts = [
        'value' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function shippingRates(): HasMany
    {
        return $this->hasMany(ShippingRateSurcharge::class);
    }
}
