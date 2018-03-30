<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Register a default route */
Route::get('/', function() {
	return view('public.index');
  })->name('home');

Route::resource('user', 'UsersController'); // get:/user, get:/user/create, post:/user, get:/user/{user}, get:/user/{user}/edit, put:/user/{user}, delete:/user/{user}

Route::resource('member', 'MembersController'); // get:/member, get:/member/create, post:/member, get:/member/{member}, get:/member/{member}/edit, put:/member/{member}, delete:/member/{member}

Route::resource('message', 'MessagesController');

Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy');

Route::get('dev/jake', 'DevelopController@getJake');


