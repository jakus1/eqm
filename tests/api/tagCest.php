<?php

use Core;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;

class tagCest
{
	
	public function _before(ApiTester $I)
	{
		// First, log in
		$I->amLoggedAs(config('auth.providers.users.model',User::class)::find(1));
		// create an instance of the model to use for the store method
		$this->new_tag = factory(\App\Models\Tag::class)->make();

		// UNCOMMENT THE FOLLOWING 3 LINES IF THIS IS A CHILD/DEPENDANT RECORD
		// $parent = User::inRandomOrder()->first();
		// $this->new_tag->parentType = Core::getModelCode($parent);
		// $this->new_tag->parentId = $parent->id;
		
		// another to use for the update
		$this->change_tag = factory(\App\Models\Tag::class)->make();

		// And, save one to the database to use for the get methods
		$this->existing_tag = factory(\App\Models\Tag::class)->create();	
	}

	public function _after(ApiTester $I)
	{
	}

	// tests
	public function storeTag(ApiTester $I)
	{
		$I->wantTo('create a tag via API');
		$I->sendAjaxPostRequest('api/tag', $this->new_tag->toArray());
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function getTag(ApiTester $I)
	{
		$I->wantTo('get a tag via API');
		$I->sendAjaxGetRequest('api/tag/'.$this->existing_tag->id);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function getAllTags(ApiTester $I)
	{
		$I->wantTo('get all tags via API');
		$I->sendAjaxGetRequest('api/all-tags');
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}
	
	// public function getTagsByParent(ApiTester $I)
	// {
	// 	$I->wantTo('get all tag by a parent via API');
	// 	$existing_array = $this->existing_tag->toArray();
	// 	$I->sendAjaxGetRequest('api/tags-by-parent/'.$existing_array->tagable_id."/".$existing_array->tagable_type);
	// 	$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
	// 	$I->seeResponseIsJson();
	// 	$I->seeResponseContains('{"http_code":200,"message"');
	// }

	public function updateTag(ApiTester $I)
	{
		$I->wantTo('update a tag via API');
		$I->sendAjaxRequest('PUT','api/tag/'.$this->existing_tag->id, $this->change_tag->toArray());
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}

	public function deleteTag(ApiTester $I)
	{
		$I->wantTo('delete a tag via API');
		$I->sendAjaxPostRequest('api/tag/'.$this->existing_tag->id,['_method'=>'DELETE']);
		$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
		$I->seeResponseIsJson();
		$I->seeResponseContains('{"http_code":200,"message"');
	}
}
