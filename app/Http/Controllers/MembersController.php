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

class MembersController extends Controller {

	/**
	 * Constructor
	 *
	 */
	public function __construct() {
		// You must be signed in to see or create members
		$this->middleware('auth');
	  }

	/**
	 * Display a listing of members
	 *
	 * @return Response
	 */
	public function index() {
		if (auth()->check()) {
			$members = Member::all();
			return view('member.index', compact('members'));
		} else {
			return redirect()->login();
		}
	
	}

	/**
	 * Display form to create a new member
	 *
	 * Redirects to home page after saving new member
	 */
	public function create() {
		if (auth()->check()) {
			return view('member.create');
		} else {
			return redirect()->login();
		}
    }


	/**
	 * Store a new member from a POST request
	 *
	 * Redirects to home page after saving new member
	 */
	public function store() {
		if (auth()->check()) {
			$this->validate(request(), [
				'first' => 'required',
				'last' => 'required',
				'email' => 'required|email',
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
		} else {
			return redirect()->login();
		}
	}
	
	/**
	 * Display the specified member.
	 *
	 * @param  int  $member
	 * @return Response
	 */
	public function show(Member $member) {
		if (auth()->check()) {
			return view('member.show', compact('member', $member));
		} else {
			return redirect()->login();
		}
	}

	/**
	 * Show the form for editing the specified member.
	 *
	 * @param  int  $member
	 * @return Response
	 */
	public function edit(Member $member) {
		if (auth()->check()) {
			return view('member.edit', compact('member', $member));
		} else {
			return redirect()->login();
		}
	}
}
