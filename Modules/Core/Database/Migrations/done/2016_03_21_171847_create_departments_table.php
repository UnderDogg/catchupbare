<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('departmenttype', 50)->default('public')->index('departments2');;
            $table->boolean('isdefault')->default(0);
            $table->integer('slaplan_id')->unsigned()->nullable()->index('slaplan');
            $table->integer('manager_id')->unsigned()->nullable()->index('deptmngr');
            $table->string('department_signature');
            $table->timestamps();

            //$table->foreign('slaplan_id', 'fk_department_slaplan')->references('id')->on('sla_plans')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('manager_id', 'fk_department_manager')->references('id')->on('staff')->onUpdate('NO ACTION')->onDelete('RESTRICT');

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
        Schema::table('departments', function (Blueprint $table) {
            //$table->dropForeign('fk_department_slaplan');
            $table->dropForeign('fk_department_manager');
        });
        Schema::drop('departments');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
