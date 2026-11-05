<?php

namespace App\Models\ShippingAddress;

use App\Models\ShippingAddress\ShippingRate;
use App\Models\ShippingAddress\ShippingSurcharge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingRateSurcharge extends Model
{
    use HasFactory;
    protected $table = 'shipping_rate_surcharges';
    protected $fillable = [
        'shipping_rate_id',
        'shipping_surcharge_id',
    ];

    public function shippingRate(): BelongsTo
    {
        return $this->belongsTo(ShippingRate::class);
    }

    public function shippingSurcharge(): BelongsTo
    {
        return $this->belongsTo(ShippingSurcharge::class);
    }
}
