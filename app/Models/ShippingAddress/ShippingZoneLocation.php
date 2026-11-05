<?php

namespace App\Models\ShippingAddress;

use App\Models\ShippingAddress\ShippingZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingZoneLocation extends Model
{
    use HasFactory;
    protected $table = 'shipping_zone_locations';
    protected $fillable = [
        'shipping_zone_id',
        'location_id',
    ];


     public function shippingZone(): BelongsTo
    {
        return $this->belongsTo(ShippingZone::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
