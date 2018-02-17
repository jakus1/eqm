<?php namespace [namespace]\Contracts\Repositories;

interface [repositoryInterface]
{
	public function all();
	public function find($id);
	public function store($input);
	public function update($input);
	public function destroy($id);
}