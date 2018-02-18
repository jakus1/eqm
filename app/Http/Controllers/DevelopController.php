<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SendSMS;
use App\Notifications\SendEmail;
use App\Models\Member;
use App\Models\Tag;

class DevelopController extends Controller
{
	public function getJake()
	{
		// $member = Member::create(['first'=>'Jeremy','last'=>'Browne','email'=>'jeremy_browne@byu.edu','sms_phone'=>'8016919323']);
		// $tag = $member->tags()->create(['tag'=>'d1']);
		// $member = Member::create(['first'=>'Jake','last'=>'Barlow','email'=>'jake@jakebarlow.com','sms_phone'=>'8014274607']);
		// $tag = $member->tags()->create(['tag'=>'d2']);
		// $member = Member::create(['first'=>'Austin','last'=>'Sperry','email'=>'austinsperry@gmail.com','sms_phone'=>'4805705560']);
		// $tag = $member->tags()->create(['tag'=>'d3']);
		// return Member::with('tags')->get();
		// $member = Member::find(1);
		// $member->notify(new SendSMS())
		$data =['stripped-text'=>'Sending a message from our new messaging app. This is pretty cool'];
		// $member = Member::find(1);
		// $member->notify(new SendSMS($data));
		// $member = Member::find(2);
		// $member->notify(new SendSMS($data));
		// $member = Member::find(3);
		// $member->notify(new SendSMS($data));
		// return $member;
		
		$subject = "sms email d2 Canning assignment that we need to have filled";
		$verbs = [];
		if(str_contains($subject, 'sms')) {
			$verbs[] = 'sms';
		}if(str_contains($subject, 'email')) {
			$verbs[] = 'email';
		}

		if(count($verbs) == 0) {
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
			// $members = $membersqry->get();
			$subject = trim(str_replace($part,'',$subject));
			$tags[$part] = $part;
		}
		$members = Tag::with('taggable')->whereIn('tag',$tags)->get();
		if(in_array('sms',$verbs)) {
			// do the sms part

			foreach($members as $member) {
				$member->taggable->notify(new SendSMS($data));
			}
		}
		if(in_array('email',$verbs)) {
			// do the email part
			foreach($members as $member) {
				$member->taggable->notify(new SendEmail($data,$subject));
			}
		}
		return ['verbs'=>$verbs,'tags'=>$tags];
		return 'this is jake';
	}
}
