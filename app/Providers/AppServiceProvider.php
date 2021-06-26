<?php

namespace App\Providers;

use App\Mail\UserCreated;
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
			Mail::to($user->email)->send(new UserCreated($user));
			//o Mail::to($user);
		});

		Product::updated(function ($product) {
			if ($product->quantify == 0 && $product->is_available()) {
				$product->status = Product::UNAVAILABLE;
			}
			$product->save();
		});
	}
}
