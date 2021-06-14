<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Model\Transaction;

class TransactionSellerController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Transaction $transaction)
	{
		$seller = $transaction->product->seller;
		echo 'hay nada que ver';
		return $this->showOne($seller);
	}
}
