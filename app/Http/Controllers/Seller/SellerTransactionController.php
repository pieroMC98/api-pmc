<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Model\Seller;

class SellerTransactionController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Seller $s)
	{
		$transactionsList = $s
			->product()
			->whereHas('transactions')
			->with('transactions')
			->get()
			->pluck('transactions')
			->collapse();

		return $this->showAll($transactionsList);
	}
}
