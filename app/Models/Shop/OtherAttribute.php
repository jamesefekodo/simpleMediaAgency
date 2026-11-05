<?php

namespace App\Models\Shop;

use App\Models\Shop\OtherAttributeValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherAttribute extends Model
{
   use HasFactory;
    protected $table = 'other_attributes';
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function attributeValues()
    {
        return $this->hasMany(OtherAttributeValue::class, 'attribute_id', 'id');
    }
}
