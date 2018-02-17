<?php

use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class memberControllerCest
{
	public function _before(FunctionalTester $I)
	{
		// First, log in
		$I->amLoggedAs(config('auth.providers.users.model',User::class)::find(1));

		// // Uncomment the lines below if the model is normally a child
		// $parent = User::inRandomOrder()->first();
		// $this->parentType = Core::getModelCode($parent);
		// $this->parentId = $parent->id;

		$this->existing_member = factory(\App\Models\Member::class)->create();	
	}

	public function _after(FunctionalTester $I)
	{
	}

	// tests
	public function memberIndex(FunctionalTester $I)
	{
		$I->wantTo('check the index member view');
		$I->amOnAction('\App\Http\Controllers\MembersController@index');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function memberShow(FunctionalTester $I)
	{
		$I->wantTo('check the show member view');
		$I->amOnAction('\App\Http\Controllers\MembersController@show',[$this->existing_member->id]);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function memberCreate(FunctionalTester $I)
	{
		$I->wantTo('check the create member view');
		// Use this line for parent child model
		// $I->amOnAction('\App\Http\Controllers\MembersController@create',['parentType'=>$this->parentType,'parentId'=>$this->parentId]);
		$I->amOnAction('\App\Http\Controllers\MembersController@create');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function memberEdit(FunctionalTester $I)
	{
		$I->wantTo('check the edit member view');
		$I->amOnAction('\App\Http\Controllers\MembersController@edit',[$this->existing_member->id]);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

}
