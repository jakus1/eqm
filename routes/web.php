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

Route::get('/', 'MembersController@index')->name('home');
Route::get('/member/create', 'MembersController@create');
Route::post('/member', 'MembersController@store');
Route::get('/member/{member}', 'MembersController@show');
Route::get('/member/edit/{member}', 'MembersController@edit');

Route::get('/user/create', 'UserController@create');
Route::post('/user', 'UserController@store');
Route::get('/user/{user}', 'UserController@show');

Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy');

Route::get('dev/jake', 'DevelopController@getJake');


