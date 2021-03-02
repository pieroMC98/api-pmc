<?php

namespace App\Model;

use App\Scope\BuyerScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends User
{
	//   protected $table = 'buyer';

	protected static function boot()
	{
		parent::boot();
		static::addGlobalScope(new BuyerScope());
	}
	function transaction()
	{
		return $this->HasMany(Transaction::class);
	}
}
