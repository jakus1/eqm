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
		$filename = "temp/roster.csv";
		dispatch(new ImportUploadedFile($filename));
		return dd(config());
		return $members = Member::where('status','Active')->get();
		$tags = ['pres','d2'];
		$result = Tag::with('taggable')->whereIn('tag',$tags)->get();
		return $members = $result->pluck('taggable')->all();
		return 'this is jake';
	}
}
