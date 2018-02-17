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

class MembersController extends BaseController {

	/**
	 * Display a listing of members
	 *
	 * @return Response
	 */
	public function index()
	{
		// $members = Member::all();
		return view('member.index');
	}

	/**
	 * Show the form for creating a new member
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('member.create');
	}

	/**
	 * Display the specified member.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$the_record = $member = Member::findOrFail($id);
		return view('member.show', compact('member','the_record'));
	}

	/**
	 * Show the form for editing the specified member.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$member = Member::find($id);
		return view('member.edit', compact('member'));
	}

}