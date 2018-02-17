<?php 

class MembersTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		factory(\App\Models\Member::class, 20)->create()->each(function($member) {
			#$member->journals()->save(factory(\App\Models::class)->make());
		});
	}

}
