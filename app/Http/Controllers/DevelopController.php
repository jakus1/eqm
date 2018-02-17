<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class DevelopController extends Controller
{
	public function getJake()
	{
		$member = Member::create(['first'=>'Austin','last'=>'Sperry','email'=>'austinsperry@gmail.com','sms_phone'=>'4805705560']);
		// $member = Member::find(2);
		$tag = $member->tags()->create(['tag'=>'d3']);
		return Member::with('tags')->find($member->id);
		return 'this is jake';
	}
}
