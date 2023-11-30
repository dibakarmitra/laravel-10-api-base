<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\ActiveFlagTrait;
use App\Traits\SearchScopeTrait;
use App\Traits\SetTableTrait;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasUlids, HasFactory, Notifiable, SetTableTrait, ActiveFlagTrait, SearchScopeTrait;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name', 
        'last_name',
        'username',
        'email',
        // 'is_email_verified',
        'email_verified_at',
        'phone_code',
        'phone',
        // 'is_phone_verified',
        'phone_verified_at',
        'address',
        'country',
        'currency',
        'dob',
        'gender',
        'password',
        'remember_token',
        'referral',
        'active_flag',
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
        'first_name' => 'string', 
        'last_name' => 'string',
        'username' => 'string',
        'email' => 'string',
        // 'is_email_verified' => 'boolean',
        'email_verified_at' => 'timestamp',
        'phone_code' => 'string',
        'phone' => 'string',
        // 'is_phone_verified' => 'boolean',
        'phone_verified_at' => 'timestamp',
        'address' => 'string',
        'country' => 'string',
        'currency' => 'string',
        'dob' => 'date',
        'gender' => 'string',
        'password' => 'hashed',
        'remember_token' => 'hashed',
        'referral' => 'string',
        'active_flag' => 'boolean',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
