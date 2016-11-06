<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlarulecriteriaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('slarulecriteria', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('slaplanid')->default(0)->index('slarulecriteria1');
			$table->string('name', 100)->default('');
			$table->smallInteger('ruleop')->default(0);
			$table->string('rulematch')->default('');
			$table->smallInteger('rulematchtype')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('slarulecriteria');
	}

}
