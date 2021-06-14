<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Model\Buyer;

class BuyerCategoryController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Buyer $buyer)
	{
		$category = $buyer
			->transaction()
			->with('product.category')
			->get()
			->pluck('product.category') // tenemos que decirle que primero vaya a product y luego a seller por que no es directo
			->collapse() // tenemos una Coleccion de colecciones, N:N, solo queremos una lista. Cogera todas las listas y creara solo una lista
			->unique('id') // no repetir vendedores
			->values(); // por si hay elementos repetidos y alguno de ellos se borra
		return $this->showAll($category);
	}
}
