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

use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class MessagesController extends Controller {

	/**
	 * Display a listing of messages
	 *
	 * @return Response
	 */
	public function index()
	{
		// $messages = Message::all();
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
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$the_record = $message = Message::findOrFail($id);
		return view('message.show', compact('message','the_record'));
	}

	/**
	 * Show the form for editing the specified message.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$message = Message::find($id);
		return view('message.edit', compact('message'));
	}

}