<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagsTable extends Migration 
{

	public function up()
	{
		Schema::create('tags', function(Blueprint $table) {
			$table->increments('id');
			$table->string('tag');
			$table->morphs('taggable');
			$table->nullableTimestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		DB::statement("SET foreign_key_checks=0");
		Schema::dropIfExists('tags');
	}

}
