<?php

namespace App\Models;

use App\Support\Auth\Contracts\MustWelcomeEmail;
use App\Support\Models\Concerns\HasProtected;
use App\Support\Models\Contracts\HasProtected as HasProtectedContract;
use App\Support\Models\SanctumUser;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 */
class User extends SanctumUser implements MustWelcomeEmail, HasProtectedContract
{
    use HasFactory, HasProtected;

    public const SYSTEM_ID = 1;
    public const OWNER_ID = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    protected $visible = [
        'id',
        'name',
        'email',
        'sd_st_email_verified_at',
        'sd_st_created_at',
    ];

    protected $appends = [
        'sd_st_email_verified_at',
        'sd_st_created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'email_verified_at' => 'datetime',
    ];

    public function getProtectedValues(): array
    {
        return [
            self::SYSTEM_ID,
            self::OWNER_ID,
        ];
    }

    protected function sdStEmailVerifiedAt(): Attribute
    {
        return Attribute::make(
            get: static fn($value, $attributes) => is_null($attributes['email_verified_at'] ?? null)
                ? null
                : date_timer()->compound(
                    'shortDate',
                    ' ',
                    'shortTime',
                    $attributes['email_verified_at']
                ),
        );
    }

    protected function sdStCreatedAt(): Attribute
    {
        return Attribute::make(
            get: static fn($_, $attributes) => date_timer()->compound(
                'shortDate',
                ' ',
                'shortTime',
                $attributes['created_at']
            )
        );
    }
}
