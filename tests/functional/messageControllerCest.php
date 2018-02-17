<?php

use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;

class messageControllerCest
{
	public function _before(FunctionalTester $I)
	{
		// First, log in
		$I->amLoggedAs(config('auth.providers.users.model',User::class)::find(1));

		// // Uncomment the lines below if the model is normally a child
		// $parent = User::inRandomOrder()->first();
		// $this->parentType = Core::getModelCode($parent);
		// $this->parentId = $parent->id;

		$this->existing_message = factory(\App\Models\Message::class)->create();	
	}

	public function _after(FunctionalTester $I)
	{
	}

	// tests
	public function messageIndex(FunctionalTester $I)
	{
		$I->wantTo('check the index message view');
		$I->amOnAction('\App\Http\Controllers\MessagesController@index');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function messageShow(FunctionalTester $I)
	{
		$I->wantTo('check the show message view');
		$I->amOnAction('\App\Http\Controllers\MessagesController@show',[$this->existing_message->id]);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function messageCreate(FunctionalTester $I)
	{
		$I->wantTo('check the create message view');
		// Use this line for parent child model
		// $I->amOnAction('\App\Http\Controllers\MessagesController@create',['parentType'=>$this->parentType,'parentId'=>$this->parentId]);
		$I->amOnAction('\App\Http\Controllers\MessagesController@create');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function messageEdit(FunctionalTester $I)
	{
		$I->wantTo('check the edit message view');
		$I->amOnAction('\App\Http\Controllers\MessagesController@edit',[$this->existing_message->id]);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

}
