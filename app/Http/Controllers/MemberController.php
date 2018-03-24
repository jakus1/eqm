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

class MemberController extends Controller {

	/**
	 * Display a listing of members
	 *
	 * @return Response
	 */
	public function index() {
		$members = Member::all();
		return view('member.index', compact('members'));
	}

	public function create() {
        return view('member.create');
    }


	public function store() {
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
	}
	
	/**
	 * Display the specified member.
	 *
	 * @param  int  $member
	 * @return Response
	 */
	public function show(Member $member) {
		return view('member.show', compact('member', $member));
	}

	/**
	 * Show the form for editing the specified member.
	 *
	 * @param  int  $member
	 * @return Response
	 */
	public function edit(Member $member) {
		return view('member.edit', compact('member', $member));
	}

}