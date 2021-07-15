<?php

namespace App\Transformers;

use App\Model\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
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
	public function transform(Category $category)
	{
		// quitamos administrador por que es irrelevante para el comprador
		return [
			'referencia' => (int) $category->id,
			'titulo' => (string) $category->name,
			'detalles' => (string) $category->brief,
			'fechaCreacion' => (string) $category->created_at,
			'fechaActualizacion' => (string) $category->update_at,
			'fechaEliminacion' => isset($category->delete_at)
				? (string) $category->delete_at
				: null,
		];
	}
	static function attributesLabels($input)
	{
		$original = [
			'id' => 'referencia',
			'name' => 'titulo',
			'brief' => 'detalles',
			'created_at' => 'fechaCreacion',
			'update_at' => 'fechaActualizacion',
			'delete_at' => 'fechaEliminacion',
		];
		return isset(($rt = $original[$input])) ? $rt : null;
	}
}
