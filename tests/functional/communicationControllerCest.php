<?php

use App\Models\User;
use App\Models\Communication;
use Illuminate\Support\Facades\Hash;

class communicationControllerCest
{
	public function _before(FunctionalTester $I)
	{
		// First, log in
		$I->amLoggedAs(config('auth.providers.users.model',User::class)::find(1));

		// // Uncomment the lines below if the model is normally a child
		// $parent = User::inRandomOrder()->first();
		// $this->parentType = Core::getModelCode($parent);
		// $this->parentId = $parent->id;

		$this->existing_communication = factory(\App\Models\Communication::class)->create();	
	}

	public function _after(FunctionalTester $I)
	{
	}

	// tests
	public function communicationIndex(FunctionalTester $I)
	{
		$I->wantTo('check the index communication view');
		$I->amOnAction('\App\Http\Controllers\CommunicationsController@index');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function communicationShow(FunctionalTester $I)
	{
		$I->wantTo('check the show communication view');
		$I->amOnAction('\App\Http\Controllers\CommunicationsController@show',[$this->existing_communication->id]);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function communicationCreate(FunctionalTester $I)
	{
		$I->wantTo('check the create communication view');
		// Use this line for parent child model
		// $I->amOnAction('\App\Http\Controllers\CommunicationsController@create',['parentType'=>$this->parentType,'parentId'=>$this->parentId]);
		$I->amOnAction('\App\Http\Controllers\CommunicationsController@create');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function communicationEdit(FunctionalTester $I)
	{
		$I->wantTo('check the edit communication view');
		$I->amOnAction('\App\Http\Controllers\CommunicationsController@edit',[$this->existing_communication->id]);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

}
