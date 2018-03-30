<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\AjaxResponse;
use Hash;
use Auth;
use DB;
use Log;
use PDF;
use Storage;
use Session;

use \Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;
use App\Models\Member;

class MessagesController extends Controller {

	/**
	 * Constructor
	 *
	 */
	public function __construct() 
	{
		// You must be signed in to see or create members
		$this->middleware('auth');
	}

	/**
	 * Display a listing of messages
	 *
	 * @return Response
	 */
	public function index()
	{
		$messages = Message::all();
		return view('message.index');
	}

	/**
	 * Show the form for creating a new message
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('message.create');
	}

	/**
	 * Display the specified message.
	 *
	 * @param Message $message
	 * @return Response
	 */
	public function show(Message $message)
	{
		return view('message.show', compact('message'));
	}

	/**
	 * Store a new message.
	 *
	 * @param Member $member
	 * @return Response
	 */
	public function store(Member $member)
	{
		$this->validate(request(), [
			'subject' => 'required',
			'body' => 'required'
		]);

		$new_message = $member->addMessage(request('subject'),request('body'));

		// FIXME
		// do the sms part
		// foreach($members as $member) {
		// 	$member->notify(new SendSMS($data));
		// 	$messageLines[] = "Sent an sms message to: ".$member->first." ".$member->last.".";
		// }
		
		// do the email part
		// foreach($members as $member) {
		// 	$member->notify(new SendEmail($data,$subject));
		// 	$messageLines[] = "Sent an email message to: ".$member->first." ".$member->last.".";
		// }

		return view('message.show', ['message' => $new_message]);
	}

	/**
	 * Show the form for editing the specified message.
	 *
	 * @param Message $message
	 * @return Response
	 */
	public function edit(Message $message)
	{
		return view('message.edit', compact('message'));
	}

}