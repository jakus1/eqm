##php

use {{ $namespace or '' }}\Models\User;
use {{ $namespace or '' }}\Models\{{ $Model or '' }};
use Illuminate\Support\Facades\Hash;

class {{ $model or '' }}ControllerCest
{
	public function _before(FunctionalTester $I)
	{
		// First, log in
		$I->amLoggedAs(config('auth.providers.users.model',User::class)::find(1));

		// // Uncomment the lines below if the model is normally a child
		// $parent = User::inRandomOrder()->first();
		// $this->parentType = Core::getModelCode($parent);
		// $this->parentId = $parent->id;

		$this->existing_{{ $model or '' }} = factory(\{{ $namespace or '' }}\Models\{{ $Model or '' }}::class)->create();	
	}

	public function _after(FunctionalTester $I)
	{
	}

	// tests
	public function {{ $model or '' }}Index(FunctionalTester $I)
	{
		$I->wantTo('check the index {{ $model or '' }} view');
		$I->amOnAction('\{{ $namespace or '' }}\Http\Controllers\{{ $Models or '' }}Controller@index');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function {{ $model or '' }}Show(FunctionalTester $I)
	{
		$I->wantTo('check the show {{ $model or '' }} view');
		$I->amOnAction('\{{ $namespace or '' }}\Http\Controllers\{{ $Models or '' }}Controller@show',[$this->existing_{{ $model or '' }}->id]);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function {{ $model or '' }}Create(FunctionalTester $I)
	{
		$I->wantTo('check the create {{ $model or '' }} view');
		// Use this line for parent child model
		// $I->amOnAction('\{{ $namespace or '' }}\Http\Controllers\{{ $Models or '' }}Controller@create',['parentType'=>$this->parentType,'parentId'=>$this->parentId]);
		$I->amOnAction('\{{ $namespace or '' }}\Http\Controllers\{{ $Models or '' }}Controller@create');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

	public function {{ $model or '' }}Edit(FunctionalTester $I)
	{
		$I->wantTo('check the edit {{ $model or '' }} view');
		$I->amOnAction('\{{ $namespace or '' }}\Http\Controllers\{{ $Models or '' }}Controller@edit',[$this->existing_{{ $model or '' }}->id]);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	}

}
