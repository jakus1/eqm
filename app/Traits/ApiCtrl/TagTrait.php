<?php namespace App\Traits\ApiCtrl;

use Illuminate\Http\Request;
use App\Http\Responses\AjaxResponse;

use Core;
use Log;

use App\Models\Tag;

trait TagTrait
{
	public function getAlltags($q = null, $max_records = 750)
	{
		$response = app(AjaxResponse::class);
		if (is_null($q)) {
			$response->count = Tag::count();
			if ($response->count == 0) {
				$response->count = 0;
				return $response->success();
			}
			if ($response->count > $max_records) {
				$tag = Tag::MostRecent()->take($max_records)->get();
				$response->count = $tag->count();
				return $response->success($tag);
			}
			$tag = Tag::all();
			return $response->success($tag);
		} else {
			$tag = Tag::defaultSearch($q)->take($max_records)->get();
			return $response->success($tag);
		}
		$response->message = '$q is neither null nor not null ...WTF?!?!';
		return $response->error();
	}

	public function getSearchtags($q = null){

		$response = app(AjaxResponse::class);
		$results = $tag = Tag::withTrashed()->BySearch($q);
		$response->count = $results->count();
		if($response->count == 0){
			$response->count = 0;
			return $response->success();
		}
		if($response->count > 1000){
			return $response->success();
		}
		$tags = $results->get();
		return $response->success($tags);
	}

	public function getTagsByParent($parentId,$parentType = '')
	{
		$response = app(AjaxResponse::class);
		$parent = Core::getParent($parentId,$parentType);
		$tags = $parent->tags;
		return $response->success($tags);
	}


	public function gettagsByProperty($propertyName,$propertyValue)
	{
		$response = app(AjaxResponse::class);
		$tags =Tag::where($propertyName,$propertyValue)
			->get();
		return $response->success($tags);
	}

	public function getTag($id)
	{
		$response = app(AjaxResponse::class);
		$tag = Tag::findOrFail($id);
		return $response->success($tag);
	}

	public function postTag()
	{
		$data = $this->request->all();
		$response = app(AjaxResponse::class);
		$this->validate($this->request, Tag::$rules['create']);
		$tag = Tag::create($data);
		return $response->success($tag);
	}

	public function putTag($id)
	{
		$data = $this->request->all();
		$response = app(AjaxResponse::class);
		$this->validate($this->request, Tag::$rules['update']);
		$tag = Tag::findOrFail($id);
		$tag->update($data);
		return $response->success($tag);
	}

	public function deleteTag($tagId)
	{
		$response = app(AjaxResponse::class);
		$tag = Tag::find($tagId);
		if($tag->delete()){
			return $response->success($tag);
		}
		return $response->error($tag);
	}

	public function postAttachTagToParent()
	{
		$data = $this->request->all();
		$parent = Core::getParent($data['parentId'],$data['parentType']);
		$tag = Tag::findOrFail($data['tagId']);
		$parent->tags()->syncWithoutDetaching([$tag->id]);
		$response = app(AjaxResponse::class);
		$response->message = $tag->name." has been added.";
		return $response->success($tag);
	}

	public function postDetachTagFromParent()
	{
		$data = $this->request->all();
		$parent = Core::getParent($data['parentId'],$data['parentType']);
		$tag = Tag::findOrFail($data['tagId']);
		$parent->tags()->detach($tag->id);
		$parent->load('tags');
		$response = app(AjaxResponse::class);
		$response->message = $tag->name." was successfully removed.";
		return $response->success($parent);
	}

}