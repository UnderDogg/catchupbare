<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelationsContractsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations__contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contractname', 100)->default('');
            $table->integer('contracttype_id')->default(0);
            $table->integer('relation_id')->default(0);
            $table->integer('relationcontact_id')->default(0);
            $table->integer('slaplan_id')->default(0);
            $table->timestamp('contract_start_date');
            $table->timestamp('contract_end_date');
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
        Schema::drop('relations__contracts');
    }

}
