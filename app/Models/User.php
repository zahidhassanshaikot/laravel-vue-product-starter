<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\ModelBootHandler;
use App\Traits\Scopes\ScopeActive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, ModelBootHandler, ScopeActive, SoftDeletes;

    const ADMIN                     = 'admin';
    public const STATUS_ACTIVE      = 'active';
    public const STATUS_INACTIVE    = 'inactive';
    public const FILE_STORE_PATH    = 'users';


    public const TYPE_STUDENT       = 'Student';
    public const TYPE_ADMIN         = 'Admin';
    public const TYPE_STAFF         = 'Staff';
    public const TYPE_MEMBERSHIP    = 'Membership';
    public const TYPE_COMPANY       = 'company';

    public const TYPES              = [
        self::TYPE_STUDENT,
        self::TYPE_ADMIN,
        self::TYPE_STAFF,
        self::TYPE_MEMBERSHIP,
        self::TYPE_COMPANY,
    ];

    /**
     * appends
     *
     * @var array
     */
    protected $appends = ['avatar_url', 'full_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded =['id'];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAvatarUrlAttribute()
    {
        return getStorageImage($this->avatar, true);
    }
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }
}
