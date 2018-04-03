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
	public function __construct() 
	{
		// You must be signed in to see or create members
		$this->middleware('auth', ['except' => 'create', 'store']);
	}

	/**
	 * Index page for users
	 *
	 * @return members view if logged in, otherwise login
	 */
	public function index() 
	{
		return redirect()->action('MembersController@index');
	}
	/**
	 * Display the user creation page. 
	 *
	 * @return user creation page
	 */
	public function create() 
	{
		return view('user.create'); 
	}

	/**
	 * Store a new user. 
	 * 
	 * @return home page if successful, otherwise errors will be displayed
	 */
	public function store() 
	{
		dd(request()-all());
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
		return redirect()->action('MembersController@index');
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
		$data = request()->all();

		$validator = Validator::make($data, [
			'name' => 'sometimes',
			'password' => 'required_with:newPassword',
			'newPassword' => 'required_with:password|confirmed|min:8',
		]);

		$validator->after(function ($validator) use ($data, $user) {
			if (!Hash::check($data['password'], $user->password)) {
				$validator->errors()->add('password', 'Invalid existing password entered');
			}
		});

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			$data['password'] = Hash::make(request('newPassword'));

			$user->update($data);
			return redirect()->action('UsersController@show', $user); 	
		}
	}

	/**
	 * Display a page to display user
	 *
	 * @return home page if successful, otherwise errors will be displayed
	 */
	public function show(User $user) 
	{
		return view('user.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  $user
	 * @return Response
	 */
	public function edit(User $user) 
	{
		return view('user.edit', compact('user'));
	}
}

