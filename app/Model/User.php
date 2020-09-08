<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = 'user';
    use Notifiable;
    const USER_VERIFIED = true;
    const USER_NOT_VERIFIED = false;

    const ADMIN = true;
    const REGULAR = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','verified','verification_token','admin'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','verification_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    function isVerified(){
        return $this->verified = self::USER_VERIFIED;
    }
    function isAdmin(){
        return $this->admin == self::ADMIN;
    }

    static function generateToken(){
        return Str::random(40);
    }
}
