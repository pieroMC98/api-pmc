<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Model\Buyer;

class BuyerProductController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Buyer $buyer)
	{
		// AL llamar a transaction se crea una Collection
		//$product = $buyer->transaction->product;

		// llamamos a la funcion(query builder) y no a la relacion como tal: eager loading
		$product = $buyer
			->transaction()
			->with('product')
			->get()
			->pluck('product');
		return $this->showAll($product);
	}
}
