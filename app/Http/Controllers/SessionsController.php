<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SessionsController extends Controller
{

	/**
	 * Constructor
	 *
	 */
	public function __construct() 
	{
		/*
			The following means only non-logged in users (guests) will use the
			functionality in this class, except the destroy method. Stated 
			differently, logged in users don't need anything from this class
			except the logout (destroy) functionality.
		*/
		$this->middleware('guest', ['except' => 'destroy']);

	}

	/**
	 * Display the login page (ie. create a login session)
	 *
	 * @return home page if successful, otherwise errors will be displayed
	 */
	public function create() 
	{
		return view('sessions.create');
	}

	/**
	 * Attempt to register a new user
	 *
	 * @return home page if successful, otherwise errors will be displayed
	 */
	public function store() 
	{
		// Attempt to authenticate user
		$email = request('email');
		$password = request('password');

		if (!auth()->attempt(compact('email', 'password'))) {
			return back()->withErrors([
				'message' => 'Please check your credentials and try again'
			]);
		}

		// Redirect to home or back to login page
		return redirect()->route('home');
	}

	/**
	 * Perform a logout of authenticated user
	 *
	 * @return home page
	 */
	public function destroy() 
	{
		auth()->logout();

		return redirect()->home();
	}
}
