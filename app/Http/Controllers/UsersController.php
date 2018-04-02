<?php

namespace App\Http\Controllers;

use Validator;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersController extends Controller
{
	/**
	 * Constructor
	 *
	 */
	/*
	public function __construct() 
	{
		// You must be signed in to see or create members
		$this->middleware('auth', ['except' => 'index', 'create', 'store']);
	}
	*/

	/**
	 * Primary access point, home
	 *
	 * @return members view if logged in, otherwise login
	 */
	public function index() 
	{
		if (auth()->check()) {
			return redirect()->action('MembersController@index');
		} else {
			return redirect()->route('login');
		}
	}
	/**
	 * Display the user creation page. Only guests can use this page.
	 *
	 * @return user creation page
	 */
	public function create() 
	{
		if (!auth()->check()) {
			return view('user.create'); 
		} else {
			return redirect()->home();
		}
	}

	/**
	 * Store a new user. Only guests can use this page.
	 *
	 * @return home page if successful, otherwise errors will be displayed
	 */
	public function store() 
	{
		if (!auth()->check()) {

			$this->validate(request(), [
				'name' => 'required',
				'email' => 'required|unique:users,email',
				/*
					Note the "confirmed" validation requires an associated
					_confirmation input form
				*/
				'password' => 'required|confirmed|min:8'
			]);

			$name = request('name');
			$email = request('email');
			$password = Hash::make(request('password'));

			// Create and save the user
			try{
				$user = User::create(compact('name', 'email', 'password'));
			} catch(\Exception $exception){
				Log::error('Database error! '.$exception->getCode());
			}

			// Sign the user in
			auth()->login($user);
		} 
		return redirect()->home();
	}

		/**
	 * Save changes to an existing member from a PUT .
	 * Only logged in users can use this page.
	 *
	 * @param $member
	 * @return redirect to show or home page
	 */
	public function update(User $user) 
	{
		if (auth()->check()) {
			$data = request()->all();

			$validator = Validator::make(request()->all(), [
				'name' => 'sometimes',
				'password' => 'required_with:newPassword',
				'newPassword' => 'required_with:password|confirmed|min:8',
			]);

			$validator->after(function ($validator) {
				if ((request('password') == '') && (request('newPassword') != '' || request('newPassword_confirmation') != '')) {
					$validator->errors()->add('password', 'Existing password required to change password.');
				} else if ((request('password') != '') && (request('newPassword') == '' || request('newPassword_confirmation') == '')) {
					$validator->errors()->add('password', 'New password must be 8 characters.');
				}
			});
	
			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			} else {
				$data['password'] = Hash::make(request('newPassword'));
	
				$user->update($data);
				return redirect()->action('UsersController@show', $user); 	
			}
		} else {
			redirect()->home();
		}
	}

	/**
	 * Display a page to display user
	 *
	 * @return home page if successful, otherwise errors will be displayed
	 */
	public function show(User $user) 
	{
		if (auth()->check()) {
			return view('user.show', compact('user'));
		} else {
			return redirect()->home();
		}  
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  $user
	 * @return Response
	 */
	public function edit(User $user) 
	{
		if (auth()->check()) {
			return view('user.edit', compact('user'));
		} else {
			return redirect()->home();
		}
	}
}

