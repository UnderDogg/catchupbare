<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usersettings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->default('');
			$table->string('value')->default('');
			$table->integer('userid')->default(0)->index('usersettings1');
			$table->unique(['userid','name'], 'usersettings2');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usersettings');
	}

}
