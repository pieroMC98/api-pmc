<?php

namespace App\Mail;

use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Mailable
{
	use Queueable, SerializesModels;
	// variable a inyectar
	public $user;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(User $user)
	{
		// lo inyecta a la vista
		$this->user = $user;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		// para enviar texto plano
		return $this->text('emails.welcome')->subject(
			'Por favor confirme su email'
		);
		//return $this->view('view.name');
	}
}
