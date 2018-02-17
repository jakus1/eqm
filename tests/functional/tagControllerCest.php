<?php

use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;

class tagControllerCest
{
	public function _before(FunctionalTester $I)
	{
		// First, log in
		$I->amLoggedAs(config('auth.providers.users.model',User::class)::find(1));

		// // Uncomment the lines below if the model is normally a child
		// $parent = User::inRandomOrder()->first();
		// $this->parentType = Core::getModelCode($parent);
		// $this->parentId = $parent->id;

		$this->existing_tag = factory(\App\Models\Tag::class)->create();	
	}

	public function _after(FunctionalTester $I)
	{
	}

	// tests
	public function tagIndex(FunctionalTester $I)
	{
		$I->wantTo('check the index tag view');
		$I->amOnAction('\App\Http\Controllers\TagsController@index');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function tagShow(FunctionalTester $I)
	{
		$I->wantTo('check the show tag view');
		$I->amOnAction('\App\Http\Controllers\TagsController@show',[$this->existing_tag->id]);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function tagCreate(FunctionalTester $I)
	{
		$I->wantTo('check the create tag view');
		// Use this line for parent child model
		// $I->amOnAction('\App\Http\Controllers\TagsController@create',['parentType'=>$this->parentType,'parentId'=>$this->parentId]);
		$I->amOnAction('\App\Http\Controllers\TagsController@create');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function tagEdit(FunctionalTester $I)
	{
		$I->wantTo('check the edit tag view');
		$I->amOnAction('\App\Http\Controllers\TagsController@edit',[$this->existing_tag->id]);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

}
