<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlaPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slaplans', function (Blueprint $table) {
            $table->increments('id');
			      $table->boolean('isenabled')->default(0);
			      $table->integer('slascheduleid')->default(0)->index('slaschedule');
            $table->string('name');
            $table->boolean('overdue_allowed');
            $table->float('grace_period', 10, 0)->default(0);
			      $table->float('resolutionduehrs', 10, 0)->default(0);
      			$table->smallInteger('ruletype')->default(0);
      			$table->smallInteger('sortorder')->default(0);
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
        Schema::drop('slaplans');
    }
}
