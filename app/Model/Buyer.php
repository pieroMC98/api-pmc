<?php

namespace App\Model;

use App\Scope\BuyerScope;
use App\Transformers\BuyerTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends User
{
	public $transformer = BuyerTransformer::class;
	//   protected $table = 'buyer';

	// construir e inicializar el modelo
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
