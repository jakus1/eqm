<?php namespace App\Notifications;

use App\Mail\MemberMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendEmail extends Notification implements ShouldQueue
{
	use Queueable;

	public $incoming_request;
	public $subject;
	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct($incoming_request, $subject)
	{
		$this->incoming_request = $incoming_request;
		$this->subject = $subject;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		$subject = (strlen(trim($this->subject)) > 2 )?$this->subject:'Take a look';
		return (new MemberMessage($this->incoming_request))
			->to($notifiable->email)
			->replyTo($this->incoming_request['sender'])
			->subject($subject);
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			//
		];
	}
}
