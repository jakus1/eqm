<?php namespace App\Traits\ApiCtrl;

use Illuminate\Http\Request;
use App\Http\Responses\AjaxResponse;

use Core;
use Log;

use App\Models\Member;

trait MemberTrait
{
	public function getAllmembers($q = null, $max_records = 750)
	{
		$response = app(AjaxResponse::class);
		if (is_null($q)) {
			$response->count = Member::count();
			if ($response->count == 0) {
				$response->count = 0;
				return $response->success();
			}
			if ($response->count > $max_records) {
				$member = Member::MostRecent()->take($max_records)->get();
				$response->count = $member->count();
				return $response->success($member);
			}
			$member = Member::all();
			return $response->success($member);
		} else {
			$member = Member::defaultSearch($q)->take($max_records)->get();
			return $response->success($member);
		}
		$response->message = '$q is neither null nor not null ...WTF?!?!';
		return $response->error();
	}

	public function getSearchmembers($q = null){

		$response = app(AjaxResponse::class);
		$results = $member = Member::withTrashed()->BySearch($q);
		$response->count = $results->count();
		if($response->count == 0){
			$response->count = 0;
			return $response->success();
		}
		if($response->count > 1000){
			return $response->success();
		}
		$members = $results->get();
		return $response->success($members);
	}

	public function getMembersByParent($parentId,$parentType = '')
	{
		$response = app(AjaxResponse::class);
		$parent = Core::getParent($parentId,$parentType);
		$members = $parent->members;
		return $response->success($members);
	}


	public function getmembersByProperty($propertyName,$propertyValue)
	{
		$response = app(AjaxResponse::class);
		$members =Member::where($propertyName,$propertyValue)
			->get();
		return $response->success($members);
	}

	public function getMember($id)
	{
		$response = app(AjaxResponse::class);
		$member = Member::findOrFail($id);
		return $response->success($member);
	}

	public function postMember()
	{
		$data = $this->request->all();
		$response = app(AjaxResponse::class);
		$this->validate($this->request, Member::$rules['create']);
		$member = Member::create($data);
		return $response->success($member);
	}

	public function putMember($id)
	{
		$data = $this->request->all();
		$response = app(AjaxResponse::class);
		$this->validate($this->request, Member::$rules['update']);
		$member = Member::findOrFail($id);
		$member->update($data);
		return $response->success($member);
	}

	public function deleteMember($memberId)
	{
		$response = app(AjaxResponse::class);
		$member = Member::find($memberId);
		if($member->delete()){
			return $response->success($member);
		}
		return $response->error($member);
	}

	public function postAttachMemberToParent()
	{
		$data = $this->request->all();
		$parent = Core::getParent($data['parentId'],$data['parentType']);
		$member = Member::findOrFail($data['memberId']);
		$parent->members()->syncWithoutDetaching([$member->id]);
		$response = app(AjaxResponse::class);
		$response->message = $member->name." has been added.";
		return $response->success($member);
	}

	public function postDetachMemberFromParent()
	{
		$data = $this->request->all();
		$parent = Core::getParent($data['parentId'],$data['parentType']);
		$member = Member::findOrFail($data['memberId']);
		$parent->members()->detach($member->id);
		$parent->load('members');
		$response = app(AjaxResponse::class);
		$response->message = $member->name." was successfully removed.";
		return $response->success($parent);
	}

}