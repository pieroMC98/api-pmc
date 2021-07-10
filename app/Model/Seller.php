<?php

namespace App\Model;
use App\Scope\SellerScope;
use App\Transformers\SellerTransformer;

class Seller extends User
{
	//   protected $table = 'seller';

	public $transformer = SellerTransformer::class;
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
