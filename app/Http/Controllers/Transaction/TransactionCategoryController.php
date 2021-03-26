<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Model\Transaction;

class TransactionCategoryController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Transaction $transaction)
	{
		$categorias = $transaction->product->category;
		return $this->showAll($categorias);
	}
}
