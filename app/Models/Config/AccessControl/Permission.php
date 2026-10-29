<?php

namespace App\Models\Config\AccessControl;

use App\Models\Config\AccessControl\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    use HasFactory;
    protected $table = 'permissions';
    protected $fillable = [
        'slug',
        'name',
        'module',
        'advanced_management',
    ];

    protected function casts(): array
    {
        return [
            'advanced_management' => 'boolean',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_permissions'
        );
    }
}
