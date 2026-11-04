<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    use HasFactory;
    protected $table = 'weights';
    protected $fillable = [
        'name',
        'min_weight',
        'max_weight',
        'is_active'
    ];
}
