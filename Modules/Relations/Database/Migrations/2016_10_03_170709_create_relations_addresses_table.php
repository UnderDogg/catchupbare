<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelationsAddressesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations__adresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('relation_id')->default(0);
            $table->boolean('ismain')->default(0);
            $table->integer('addresstype_id')->default(0);
            $table->string('address', 100)->default('');
            $table->string('address2', 100)->default('');
            $table->string('housenumber', 25)->default('');
            $table->string('housenumberaddition', 10)->default('');
            $table->string('postalcode', 100)->default('');
            $table->integer('city_id')->default(0);
            $table->integer('country_id')->default(31);
            $table->string('phone', 25)->default('');
            $table->string('fax', 200)->default('');
            $table->string('website')->default('');
            $table->integer('dateline')->default(0);
            $table->integer('lastupdate')->default(0);
            $table->integer('languageid')->default(0);
            $table->integer('slaplanid')->default(0);
            $table->integer('slaexpirytimeline')->default(0);
            $table->integer('usergroupid')->default(0);
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
        Schema::drop('relations__adresses');
    }

}
