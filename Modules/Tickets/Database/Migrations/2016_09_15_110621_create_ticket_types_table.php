<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickettypes', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('ismaster');
            $table->boolean('ispublic')->default(1);
            $table->string('title', 100);
            $table->string('displayicon');
            $table->integer('department_id')->unsigned();
            $table->integer('displayorder');
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
        Schema::dropIfExists('tickettypes');
    }
}
