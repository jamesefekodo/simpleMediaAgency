<?php

namespace App\Models\ShippingAddress;

use App\Models\ShippingAddress\ShippingRateSurcharge;
use App\Models\ShippingAddress\ShippingZone;
use App\Models\Shop\Weight;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingRate extends Model
{
    use HasFactory;
    protected $table = 'shipping_rates';
    protected $fillable = [
        'shipping_zone_id',
        'weight_id',
        'base_fee',
        'per_kg_fee',
        'estimated_days_min',
        'estimated_days_max',
        'is_active',
    ];


    protected $casts = [
        'base_fee' => 'decimal:2',
        'per_kg_fee' => 'decimal:2',
        'estimated_days_min' => 'integer',
        'estimated_days_max' => 'integer',
        'is_active' => 'boolean',
    ];

    public function shippingZone(): BelongsTo
    {
        return $this->belongsTo(ShippingZone::class);
    }

    public function weight(): BelongsTo
    {
        return $this->belongsTo(Weight::class);
    }

    public function surcharges(): HasMany
    {
        return $this->hasMany(ShippingRateSurcharge::class);
    }
}
