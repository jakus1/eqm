<?php

use Core;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;

class messageCest
{
	
	public function _before(ApiTester $I)
	{
		// First, log in
		$I->amLoggedAs(config('auth.providers.users.model',User::class)::find(1));
		// create an instance of the model to use for the store method
		$this->new_message = factory(\App\Models\Message::class)->make();

		// UNCOMMENT THE FOLLOWING 3 LINES IF THIS IS A CHILD/DEPENDANT RECORD
		// $parent = User::inRandomOrder()->first();
		// $this->new_message->parentType = Core::getModelCode($parent);
		// $this->new_message->parentId = $parent->id;
		
		// another to use for the update
		$this->change_message = factory(\App\Models\Message::class)->make();

		// And, save one to the database to use for the get methods
		$this->existing_message = factory(\App\Models\Message::class)->create();	
	}

	public function _after(ApiTester $I)
	{
	}

	// tests
	public function storeMessage(ApiTester $I)
	{
		$I->wantTo('create a message via API');
		$I->sendAjaxPostRequest('api/message', $this->new_message->toArray());
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function getMessage(ApiTester $I)
	{
		$I->wantTo('get a message via API');
		$I->sendAjaxGetRequest('api/message/'.$this->existing_message->id);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function getAllMessages(ApiTester $I)
	{
		$I->wantTo('get all messages via API');
		$I->sendAjaxGetRequest('api/all-messages');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}
	
	// public function getMessagesByParent(ApiTester $I)
	// {
	// 	$I->wantTo('get all message by a parent via API');
	// 	$existing_array = $this->existing_message->toArray();
	// 	$I->sendAjaxGetRequest('api/messages-by-parent/'.$existing_array->messageable_id."/".$existing_array->messageable_type);
	// 	$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	// 	$I->seeResponseIsJson();
	// 	$I->seeResponseContains('{"http_code":200,"message"');
	// }

	public function updateMessage(ApiTester $I)
	{
		$I->wantTo('update a message via API');
		$I->sendAjaxRequest('PUT','api/message/'.$this->existing_message->id, $this->change_message->toArray());
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function deleteMessage(ApiTester $I)
	{
		$I->wantTo('delete a message via API');
		$I->sendAjaxPostRequest('api/message/'.$this->existing_message->id,['_method'=>'DELETE']);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}
}
