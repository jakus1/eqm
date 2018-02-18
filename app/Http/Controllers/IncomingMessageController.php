<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

use App\Models\Member;
use App\Notifications\SendSMS;
use App\Jobs\ProcessIncomingMailgun;


// ngrok http --host-header=eq-municator.local 80

class IncomingMessageController extends Controller
{
	public function mailgun()
	{
		$data = request()->all();
		ProcessIncomingMailgun::dispatch($data);
		return response()->json(['status' => 'ok']);
	}
}
