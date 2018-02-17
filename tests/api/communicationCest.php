<?php

use Core;
use App\Models\User;
use App\Models\Communication;
use Illuminate\Support\Facades\Hash;

class communicationCest
{
	
	public function _before(ApiTester $I)
	{
		// First, log in
		$I->amLoggedAs(config('auth.providers.users.model',User::class)::find(1));
		// create an instance of the model to use for the store method
		$this->new_communication = factory(\App\Models\Communication::class)->make();

		// UNCOMMENT THE FOLLOWING 3 LINES IF THIS IS A CHILD/DEPENDANT RECORD
		// $parent = User::inRandomOrder()->first();
		// $this->new_communication->parentType = Core::getModelCode($parent);
		// $this->new_communication->parentId = $parent->id;
		
		// another to use for the update
		$this->change_communication = factory(\App\Models\Communication::class)->make();

		// And, save one to the database to use for the get methods
		$this->existing_communication = factory(\App\Models\Communication::class)->create();	
	}

	public function _after(ApiTester $I)
	{
	}

	// tests
	public function storeCommunication(ApiTester $I)
	{
		$I->wantTo('create a communication via API');
		$I->sendAjaxPostRequest('api/communication', $this->new_communication->toArray());
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function getCommunication(ApiTester $I)
	{
		$I->wantTo('get a communication via API');
		$I->sendAjaxGetRequest('api/communication/'.$this->existing_communication->id);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function getAllCommunications(ApiTester $I)
	{
		$I->wantTo('get all communications via API');
		$I->sendAjaxGetRequest('api/all-communications');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}
	
	// public function getCommunicationsByParent(ApiTester $I)
	// {
	// 	$I->wantTo('get all communication by a parent via API');
	// 	$existing_array = $this->existing_communication->toArray();
	// 	$I->sendAjaxGetRequest('api/communications-by-parent/'.$existing_array->communicationable_id."/".$existing_array->communicationable_type);
	// 	$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	// 	$I->seeResponseIsJson();
	// 	$I->seeResponseContains('{"http_code":200,"message"');
	// }

	public function updateCommunication(ApiTester $I)
	{
		$I->wantTo('update a communication via API');
		$I->sendAjaxRequest('PUT','api/communication/'.$this->existing_communication->id, $this->change_communication->toArray());
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function deleteCommunication(ApiTester $I)
	{
		$I->wantTo('delete a communication via API');
		$I->sendAjaxPostRequest('api/communication/'.$this->existing_communication->id,['_method'=>'DELETE']);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}
}
