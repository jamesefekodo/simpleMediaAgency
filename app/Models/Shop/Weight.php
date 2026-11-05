<?php

namespace App\Models\Shop;

use App\Models\ShippingAddress\ShippingRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Weight extends Model
{
    use HasFactory;
    protected $table = 'weights';
    protected $fillable = [
        'name',
        'min_weight',
        'max_weight',
        // 'is_active'
    ];

      protected $casts = [
        'min_weight' => 'decimal:3',
        'max_weight' => 'decimal:3',
        'is_active' => 'boolean',
    ];

    public function shippingRates(): HasMany
    {
        return $this->hasMany(ShippingRate::class);
    }
}
