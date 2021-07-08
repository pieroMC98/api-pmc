<?php

namespace App\Listeners;

use App\Events\UserRegisterEvent;
use App\Mail\UserCreatedByEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UserRegisterListener
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  object  $event
	 * @return void
	 */
	public function handle(UserRegisterEvent $event)
	{
		retry(
			5,
			function () use ($event) {
				Mail::to($event->user->email)->send(
					new UserCreatedByEvent($event->user)
				);
			},
			100
		);
	}
}
