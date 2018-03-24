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

Route::get('/', 'MemberController@index')->name('home');
Route::get('/member/create', 'MemberController@create');
Route::post('/member', 'MemberController@store');
Route::get('/member/{member}', 'MemberController@show');
Route::get('/member/edit/{member}', 'MemberController@edit');

Route::get('/user/create', 'UserController@create');
Route::post('/user', 'UserController@store');
Route::get('/user/{user}', 'UserController@show')->name('user');

Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy');

Route::get('dev/jake', 'DevelopController@getJake');


