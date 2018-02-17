<?php namespace [namespace]\Repositories;

use App\Contracts\Repositories\[repositoryInterface];
use App\Models\[Model];

class [repository] implements [repositoryInterface]
{
	private $[model];

	public function __construct([modelName] $[model])
	{
		$this->[model] = $[model];
	}

	public function all()
	{
		return $this->[model]->paginate(15);
	}

	public function find($id)
	{
		return $this->[model]->find($id);
	}

	public function store($input)
	{
		$[model] = new [Model];
		[repeat]
		$[model]->[property] = $input['[property]'];
		[/repeat]
		$[model]->save();
	}

	public function update($input)
	{
		$this->[model]->update($input);
	}

	public function destroy($id)
	{
		$this->[model]->find($id)->delete();
	}

}
