<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->default('');
            $table->string('shortname', 100)->default('');
            $table->integer('relationtype_id')->default(0);
            $table->integer('language_id')->default(0);
            $table->integer('slaplanid')->default(0);
            $table->integer('slaexpirytimeline')->default(0);
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
        Schema::drop('relations');
    }

}
