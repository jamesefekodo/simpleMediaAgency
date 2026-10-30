<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicSystemSetting extends Model
{
    use HasFactory;
    protected $table = 'basic_system_settings';
    protected $fillable = [
        'maintenance_mode',
        'app_name',
        'acronym',
        'logo',
        'slogan',
        'about_us',
        'about_cover_image',
        'account_balance',
    ];

    // caset attributes
    protected function casts(): array
    {
        return [
            'maintenance_mode' => 'boolean',
        ];
    }
}
