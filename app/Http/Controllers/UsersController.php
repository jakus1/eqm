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
    public function store(RegistrationRequest $request) 
    {
        $request->persist();
        
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
            $this->validate(request(), [
                'name' => 'required',
                'password' => 'required|confirmed'
            ]);
    
            $user->name = request('name');
            $user->password = Hash::make(request('password'));
    
            $user->save();
    
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
