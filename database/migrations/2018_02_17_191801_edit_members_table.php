<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditMembersTable extends Migration 
{

	public function up()
	{
		Schema::table('members', function(Blueprint $table) {
			;
			;
		});
	}

	public function down()
	{
		Schema::table('members', function(Blueprint $table) {
			$table->dropColumn('timestamps','softDeletes');
		});
	}

}
