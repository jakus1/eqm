<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;

class UserController extends Controller
{
    public function create() {
        if (auth()->check()) {
            return redirect()->home();
        } else {
            return view('user.create');
        }
    }

    public function store(RegistrationRequest $request) {
        $request->persist();
        
        // Redirect back to home page
        return redirect()->home();
    }

    public function show(User $user) {
        return view('user.show', compact('user', $user));
    }
}
