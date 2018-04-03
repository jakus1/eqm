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
use App\Models\Tag;
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

		$this->validate(request(), [
			/*'tags' => 'required',*/
			'subject' => 'sometimes',
			'body' => 'required'
		]);
		
		$members = Member::all();
		$messageTags = $data['tags'];

		$queriedTags = explode(" ",$data['tags']);

		$communicationId = request('communication_id');

		$tags = Tag::with('taggable')->whereIn('tag',$queriedTags)->get();
		$messageLines = [];
		foreach($tags as $tag) {
			if (!$tag->taggable instanceof Member) {
				continue;
			}
			$member = $tag->taggable;
			$messageLines[] = $this->sendMessage($member, $communicationId, $data['subject'], $data['body']);
		}
		
		return view('message.sent', ['messageLines' => $messageLines]);
	}

	protected function sendMessage($member, $communicationId, $subject, $body) {
		$data = [
			'stripped-text' => $body,
			'sender' => auth()->user()->email
		];
		switch($communicationId) {
			case 'SMS':
				$member->notify(new SendSMS($data));
				$messageLines[] = "Sent an sms message to: ".$member->first." ".$member->last.".";
				break;
			case 'Email':
				$member->notify(new SendEmail($data,$subject));
				$messageLines[] = "Sent an email message to: ".$member->first." ".$member->last.".";
				break;
			case 'Both':
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