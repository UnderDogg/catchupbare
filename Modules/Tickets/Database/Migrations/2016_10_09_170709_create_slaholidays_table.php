<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlaholidaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('slaholidays', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title')->default('');
			$table->smallInteger('holidayday')->default(0);
			$table->smallInteger('holidaymonth')->default(0);
			$table->string('holidaydate', 200)->default('');
			$table->string('flagicon')->default('');
			$table->boolean('iscustom')->default(0);
			$table->index(['holidayday','holidaymonth'], 'slaholidays1');
			$table->index(['holidaydate','iscustom'], 'slaholidays2');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('slaholidays');
	}

}
