<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Model\Buyer;

class BuyerTransactionController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Buyer $buyer)
	{
		$transaction = $buyer->transaction;
		return $this->showAll($transaction);
	}
}
