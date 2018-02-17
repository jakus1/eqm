<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditCommunicationsTable extends Migration 
{

	public function up()
	{
		Schema::table('communications', function(Blueprint $table) {
			;
			;
		});
	}

	public function down()
	{
		Schema::table('communications', function(Blueprint $table) {
			$table->dropColumn('timestamps','softDeletes');
		});
	}

}
