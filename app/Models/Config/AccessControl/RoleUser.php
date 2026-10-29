<?php

namespace App\Models\Config\AccessControl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_users';

    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'username',
        'role_id',
    ];


    public function permissions()
    {
        return $this->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->unique('id');
    }
}
