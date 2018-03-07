<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

use App\Models\Member;
use App\Notifications\SendSMS;
use App\Jobs\ProcessIncomingMailgun;
use App\Jobs\ForwardIncomingSMS;



// ngrok http --host-header=eq-municator.local 80

class IncomingMessageController extends Controller
{
	public function mailgun()
	{
		$data = request()->all();
		// Log::info('PROCESSIN MAILGUN: '.print_r($data, true));
		ProcessIncomingMailgun::dispatch($data);
		return response()->json(['status' => 'ok']);
	}
	public function nexmo()
	{
		$data = request()->all();
		Log::info('Message POST:'.print_r($data, true));
		ForwardIncomingSMS::dispatch($data);
		return response()->json(['status' => 'ok']);
	}
	public function nexmoReceipt()
	{
		$data = request()->all();
		Log::info('Message-receipt POST:'.print_r($data, true));
		// ProcessIncomingMailgun::dispatch($data);
		return response()->json(['status' => 'ok']);
	}
}
