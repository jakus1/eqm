##php namespace {{ $namespace or ''}}\Http\Controllers;

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
use {{$namespace or ''}}\Models\{{ $Model or ''}};

class {{ $Models or ''}}Controller extends BaseController {

	/**
	 * Display a listing of {{ $models or ''}}
	 *
	 * {{'@return'}} Response
	 */
	public function index()
	{
		// ${{ $models or ''}} = {{ $Model or ''}}::all();
		return view('{{ $model or '' }}.index');
	}

	/**
	 * Show the form for creating a new {{ $model or '' }}
	 *
	 * {{'@return'}} Response
	 */
	public function create()
	{
		return view('{{ $model or '' }}.create');
	}

	/**
	 * Display the specified {{ $model or '' }}.
	 *
	 * {{'@param'}}  int  $id
	 * {{'@return'}} Response
	 */
	public function show($id)
	{
		$the_record = ${{ $model or '' }} = {{ $Model or ''}}::findOrFail($id);
		return view('{{ $model or '' }}.show', compact('{{ $model or '' }}','the_record'));
	}

	/**
	 * Show the form for editing the specified {{ $model or '' }}.
	 *
	 * {{'@param'}}  int  $id
	 * {{'@return'}} Response
	 */
	public function edit($id)
	{
		${{ $model or '' }} = {{ $Model or ''}}::find($id);
		return view('{{ $model or '' }}.edit', compact('{{ $model or '' }}'));
	}

}