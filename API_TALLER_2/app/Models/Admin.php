<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory;

    /**
     * Admin editables fields
     */
    protected $fillable = [
        'username',
        'password'
    ];

    /**
     * Admin protected fields
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get JWT secret key
     * @return JWTKey
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
