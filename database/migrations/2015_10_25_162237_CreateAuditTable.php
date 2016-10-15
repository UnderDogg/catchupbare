<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category');
            $table->string('message');
            $table->unsignedInteger('staff_id')->nullable()->default(null);
            $table->string('data')->nullable()->default(null);
            $table->string('replay_route')->nullable()->default(null);
            $table->string('data_parser')->nullable()->default(null);
            $table->timestamps();

//            $table->foreign('staff_id')->references('id')->on('staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('audits');
    }
}
