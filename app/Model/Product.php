<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;
	const AVAILABLE = true;
	const UNAVAILABLE = false;
	protected $table = 'product';
	protected $dates = ['deleted_at'];
	protected $fillable = [
		'name',
		'brief',
		'status',
		'quantify',
		'image',
		'seller_id',
	];
	protected $hidden = ['pivot']; // informacion innecesaria para el usuario final

	function is_available()
	{
		return $this->status == self::AVAILABLE;
	}

	function category()
	{
		return $this->belongsToMany(Category::class);
	}

	function seller()
	{
		return $this->belongsTo(Seller::class);
	}

	function transaction()
	{
		return $this->belongsToMany(Transaction::class);
	}
}
