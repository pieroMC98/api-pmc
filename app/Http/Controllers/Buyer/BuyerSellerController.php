<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Model\Buyer;

class BuyerSellerController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Buyer $buyer)
	{
		$seller = $buyer
			->transaction()
			->with('product.seller')
			->get()
			->pluck('product.seller') // tenemos que decirle que primero vaya a product y luego a seller por que no es directo
			->unique('id') // no repetir vendedores
			->values(); // por si hay elementos repetidos y alguno de ellos se borra
		return $this->showAll($seller);
	}
}
