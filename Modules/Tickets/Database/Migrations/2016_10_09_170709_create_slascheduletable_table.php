<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlascheduletableTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('slascheduletable', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('slascheduleid')->default(0);
			$table->string('name')->default('');
			$table->string('sladay', 100)->default('');
			$table->string('opentimeline', 6)->default('00:00');
			$table->string('closetimeline', 6)->default('00:00');
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
