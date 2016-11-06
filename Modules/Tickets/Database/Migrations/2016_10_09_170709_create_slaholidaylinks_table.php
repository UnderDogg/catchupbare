<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlaholidaylinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('slaholidaylinks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('slaplanid')->default(0);
			$table->integer('slaholidayid')->default(0)->index('slaholidaylinks2');
			$table->index(['slaplanid','slaholidayid'], 'slaholidaylinks1');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('slaholidaylinks');
	}

}
