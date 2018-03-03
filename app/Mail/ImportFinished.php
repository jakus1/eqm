<?php namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImportFinished extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;


	public $messages;
	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($messages)
	{
		$this->messages = $messages;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->subject('The importer file has finished running')->view('email.import_notification');
	}
}
