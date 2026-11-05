<?php

namespace App\Models\ShippingAddress;

use App\Models\ShippingAddress\ShippingRateSurcharge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $casts = [
        'value' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function shippingRates(): HasMany
    {
        return $this->hasMany(ShippingRateSurcharge::class);
    }
}
