<?php namespace App\Traits\ApiCtrl;

use Illuminate\Http\Request;
use App\Http\Responses\AjaxResponse;

use Core;
use Log;

use App\Models\Message;

trait MessageTrait
{
	public function getAllmessages($q = null, $max_records = 750)
	{
		$response = app(AjaxResponse::class);
		if (is_null($q)) {
			$response->count = Message::count();
			if ($response->count == 0) {
				$response->count = 0;
				return $response->success();
			}
			if ($response->count > $max_records) {
				$message = Message::MostRecent()->take($max_records)->get();
				$response->count = $message->count();
				return $response->success($message);
			}
			$message = Message::all();
			return $response->success($message);
		} else {
			$message = Message::defaultSearch($q)->take($max_records)->get();
			return $response->success($message);
		}
		$response->message = '$q is neither null nor not null ...WTF?!?!';
		return $response->error();
	}

	public function getSearchmessages($q = null){

		$response = app(AjaxResponse::class);
		$results = $message = Message::withTrashed()->BySearch($q);
		$response->count = $results->count();
		if($response->count == 0){
			$response->count = 0;
			return $response->success();
		}
		if($response->count > 1000){
			return $response->success();
		}
		$messages = $results->get();
		return $response->success($messages);
	}

	public function getMessagesByParent($parentId,$parentType = '')
	{
		$response = app(AjaxResponse::class);
		$parent = Core::getParent($parentId,$parentType);
		$messages = $parent->messages;
		return $response->success($messages);
	}


	public function getmessagesByProperty($propertyName,$propertyValue)
	{
		$response = app(AjaxResponse::class);
		$messages =Message::where($propertyName,$propertyValue)
			->get();
		return $response->success($messages);
	}

	public function getMessage($id)
	{
		$response = app(AjaxResponse::class);
		$message = Message::findOrFail($id);
		return $response->success($message);
	}

	public function postMessage()
	{
		$data = $this->request->all();
		$response = app(AjaxResponse::class);
		$this->validate($this->request, Message::$rules['create']);
		$message = Message::create($data);
		return $response->success($message);
	}

	public function putMessage($id)
	{
		$data = $this->request->all();
		$response = app(AjaxResponse::class);
		$this->validate($this->request, Message::$rules['update']);
		$message = Message::findOrFail($id);
		$message->update($data);
		return $response->success($message);
	}

	public function deleteMessage($messageId)
	{
		$response = app(AjaxResponse::class);
		$message = Message::find($messageId);
		if($message->delete()){
			return $response->success($message);
		}
		return $response->error($message);
	}

	public function postAttachMessageToParent()
	{
		$data = $this->request->all();
		$parent = Core::getParent($data['parentId'],$data['parentType']);
		$message = Message::findOrFail($data['messageId']);
		$parent->messages()->syncWithoutDetaching([$message->id]);
		$response = app(AjaxResponse::class);
		$response->message = $message->name." has been added.";
		return $response->success($message);
	}

	public function postDetachMessageFromParent()
	{
		$data = $this->request->all();
		$parent = Core::getParent($data['parentId'],$data['parentType']);
		$message = Message::findOrFail($data['messageId']);
		$parent->messages()->detach($message->id);
		$parent->load('messages');
		$response = app(AjaxResponse::class);
		$response->message = $message->name." was successfully removed.";
		return $response->success($parent);
	}

}