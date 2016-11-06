<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlaschedulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('slaschedules', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->default('');
			$table->boolean('sunday_open')->default(0);
			$table->boolean('monday_open')->default(0);
			$table->boolean('tuesday_open')->default(0);
			$table->boolean('wednesday_open')->default(0);
			$table->boolean('thursday_open')->default(0);
			$table->boolean('friday_open')->default(0);
			$table->boolean('saturday_open')->default(0);
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
		Schema::drop('slaschedules');
	}

}
