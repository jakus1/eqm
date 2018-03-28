<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMembersTable extends Migration 
{

	public function up()
	{
		Schema::create('members', function(Blueprint $table) {
			$table->increments('id');
			$table->string('status')->default("Active");
			$table->string('first');
			$table->string('last');
			$table->string('email');
			$table->string('sms_phone');
			$table->text('description')->default("");
			$table->nullableTimestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		DB::statement("SET foreign_key_checks=0");
		Schema::dropIfExists('members');
	}

}
