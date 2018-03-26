<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            return redirect()->route('members');
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
	 * Display the user creation page
	 *
	 * @return home page if successful, otherwise errors will be displayed
	 */
    public function store(RegistrationRequest $request) 
    {
        $request->persist();
        
        // Redirect back to home page
        return redirect()->home();
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
}
