<?php

namespace App\Models\Config\SystemPolicy;

use App\Models\Config\SystemPolicy\UserAgreedPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SystemPolicy extends Model
{
    use HasFactory;
    protected $table = 'system_policies';
    protected $fillable = [
        'slug',
        'title',
        'policy_statement',
        'applicable_to_customer',
        'applicable_to_administrator',
        'is_active',
        'published_on',
        'updated_on',
    ];

    // cast attributes
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'applicable_to_customer' => 'boolean',
            'applicable_to_administrator' => 'boolean',
        ];
    }
    // uuid
    protected static function booted(): void
    {
        static::creating(function ($role) {
            if (empty($role->slug)) {
                $role->slug = 'policy-' . now()->format('Ym') . '-' . Str::uuid();
            }
        });
    }

    public function policyAgreements()
    {
        return $this->hasMany(UserAgreedPolicy::class, 'policy', 'slug');
    }
}
