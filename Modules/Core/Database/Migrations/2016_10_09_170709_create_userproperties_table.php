<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserpropertiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('userproperties', function(Blueprint $table)
		{
			$table->increments('id', true);
			$table->integer('userid')->default(0);
			$table->string('keyname')->default('');
			$table->string('keyvalue')->default('');
			$table->index(['userid','keyname'], 'userproperties1');
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
		Schema::drop('userproperties');
	}

}
