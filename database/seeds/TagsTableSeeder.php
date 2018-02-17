<?php 

class TagsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		factory(\App\Models\Tag::class, 20)->create()->each(function($tag) {
			#$tag->journals()->save(factory(\App\Models::class)->make());
		});
	}

}
