<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelationsCommunicationTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations__communication', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('relation_id')->default(0);
            $table->boolean('ismain')->default(0);
            $table->integer('communicationtype_id')->default(0);
            $table->string('phonenumber', 25)->default('');
            $table->string('mobilenumber', 25)->default('');
            $table->string('faxnumber', 25)->default('');
            $table->string('website')->default('');
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
        Schema::drop('relations__communication');
    }

}
