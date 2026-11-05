<?php

namespace App\Models\ShippingAddress;

use App\Models\ShippingAddress\Location;
use App\Models\ShippingAddress\ShippingRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingZone extends Model
{
    use HasFactory;
    protected $table = 'shipping_zones';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'free_shipping_threshold',
        'is_active',
    ];

    protected $casts = [
        'free_shipping_threshold' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(
            Location::class,
            'shipping_zone_locations',
            'shipping_zone_id',
            'location_id'
        );
    }

    public function shippingRates(): HasMany
    {
        return $this->hasMany(ShippingRate::class);
    }
}
