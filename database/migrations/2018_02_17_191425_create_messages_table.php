<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration 
{

	public function up()
	{
		Schema::create('messages', function(Blueprint $table) {
			$table->increments('id');
			$table->text('body');
			$table->nullableTimestamps();
			$table->softDeletes();
			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('communication_id')->unsigned()->nullable();
			$table->foreign('communication_id')->references('id')->on('communications');
		});
	}

	public function down()
	{
		DB::statement("SET foreign_key_checks=0");
		Schema::dropIfExists('messages');
	}

}
