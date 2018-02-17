<?php 

class MessagesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		factory(\App\Models\Message::class, 20)->create()->each(function($message) {
			#$message->journals()->save(factory(\App\Models::class)->make());
		});
	}

}
