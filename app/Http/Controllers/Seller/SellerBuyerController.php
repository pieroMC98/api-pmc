<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\Seller;

class SellerBuyerController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Seller $seller)
	{
		$buyer = $seller
			->product()
			->whereHas('transactions')
			->with('transactions.buyer')
			->get()
			->pluck('transactions')
			->collapse()
			->pluck('buyer')
			->unique('id')
			->values();

		return $this->showAll($buyer);
	}
}
