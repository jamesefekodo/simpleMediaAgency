<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Config\AccessControl\Role;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'uuid',
        'username',
        'account_type',
        'is_active',
        'photo',
        'phone_1',
        'email_1',
        'phone_2',
        'email_2',
        'require_login_mfa',
        'email_verified_at',
        'email_verification',
        'email_verification_code',
        'email_verification_code_expires_at',
        // 'admin_privilege',
        'password',
        'last_seen_at',
        'first_name',
        'middle_name',
        'last_name',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'account_type' => 'integer',
            'account_status' => 'boolean',
            'email_verification' => 'boolean',
            'require_login_mfa' => 'boolean',
            'last_seen_at' => 'datetime',
            'is_on_probation' => 'boolean',
            'is_active' => 'boolean',
        ];
    }


    // uuid
    protected static function booted(): void
    {
        static::creating(function ($user) {
            if (empty($user->uuid)) {
                $user->uuid = 'user-Y' . now()->format('Y') .
                    '-M' . now()->format('m') .
                    '-' . Str::uuid();
            }
        });
    }


    // static functions
    static public function getEmailCheck($email)
    {
        return User::where('email_1', '=', $email)->first();
    }
    static public function getTokenSingle($remember_token)
    {
        return User::where('remember_token', '=', $remember_token)->first();
    }

    // relationships
    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_users',
            'username',   // foreign key on pivot table referencing User
            'role_id',    // foreign key on pivot table referencing Role
            'username',   // local key on User
            'id'          // local key on Role
        );
    }

    public function permissions()
    {
        return $this->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->unique('id');
    }


    public function hasRole(string $role): bool
    {
        if ($this->account_type === 0) {
            return true;
        }

        return $this->roles()
            ->where('slug', $role)
            ->exists();

        // usage ... auth()->user()->hasRole('admin');

    }

    public function hasAnyRole(array $roles = []): bool
    {
        /*
     * Root association account and platform root account
     * have access to every role-protected route.
     */
        if (in_array((int) $this->account_type, [0, 90], true)) {
            return true;
        }

        /*
     * If middleware is simply "role" with no role slug:
     *
     * Allow the user only when they have at least one assigned role.
     *
     * Example:
     * Route::middleware(['auth', 'role'])
     */
        if (empty($roles)) {
            return $this->roles()->exists();
        }

        /*
     * Clean the incoming role-slug values.
     */
        $roles = array_values(array_filter(
            array_map('trim', $roles)
        ));

        /*
     * If only empty values were passed, still require
     * at least one assigned role.
     */
        if (empty($roles)) {
            return $this->roles()->exists();
        }

        /*
     * Allow access only if the user has one of the requested roles.
     */
        return $this->roles()
            ->whereIn('roles.slug', $roles)
            ->exists();
    }


    public function hasPermission(string $permission): bool
    {
        // // Root account bypasses all permission checks
        if (in_array((int) $this->account_type, [0, 90], true)) {
            return true;
        }

        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('slug', $permission);
            })
            ->exists();

        // usage $user->hasPermission('create-user');

    }




    // public function agreedPolicies()
    // {
    //     return $this->hasMany(UserAgreedPolicy::class, 'username', 'username');
    // }

}
