<?php

namespace App\Models\Shop;

use App\Models\Shop\OtherAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherAttributeValue extends Model
{
    use HasFactory;
    protected $table = 'other_attribute_values';
    protected $fillable = [
        'attribute_id',
        'value',
    ];


    public function attribute()
    {
        return $this->belongsTo(OtherAttribute::class, 'attribute_id', 'id');
    }
}
