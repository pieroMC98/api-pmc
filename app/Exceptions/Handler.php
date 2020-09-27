<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class Handler extends ExceptionHandler
{
	use ApiResponser;
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = ['password', 'password_confirmation'];

	/**
	 * Report or log an exception.
	 *
	 * @param  \Throwable  $exception
	 * @return void
	 *
	 * @throws \Exception
	 */
	public function report(Throwable $exception)
	{
		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Throwable  $exception
	 * @return \Symfony\Component\HttpFoundation\Response
	 *
	 * @throws \Throwable
	 */
	public function render($request, Throwable $exception)
	{
		if ($exception instanceof ValidationException) {
			return $this->convertValidationExceptionToResponse(
				$exception,
				$request
			);
		}

		if ($exception instanceof ModelNotFoundException) {
			return $this->errorResponse(
				'Not exists instance to specified id::' .
					strtolower(class_basename($exception->getModel())),
				404
			);
		}

		if ($exception instanceof AuthenticationException) {
			return $this->unauthenticated($request, $exception);
		}

		if ($exception instanceof AuthorizationException) {
			return $this->errorResponse('insufficient permissions', 403);
		}

		if ($exception instanceof MethodNotAllowedHttpException) {
			return $this->errorResponse('invalid method', 405);
		}
		if ($exception instanceof NotFoundHttpException) {
			return $this->errorResponse('Sorry, page not found', 404);
		}

		if ($exception instanceof HttpException) {
			return $this->errorResponse(
				$exception->getMessage(),
				$exception->getStatusCode()
			);
		}

		if ($exception instanceof QueryException) {
			$status = $exception->errorInfo[1];
			if ($status == 1451) {
				return $this->errorResponse('Integrity constraint error', 409);
			}
		}

		// si estamos en produccion, mensajes ligeros
		if (config('app.debug')) {
			return parent::render($request, $exception);
		}
		return $this->errorResponse('internal error, Try later', 500);
	}

	/*
	 * validator response customizable
	 */

	protected function convertValidationExceptionToResponse(
		ValidationException $e,
		$request
	) {
		$errors = $e->validator->errors()->getMessages();
		return $this->errorResponse($errors, 422);
		return $request->expectsJson()
			? $this->invalidJson($request, $e)
			: $this->invalid($request, $e);
	}
}
