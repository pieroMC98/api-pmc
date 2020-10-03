<?php

namespace App;
use App\Scope\SellerScope;
class Seller extends User
{
	//   protected $table = 'seller';

	protected static function boot()
	{
		parent::boot();
		parent::addGlobalScope(new SellerScope());
	}
	function product()
	{
		return $this->hasMany(Product::class);
	}
}
