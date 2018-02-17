<?php 

class CommunicationsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		factory(\App\Models\Communication::class, 20)->create()->each(function($communication) {
			#$communication->journals()->save(factory(\App\Models::class)->make());
		});
	}

}
