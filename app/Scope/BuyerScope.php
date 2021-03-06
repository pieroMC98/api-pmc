<?php

namespace App\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BuyerScope implements Scope
{
	// Builder: contructor de la consulta
	function apply(Builder $builder, Model $model)
	{
		$builder->has('transaction');
	}
}
