<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Model\Transaction;

class TransactionController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index()
	{
		echo 'Aqui no hay nada que ver';
	}

	public function show(Transaction $transaction)
	{
		return $this->showOne($transaction);
	}
}
