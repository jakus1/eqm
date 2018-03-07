<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Notifications\SendSMS;
use App\Notifications\SendEmail;

use App\Mail\MessagesSent;
use App\Models\Tag;

use Log;
use Mail;

class ProcessIncomingMailgun implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $data;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($data)
	{
		$this->data = $data;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$messageLines = [];
		$data = $this->data;

		// first determine the verb
		$subject = $this->data['subject'];
		$verbs = [];
		if(str_contains(strtolower($subject), 'sms')) {
			$verbs[] = 'sms';
		}
		if(str_contains(strtolower($subject), 'email')) {
			$verbs[] = 'email';
		}

		if(count($verbs) == 0) {
			Log::error('NO VERB FOUND');
			return;
		}
		$find = ['sms','email'];
		$replace = ['',''];
		$subject = str_replace($find,$replace,$subject);
		$subject = trim($subject);
		$parts = explode(" ",$subject);
		$tags = [];
		foreach($parts as $part) {
			if (trim($part) == '') continue;
			$membersqry = Tag::with('taggable')->where('tag',trim($part));
			if($membersqry->count() == 0) {
				continue;
			}
			$subject = trim(str_replace($part,'',$subject));
			$tags[$part] = $part;
		}
		$members = Tag::with('taggable')->whereIn('tag',$tags)->get();
		if(in_array('sms',$verbs)) {
			// do the sms part
			foreach($members as $member) {
				$member->taggable->notify(new SendSMS($data));
				$messageLines[] = "Sent an sms message to: ".$member->taggable->first." ".$member->taggable->last.".";
			}
		}
		if(in_array('email',$verbs)) {
			// do the email part
			foreach($members as $member) {
				$member->taggable->notify(new SendEmail($data,$subject));
				$messageLines[] = "Sent an email message to: ".$member->taggable->first." ".$member->taggable->last.".";
			}
		}
		Mail::to('jake@barlowshomes.com')
			->send(new MessagesSent($messageLines));
	}
}
