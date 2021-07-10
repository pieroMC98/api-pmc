<?php

namespace App\Model;

use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
	use SoftDeletes;
	public $transformer = TransactionTransformer::class;

	protected $table = 'transaction';
	protected $dates = ['deleted_at'];
	protected $fillable = ['quantify', 'buyer_id', 'product_id'];

	function buyer()
	{
		return $this->belongsTo(Buyer::class);
	}

	function product()
	{
		return $this->belongsTo(Product::class);
	}
}
