<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\Model\Product;
use App\Model\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Schema::defaultStringLength(191);
		User::created(function ($user) {
			// por si el proveedor no env'ia el correo
			retry(
				5,
				function () use ($user) {
					Mail::to($user->email)->send(new UserCreated($user));
				},
				100
			);
			//o Mail::to($user);
		});
		User::updated(function ($user) {
			if ($user->isDirty('email')) {
				Mail::to($user->email)->send(new UserMailChanged($user));
			}
		});

		Product::updated(function ($product) {
			if ($product->quantify == 0 && $product->is_available()) {
				$product->status = Product::UNAVAILABLE;
			}
			$product->save();
		});
	}
}
