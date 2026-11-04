<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colour extends Model
{
    use HasFactory;
    protected $table = 'colours';
    protected $fillable = [
        'hex_code',
        'name',
    ];
}
