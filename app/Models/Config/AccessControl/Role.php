<?php

namespace App\Models\Config\AccessControl;

use App\Models\Config\AccessControl\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{

    use HasFactory;
    protected $table = 'roles';
    protected $fillable = [
        'uuid',
        'slug',
        'name',
        'description',
        'user_cap',
        'assignment_scope',
    ];

    // cast attributes
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean'
        ];
    }
    // uuid
    protected static function booted(): void
    {
        static::creating(function ($role) {
            if (empty($role->uuid)) {
                $role->uuid = 'role-' . Str::uuid();
            }
        });
    }

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions'
        );
    }


    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'role_users',
            'role_id',    // foreign key on pivot table referencing Role
            'username',   // foreign key on pivot table referencing User
            'id',         // local key on Role
            'username'    // local key on User
        );
    }
}
