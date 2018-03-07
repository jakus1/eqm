<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SendSMS;
use App\Notifications\SendEmail;
use App\Models\Member;
use App\Models\Tag;
use App\Jobs\ImportUploadedFile;

use App\Jobs\ForwardIncomingSMS;

use Log;
use Mail;

class DevelopController extends Controller
{
	public function getJake()
	{
		$data['msisdn'] = '18014274607';
		$data['to'] = '18017973060';
		$data['messageId'] = '0B000000BE29CB7A';
		$data['text'] = 'Hi. How are you?';
		$data['type'] = 'text';
		$data['keyword'] = 'HI.';
		$data['message-timestamp'] = '2018-03-07 12:13:42';
		ForwardIncomingSMS::dispatch($data);

		// $filename = "temp/roster.csv";
		// dispatch(new ImportUploadedFile($filename));
		// return dd(config());
		return 'this is jake';
	}
}
