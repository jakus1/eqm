<?php namespace App\Traits\ApiCtrl;

use Illuminate\Http\Request;
use App\Http\Responses\AjaxResponse;

use Core;
use Log;

use App\Models\Communication;

trait CommunicationTrait
{
	public function getAllcommunications($q = null, $max_records = 750)
	{
		$response = app(AjaxResponse::class);
		if (is_null($q)) {
			$response->count = Communication::count();
			if ($response->count == 0) {
				$response->count = 0;
				return $response->success();
			}
			if ($response->count > $max_records) {
				$communication = Communication::MostRecent()->take($max_records)->get();
				$response->count = $communication->count();
				return $response->success($communication);
			}
			$communication = Communication::all();
			return $response->success($communication);
		} else {
			$communication = Communication::defaultSearch($q)->take($max_records)->get();
			return $response->success($communication);
		}
		$response->message = '$q is neither null nor not null ...WTF?!?!';
		return $response->error();
	}

	public function getSearchcommunications($q = null){

		$response = app(AjaxResponse::class);
		$results = $communication = Communication::withTrashed()->BySearch($q);
		$response->count = $results->count();
		if($response->count == 0){
			$response->count = 0;
			return $response->success();
		}
		if($response->count > 1000){
			return $response->success();
		}
		$communications = $results->get();
		return $response->success($communications);
	}

	public function getCommunicationsByParent($parentId,$parentType = '')
	{
		$response = app(AjaxResponse::class);
		$parent = Core::getParent($parentId,$parentType);
		$communications = $parent->communications;
		return $response->success($communications);
	}


	public function getcommunicationsByProperty($propertyName,$propertyValue)
	{
		$response = app(AjaxResponse::class);
		$communications =Communication::where($propertyName,$propertyValue)
			->get();
		return $response->success($communications);
	}

	public function getCommunication($id)
	{
		$response = app(AjaxResponse::class);
		$communication = Communication::findOrFail($id);
		return $response->success($communication);
	}

	public function postCommunication()
	{
		$data = $this->request->all();
		$response = app(AjaxResponse::class);
		$this->validate($this->request, Communication::$rules['create']);
		$communication = Communication::create($data);
		return $response->success($communication);
	}

	public function putCommunication($id)
	{
		$data = $this->request->all();
		$response = app(AjaxResponse::class);
		$this->validate($this->request, Communication::$rules['update']);
		$communication = Communication::findOrFail($id);
		$communication->update($data);
		return $response->success($communication);
	}

	public function deleteCommunication($communicationId)
	{
		$response = app(AjaxResponse::class);
		$communication = Communication::find($communicationId);
		if($communication->delete()){
			return $response->success($communication);
		}
		return $response->error($communication);
	}

	public function postAttachCommunicationToParent()
	{
		$data = $this->request->all();
		$parent = Core::getParent($data['parentId'],$data['parentType']);
		$communication = Communication::findOrFail($data['communicationId']);
		$parent->communications()->syncWithoutDetaching([$communication->id]);
		$response = app(AjaxResponse::class);
		$response->message = $communication->name." has been added.";
		return $response->success($communication);
	}

	public function postDetachCommunicationFromParent()
	{
		$data = $this->request->all();
		$parent = Core::getParent($data['parentId'],$data['parentType']);
		$communication = Communication::findOrFail($data['communicationId']);
		$parent->communications()->detach($communication->id);
		$parent->load('communications');
		$response = app(AjaxResponse::class);
		$response->message = $communication->name." was successfully removed.";
		return $response->success($parent);
	}

}