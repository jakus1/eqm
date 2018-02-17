<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditMessagesTable extends Migration 
{

	public function up()
	{
		Schema::table('messages', function(Blueprint $table) {
			;
			;
		});
	}

	public function down()
	{
		Schema::table('messages', function(Blueprint $table) {
			$table->dropColumn('timestamps','softDeletes');
		});
	}

}
