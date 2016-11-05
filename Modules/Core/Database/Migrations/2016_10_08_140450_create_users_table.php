<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_role')->unsigned()->nullable()->index('fk_users_roles');
			       $table->integer('relation_id')->default(0)->index('fk_users_relations');
            $table->string('user_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('isactive')->default(1);
            $table->boolean('isbanned')->default(0);
			      $table->boolean('isvalidated')->default(0);
      			$table->smallInteger('salutation')->default(0);
      			$table->string('userdesignation')->default('');
            $table->smallInteger('gender');
            $table->string('emailaddress')->nullable()->unique();
            $table->string('password', 60);
            $table->string('phonenumber')->nullable()->unique();
            $table->string('mobilenumber')->nullable()->unique();

      			$table->integer('language_id')->default(31);
      			$table->string('timezonephp', 100)->default('');
      			$table->boolean('enabledst')->default(0);

            $table->string('internal_note');
            $table->string('profile_pic');
            $table->string('remember_token', 100)->nullable();
      			$table->timestamp('lastvisit')->nullable()->default(0);
      			$table->timestamp('lastvisit2')->nullable()->default(0);
      			$table->timestamp('lastactivity')->nullable()->default(0);
      			$table->string('lastvisitip')->default('');
      			$table->string('lastvisitip2')->default('');
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
        Schema::drop('users');
    }
}
