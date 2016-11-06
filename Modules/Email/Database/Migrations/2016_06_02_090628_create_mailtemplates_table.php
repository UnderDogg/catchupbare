<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailtemplates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('is_active')->default(1)->index('isactive');
            $table->integer('set_id')->unsigned()->index('mailtemplateset_id');
            $table->integer('type_id')->unsigned()->index('mailtemplatetype_id');
            $table->string('variable');
            $table->string('subject');
            $table->text('message');
            $table->string('description');
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
        Schema::drop('mailtemplates__contents');
    }
}
