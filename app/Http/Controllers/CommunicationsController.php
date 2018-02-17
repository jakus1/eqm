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
use App\Models\Communication;

class CommunicationsController extends BaseController {

	/**
	 * Display a listing of communications
	 *
	 * @return Response
	 */
	public function index()
	{
		// $communications = Communication::all();
		return view('communication.index');
	}

	/**
	 * Show the form for creating a new communication
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('communication.create');
	}

	/**
	 * Display the specified communication.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$the_record = $communication = Communication::findOrFail($id);
		return view('communication.show', compact('communication','the_record'));
	}

	/**
	 * Show the form for editing the specified communication.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$communication = Communication::find($id);
		return view('communication.edit', compact('communication'));
	}

}