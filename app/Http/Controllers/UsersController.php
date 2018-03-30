<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;

class UsersController extends Controller
{
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
	 * Display the user creation page. This is available to everyone
	 *
	 * @return user creation page
	 */
	public function create() 
	{
		if (auth()->check()) {
			return redirect()->home();
		} else {
			return view('user.create');
		}
	}

	/**
	 * Store a new user
	 *
	 * @return home page if successful, otherwise errors will be displayed
	 */
	public function store() 
	{
		$this->validate(request(), [
			'name' => 'required',
			'email' => 'required|unique:users,email',
			/*
				Note the "confirmed" validation requires an associated
				_confirmation input form
			*/
			'password' => 'required|confirmed'
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
		
		// Redirect back to home page
		return redirect()->home();
	}

		/**
	 * Save changes to an existing member from a PUT request
	 *
	 * @param $member
	 * @return redirect to show or home page
	 */
	public function update(User $user) 
	{
		$isModelChanged = false;

		if (auth()->check()) {
			// Check to see if they changed the name
			if (request('name') != '') {
				$user->name = request('name');
				$isModelChanged = true;
			}
			
			// Check to see if they changed the password
			if (request('password') != '' && request('newPassword') != '' &&
			    request('newPassword_confirmation') != '' ) {
				$this->validate(request(), [
					'password' => 'required_with:new_password|password',
					'new_password' => 'confirmed'
				]);	

			if (Hash::check($request->password, $user->password)) { 
				$user->fill([
					'password' => Hash::make($request->newPassword)
					]);
					$isModelChanged = true;
				} else {
					// ??? Throw an error?
				}
			}

			if ($isModelChanged) {
				$user->save();
			}
			// Redirect back to show page
			return redirect()->action('UsersController@show', $user);	 
		} else {
			return redirect()->home();
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
		return view('user.edit', compact('user'));
	}
}

