##php namespace {{ $namespace or '' }}\Contracts\Repositories;

interface [baseRepositoryInterface]
{
	public function all();
	public function find($id);
	public function store($input);
	public function update($input);
	public function destroy($id);
}