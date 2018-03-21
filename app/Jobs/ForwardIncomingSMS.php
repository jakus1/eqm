<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\IncomingSms;

use App\Models\Member;

use Log;
use Mail;

class ForwardIncomingSMS implements ShouldQueue
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
		$data = $this->data;
		// Log::info('JOB:ForwardIncomingSMS data:'.print_r($data, true));
		$member = Member::where('sms_phone', 'like', '%'.trim($data['msisdn'],'1').'%')->first();
		if(!is_null($member)) {
			$data['member'] = $member;
		}
		// Log::info('JOB:ForwardIncomingSMS data:'.print_r($data, true));
		foreach(config('site.sms_forward_emails') as $email){
			Mail::to($email)
				->send(new IncomingSms($data));
		}
		

		//
	}
}
