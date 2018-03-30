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
		if (auth()->check()) {
			$isModelModified = false;

			if (request('name') != '') {
				$validator = Validator::make(request()->all(), [
					'name' => 'required',
				]);

				if ($validator->fails()) {
					return back()->withErrors($validator)->withInput();
				} else {
					$user->fill([
						'name' => request('name')
					]);
					$isModelModified = true;	
				}
			} 
			
			$isPasswordModified = false;
			// Any valid password change request must include the old password 
			if (request('password') != '') {
				$validator = Validator::make(request()->all(), [
					'password' => 'required_with:newPassword',
					'newPassword' => 'required|confirmed',
				]);
				if ($validator->fails()) {
					return back()->withErrors($validator)->withInput();
				} else {
					// Probably should send a notification email as well
					$user->fill([
						'password' => Hash::make(request('newPassword'))
						]);
					$isModelModified = true;
					$isPasswordModified = true;
				}
			}

			// If this conditional succeeds, it implies the user entered something
			// into the new password fields without entering anything in the old
			// password field, and this by definition is an error.
			if ($isPasswordModified == false && 
			    (request('newPassword') != '' || request('newPassword_confirmation') != '')) {
				$validator = Validator::make(request()->all(), [
					'password' => 'required_with:newPassword',
					'newPassword' => 'required|confirmed',
				]);
				$validator->errors()->add('password', 'Must enter a valid new password');
				return back()->withErrors($validator)->withInput();
			}

			if ($isModelModified) {
				$user->save();
				return redirect()->action('UsersController@show', $user); 
			}

			// FIXME: What happens if the user wants to cancel???
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

