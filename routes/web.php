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
Route::get('/members/create', 'MembersController@create');
Route::post('/members', 'MembersController@store');

Route::get('dev/jake', 'DevelopController@getJake');


