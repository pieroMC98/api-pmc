<?php

namespace App\Transformers;

use App\Model\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
	/**
	 * List of resources to automatically include
	 *
	 * @var array
	 */
	protected $defaultIncludes = [
		//
	];

	/**
	 * List of resources possible to include
	 *
	 * @var array
	 */
	protected $availableIncludes = [
		//
	];

	/**
	 * A Fractal transformer.
	 *
	 * @return array
	 */
	public function transform(Transaction $transaction)
	{
		// quitamos administrador por que es irrelevante para el comprador
		return [
			'referencia' => (int) $transaction->id,
			'cantidad' => (string) $transaction->quantify,
			'comprador' => (string) $transaction->buyer_id,
			'producto' => (string) $transaction->product_id,
			'fechaCreacion' => (string) $transaction->created_at,
			'fechaActualizacion' => (string) $transaction->update_at,
			'fechaEliminacion' => isset($transaction->delete_at)
				? (string) $transaction->delete_at
				: null,
		];
	}
	static function attributesLabels($input)
	{
		$original = [
			'id' => 'referencia',
			'quantify' => 'cantidad',
			'buyer_id' => 'comprador',
			'product_id' => 'producto',
			'created_at' => 'fechaCreacion',
			'update_at' => 'fechaActualizacion',
			'delete_at' => 'fechaEliminacion',
		];
		return isset(($rt = $original[$input])) ? $rt : null;
	}
}
