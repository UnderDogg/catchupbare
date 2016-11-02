<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelationsMailAddressesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations__mailadresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('relation_id')->default(0);
            $table->boolean('isprimary')->default(0);
            $table->smallInteger('linktype')->default(0);
            $table->integer('linktype_id')->default(0);
            $table->string('emailaddress')->default('');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('relations__mailadresses');
    }

}
