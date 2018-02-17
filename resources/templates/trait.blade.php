##php namespace {{ $namespace or ''}}\Traits\ApiCtrl;

use Illuminate\Http\Request;
use App\Http\Responses\AjaxResponse;

use Core;
use Log;

use {{ $namespace or ''}}\Models\{{ $Model or '' }};

trait {{ $Model or '' }}Trait
{
	public function getAll{{ $models or ''}}($q = null, $max_records = 750)
	{
		$response = app(AjaxResponse::class);
		if (is_null($q)) {
			$response->count = {{ $Model or '' }}::count();
			if ($response->count == 0) {
				$response->count = 0;
				return $response->success();
			}
			if ($response->count > $max_records) {
				${{ $model or ''}} = {{ $Model or '' }}::MostRecent()->take($max_records)->get();
				$response->count = ${{ $model or ''}}->count();
				return $response->success(${{ $model or ''}});
			}
			${{ $model or ''}} = {{ $Model or '' }}::all();
			return $response->success(${{ $model or ''}});
		} else {
			${{ $model or ''}} = {{ $Model or '' }}::defaultSearch($q)->take($max_records)->get();
			return $response->success(${{ $model or ''}});
		}
		$response->message = '$q is neither null nor not null ...WTF?!?!';
		return $response->error();
	}

	public function getSearch{{ $models or ''}}($q = null){

		$response = app(AjaxResponse::class);
		$results = ${{ $model or ''}} = {{ $Model or '' }}::withTrashed()->BySearch($q);
		$response->count = $results->count();
		if($response->count == 0){
			$response->count = 0;
			return $response->success();
		}
		if($response->count > 1000){
			return $response->success();
		}
		${{ $models or '' }} = $results->get();
		return $response->success(${{ $models or '' }});
	}

	public function get{{ $Models or '' }}ByParent($parentId,$parentType = '')
	{
		$response = app(AjaxResponse::class);
		$parent = Core::getParent($parentId,$parentType);
		${{ $models or '' }} = $parent->{{ $models or '' }};
		return $response->success(${{ $models or '' }});
	}


	public function get{{ $models or ''}}ByProperty($propertyName,$propertyValue)
	{
		$response = app(AjaxResponse::class);
		${{ $models or '' }} ={{ $Model or '' }}::where($propertyName,$propertyValue)
			->get();
		return $response->success(${{ $models or '' }});
	}

	public function get{{ $Model or '' }}($id)
	{
		$response = app(AjaxResponse::class);
		${{ $model or ''}} = {{ $Model or '' }}::findOrFail($id);
		return $response->success(${{ $model or ''}});
	}

	public function post{{ $Model or '' }}()
	{
		$data = $this->request->all();
		$response = app(AjaxResponse::class);
		$this->validate($this->request, {{ $Model or '' }}::$rules['create']);
		${{ $model or ''}} = {{ $Model or '' }}::create($data);
		return $response->success(${{ $model or ''}});
	}

	public function put{{ $Model or '' }}($id)
	{
		$data = $this->request->all();
		$response = app(AjaxResponse::class);
		$this->validate($this->request, {{ $Model or '' }}::$rules['update']);
		${{ $model or ''}} = {{ $Model or '' }}::findOrFail($id);
		${{ $model or ''}}->update($data);
		return $response->success(${{ $model or ''}});
	}

	public function delete{{ $Model or '' }}(${{ $model or ''}}Id)
	{
		$response = app(AjaxResponse::class);
		${{ $model or ''}} = {{ $Model or '' }}::find(${{ $model or ''}}Id);
		if(${{ $model or ''}}->delete()){
			return $response->success(${{ $model or ''}});
		}
		return $response->error(${{ $model or ''}});
	}

	public function postAttach{{ $Model or '' }}ToParent()
	{
		$data = $this->request->all();
		$parent = Core::getParent($data['parentId'],$data['parentType']);
		${{ $model or ''}} = {{ $Model or '' }}::findOrFail($data['{{ $model or ''}}Id']);
		$parent->{{ $models or '' }}()->syncWithoutDetaching([${{ $model or ''}}->id]);
		$response = app(AjaxResponse::class);
		$response->message = ${{ $model or ''}}->name." has been added.";
		return $response->success(${{ $model or ''}});
	}

	public function postDetach{{ $Model or '' }}FromParent()
	{
		$data = $this->request->all();
		$parent = Core::getParent($data['parentId'],$data['parentType']);
		${{ $model or ''}} = {{ $Model or '' }}::findOrFail($data['{{ $model or ''}}Id']);
		$parent->{{ $models or '' }}()->detach(${{ $model or ''}}->id);
		$parent->load('{{ $models or '' }}');
		$response = app(AjaxResponse::class);
		$response->message = ${{ $model or ''}}->name." was successfully removed.";
		return $response->success($parent);
	}

}