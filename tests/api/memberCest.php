<?php

use Core;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class memberCest
{
	
	public function _before(ApiTester $I)
	{
		// First, log in
		$I->amLoggedAs(config('auth.providers.users.model',User::class)::find(1));
		// create an instance of the model to use for the store method
		$this->new_member = factory(\App\Models\Member::class)->make();

		// UNCOMMENT THE FOLLOWING 3 LINES IF THIS IS A CHILD/DEPENDANT RECORD
		// $parent = User::inRandomOrder()->first();
		// $this->new_member->parentType = Core::getModelCode($parent);
		// $this->new_member->parentId = $parent->id;
		
		// another to use for the update
		$this->change_member = factory(\App\Models\Member::class)->make();

		// And, save one to the database to use for the get methods
		$this->existing_member = factory(\App\Models\Member::class)->create();	
	}

	public function _after(ApiTester $I)
	{
	}

	// tests
	public function storeMember(ApiTester $I)
	{
		$I->wantTo('create a member via API');
		$I->sendAjaxPostRequest('api/member', $this->new_member->toArray());
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function getMember(ApiTester $I)
	{
		$I->wantTo('get a member via API');
		$I->sendAjaxGetRequest('api/member/'.$this->existing_member->id);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function getAllMembers(ApiTester $I)
	{
		$I->wantTo('get all members via API');
		$I->sendAjaxGetRequest('api/all-members');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}
	
	// public function getMembersByParent(ApiTester $I)
	// {
	// 	$I->wantTo('get all member by a parent via API');
	// 	$existing_array = $this->existing_member->toArray();
	// 	$I->sendAjaxGetRequest('api/members-by-parent/'.$existing_array->memberable_id."/".$existing_array->memberable_type);
	// 	$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	// 	$I->seeResponseIsJson();
	// 	$I->seeResponseContains('{"http_code":200,"message"');
	// }

	public function updateMember(ApiTester $I)
	{
		$I->wantTo('update a member via API');
		$I->sendAjaxRequest('PUT','api/member/'.$this->existing_member->id, $this->change_member->toArray());
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function deleteMember(ApiTester $I)
	{
		$I->wantTo('delete a member via API');
		$I->sendAjaxPostRequest('api/member/'.$this->existing_member->id,['_method'=>'DELETE']);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}
}
