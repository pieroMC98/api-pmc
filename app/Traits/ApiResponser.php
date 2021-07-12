<?php
// sensitive case!!!
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use App\Http\Resources;
use App\Http\Resources\UserCollection;

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
		$c = $this->sortData($c);
		//$c = $this->transformData($c, $transformer);
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

	private function sortData(Collection $collection)
	{
		// usamos el helper request ya que no lo estamos pasando por parametros
		if (request()->has('sort_by')) {
			$atribute = request()->sort_by; //sort_by es el valor del atributo que pasamos en el request
			$collection = $collection->sortBy->{$atribute}; // equivalente a {'property'}
			// o $collection = $collection->sortBy($atribute);// equivalente a {'property'}
		}
		return new UserCollection($collection);
		return $collection;
	}

	// usar esto en vez de Fractal
	protected function getResource($std, $data)
	{
		return new $std($data);
	}

	protected function getResourceCollection($std, $class)
	{
		return new $std($class::all());
	}
}
