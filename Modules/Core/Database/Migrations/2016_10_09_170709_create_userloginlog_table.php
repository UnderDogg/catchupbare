<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserloginlogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('userloginlog', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('userid')->unsigned()->default(0);
			$table->timestamp('logindateline')->default(0);
			$table->timestamp('activitydateline')->default(0);
			$table->timestamp('logoutdateline')->default(0);
			$table->string('userfullname')->default('');
			$table->string('useremail')->default('');
			$table->string('ipaddress', 50)->default('0.0.0.0');
			$table->string('forwardedipaddress', 50)->default('0.0.0.0');
			$table->string('useragent')->default('');
			$table->string('sessionid')->default('')->index('userloginlog4');
			$table->smallInteger('logouttype')->default(0);
			$table->smallInteger('loginresult')->default(0);
			$table->smallInteger('interfacetype')->default(0);
			$table->index(['userid','logindateline','interfacetype'], 'userloginlog1');
			$table->index(['userfullname','logindateline','loginresult'], 'userloginlog2');
			$table->index(['logindateline','loginresult'], 'userloginlog3');
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
		Schema::drop('userloginlog');
	}

}
