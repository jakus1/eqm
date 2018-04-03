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
use App\Notifications\SendSMS;
use App\Notifications\SendEmail;

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
	 * @return Response
	 */
	public function store()
	{
		$data = request()->all();

		$this->validate($data, [
			'tags' => 'sometimes',
			'subject' => 'sometimes',
			'body' => 'required'
		]);
		
		$members = Member::all();
		$messageTags = $data['tags'];

		$communicationId = request('communication_id');

		foreach ($members as $member) {
			foreach ($member->tags() as $memberTag) {
				foreach($messageTags as $messageTag) {
					if ($messageTag == $memberTag) {
						$messageLines[] = $this->sendMessage($member, $communicationId);
					}
				}
			}
		}
		
		return view('message.show', ['message' => $new_message]);
	}

	protected function sendMessage($member, $communicationId, $subject, $body) {
		switch($communicationId) {
			case 'SMS':
				$member->notify(new SendSMS($data));
				$messageLines[] = "Sent an sms message to: ".$member->first." ".$member->last.".";
				break;
			case 'Email':
				$member->notify(new SendEmail($data,$subject));
				$messageLines[] = "Sent an email message to: ".$member->first." ".$member->last.".";
				break;
			case Both:
				$member->notify(new SendSMS($data));
				$messageLines[] = "Sent an sms message to: ".$member->first." ".$member->last.".";
				$member->notify(new SendEmail($data,$subject));
				$messageLines[] = "Sent an email message to: ".$member->first." ".$member->last.".";
				break;
		}

		$new_message = $member->addMessage(request('subject'),request('body'));
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