<?php namespace App\Traits\Models;

use App\Models\Tag;

trait TagTrait
{
	public function tags() {
		return $this->morphmany(Tag::class,'taggable');
	}
}