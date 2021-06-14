<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Model\Category;

class CategoryTransactionController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Category $category)
	{
		$transactions = $category
			->product()
			//->whereHas('transactions') // solo actuamos sobre productos que tienen una transacion
			->with('transactions')
			->get()
			->pluck('transactions')
			->collapse();
		return $this->showAll($transactions);
	}
}
