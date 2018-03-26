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
use App\Models\Member;

class MembersController extends Controller 
{

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
	 * Display a listing of members. 
	 *
	 * @return Response
	 */
	public function index() 
	{
		$members = Member::all();
		return view('member.index', compact('members'));
	}

	/**
	 * Display form to create a new member
	 *
	 * Redirects to home page after saving new member
	 */
	public function create() 
	{
		return view('member.create');
    }


	/**
	 * Store a new member from a POST request
	 *
	 * @return redirect to home page
	 */
	public function store() 
	{
		$this->validate(request(), [
			'first' => 'required',
			'last' => 'required',
			'email' => 'required|email',
			// FIXME: Need to check for something other than numeric here
			'sms_phone' => "required|numeric"
		]);
		
		$member = new Member();

		$member->first = request('first');
		$member->last = request('last');
		$member->email = request('first');
		$member->sms_phone = request('sms_phone');

		$member->save();

		// Redirect back to home page
		return redirect()->home(); 
	}
	
	/**
	 * Display the specified member.
	 *
	 * @param  int  $member
	 * @return Response
	 */
	public function show(Member $member) 
	{
		return view('member.show', compact('member'));
	}

	/**
	 * Show the form for editing the specified member.
	 *
	 * @param  int  $member
	 * @return Response
	 */
	public function edit(Member $member) 
	{
		return view('member.edit', compact('member'));
	}
}
