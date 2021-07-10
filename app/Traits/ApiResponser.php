<?php
// sensitive case!!!
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponser
{
	private function successResponse($data, $code)
	{
		return response()->json($data, $code);
	}

	protected function errorResponse($msg, $code)
	{
		return response()->json(['error' => $msg, 'code' => $code], $code);
	}

	protected function showAll(Collection $c, $code = 200)
	{
		if ($c->isEmpty()) {
			return $this->successResponse(['data' => $c], $code);
		}
		$transformer = $c->first()->transformer;

		$c = $this->transformData($c, $transformer);
		return $this->successResponse($c, $code);
	}

	protected function showOne(Model $c, $code = 200)
	{
		$transformer = $c->transformer;
		$c = $this->transformData($c, $transformer);
		return $this->successResponse($c, $code);
	}

	protected function showMsg($c, $code = 200)
	{
		return $this->successResponse(['data' => $c], $code);
	}

	private function transformData($data, $transformer)
	{
		$transformation = fractal($data, new $transformer());
		return $transformation->toArray();
	}
}
