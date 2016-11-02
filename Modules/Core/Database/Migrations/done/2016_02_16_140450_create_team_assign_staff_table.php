<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamAssignStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_assign_staff', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->unsigned()->nullable()->index('team_id');
            $table->foreign('team_id', 'fk_team_assign_team')->references('id')->on('teams')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->integer('staff_id')->unsigned()->nullable()->index('staff_id');
            $table->foreign('staff_id', 'fk_team_assign_staff')->references('id')->on('staff')->onUpdate('NO ACTION')->onDelete('RESTRICT');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::table('team_assign_agent', function (Blueprint $table) {
            $table->dropForeign('fk_team_assign_team');
            $table->dropForeign('fk_team_assign_staff');
        });
        Schema::drop('team_assign_staff');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
