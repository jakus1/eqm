<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SendSMS;
use App\Notifications\SendEmail;
use App\Models\Member;
use App\Models\Tag;
use App\Jobs\ImportUploadedFile;

class DevelopController extends Controller
{
	public function getJake()
	{
		$filename = "temp/roster.csv";
		dispatch(new ImportUploadedFile($filename));
		return dd(config());
		return 'this is jake';
	}
}
