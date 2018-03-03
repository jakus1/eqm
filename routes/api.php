<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::group([
	'prefix' => 'listeners',
],function () {
	Route::group([
		'middleware' => ['mailgun.webhook'],
	],function () {
		Route::any('mailgun', 'IncomingMessageController@mailgun');
	});
	Route::any('nexmo', 'IncomingMessageController@nexmo');
	Route::any('nexmo-delivery-receipt', 'IncomingMessageController@nexmoReceipt');
});

Route::group([
	'prefix' => 'nexmo',
],function () {
});