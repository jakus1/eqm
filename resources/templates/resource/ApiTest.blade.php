##php

use Core;
use {{ $namespace or '' }}\Models\User;
use {{ $namespace or '' }}\Models\{{ $Model or '' }};
use Illuminate\Support\Facades\Hash;

class {{ $model or '' }}Cest
{
	
	public function _before(ApiTester $I)
	{
		// First, log in
		$I->amLoggedAs(config('auth.providers.users.model',User::class)::find(1));
		// create an instance of the model to use for the store method
		$this->new_{{ $model or '' }} = factory(\{{ $namespace or '' }}\Models\{{ $Model or '' }}::class)->make();

		// UNCOMMENT THE FOLLOWING 3 LINES IF THIS IS A CHILD/DEPENDANT RECORD
		// $parent = User::inRandomOrder()->first();
		// $this->new_{{ $model or '' }}->parentType = Core::getModelCode($parent);
		// $this->new_{{ $model or '' }}->parentId = $parent->id;
		
		// another to use for the update
		$this->change_{{ $model or '' }} = factory(\{{ $namespace or '' }}\Models\{{ $Model or '' }}::class)->make();

		// And, save one to the database to use for the get methods
		$this->existing_{{ $model or '' }} = factory(\{{ $namespace or '' }}\Models\{{ $Model or '' }}::class)->create();	
	}

	public function _after(ApiTester $I)
	{
	}

	// tests
	public function store{{ $Model or '' }}(ApiTester $I)
	{
		$I->wantTo('create a {{ $model or '' }} via API');
		$I->sendAjaxPostRequest('api/{{ $model or '' }}', $this->new_{{ $model or '' }}->toArray());
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function get{{ $Model or '' }}(ApiTester $I)
	{
		$I->wantTo('get a {{ $model or '' }} via API');
		$I->sendAjaxGetRequest('api/{{ $model or '' }}/'.$this->existing_{{ $model or '' }}->id);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function getAll{{ $Models or '' }}(ApiTester $I)
	{
		$I->wantTo('get all {{ $models or '' }} via API');
		$I->sendAjaxGetRequest('api/all-{{ $models or '' }}');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}
	
	// public function get{{ $Models or '' }}ByParent(ApiTester $I)
	// {
	// 	$I->wantTo('get all {{ $model or '' }} by a parent via API');
	// 	$existing_array = $this->existing_{{ $model or '' }}->toArray();
	// 	$I->sendAjaxGetRequest('api/{{ $models or '' }}-by-parent/'.$existing_array->{{ $model or '' }}able_id."/".$existing_array->{{ $model or '' }}able_type);
	// 	$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	// 	$I->seeResponseIsJson();
	// 	$I->seeResponseContains('{"http_code":200,"message"');
	// }

	public function update{{ $Model or '' }}(ApiTester $I)
	{
		$I->wantTo('update a {{ $model or '' }} via API');
		$I->sendAjaxRequest('PUT','api/{{ $model or '' }}/'.$this->existing_{{ $model or '' }}->id, $this->change_{{ $model or '' }}->toArray());
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function delete{{ $Model or '' }}(ApiTester $I)
	{
		$I->wantTo('delete a {{ $model or '' }} via API');
		$I->sendAjaxPostRequest('api/{{ $model or '' }}/'.$this->existing_{{ $model or '' }}->id,['_method'=>'DELETE']);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}
}
