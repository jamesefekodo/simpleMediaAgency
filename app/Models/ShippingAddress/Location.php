<?php

namespace App\Models\ShippingAddress;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'type',
        'code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function shippingZones(): BelongsToMany
    {
        return $this->belongsToMany(
            ShippingZone::class,
            'shipping_zone_locations',
            'location_id',
            'shipping_zone_id'
        );
    }
}
