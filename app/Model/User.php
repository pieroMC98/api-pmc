<?php

namespace App\Model;

use App\Transformers\UserTransformer;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	public $transformer = UserTransformer::class;
	protected $table = 'user';
	use Notifiable;
	use HasFactory;
	use SoftDeletes;
	// user states
	const USER_VERIFIED = true;
	const USER_NOT_VERIFIED = false;

	const ADMIN = true;
	const REGULAR = false;
	// !user states

	protected $dates = ['deleted_at'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'verified',
		'verification_token',
		'admin',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token', 'verification_token'];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	function isVerified()
	{
		return $this->verified = self::USER_VERIFIED;
	}

	function isAdmin()
	{
		return $this->admin == self::ADMIN;
	}

	static function generateToken()
	{
		return Str::random(40);
	}

	/*
     """ mutador: modificaciones antes de insertar en la base de datos
     """ accesor: modificar un valor dado despues de insertar en la base de datos
     * mutadores de atibutos name y email
     */

	function setNameAttribute($value)
	{
		$this->attributes['name'] = strtolower($value);
	}

	function setEmailAttribute($value)
	{
		$this->attributes['email'] = strtolower($value);
	}

	/*
	 *accesor de nombre
	 */
	function getNameAttribute($value)
	{
		return ucfirst($value);
	}
}
