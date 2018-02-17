<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommunicationsTable extends Migration 
{

	public function up()
	{
		Schema::create('communications', function(Blueprint $table) {
			$table->increments('id');
			$table->text('body');
			$table->nullableTimestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		DB::statement("SET foreign_key_checks=0");
		Schema::dropIfExists('communications');
	}

}
