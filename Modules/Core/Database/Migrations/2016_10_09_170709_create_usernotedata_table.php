<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsernotedataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usernotedata', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('usernoteid')->default(0)->index('usernotedata1');
			$table->text('notecontents')->nullable();
      $table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usernotedata');
	}

}
