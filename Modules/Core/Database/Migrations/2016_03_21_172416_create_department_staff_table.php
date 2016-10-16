<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_assign_staff', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id', 'depstaff_dept')->references('id')->on('departments')->onDelete('cascade');
            $table->integer('staff_id')->unsigned();
            $table->foreign('staff_id', 'depstaff_staff')->references('id')->on('staff')->onDelete('cascade');
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
        Schema::table('department', function (Blueprint $table) {
            $table->dropForeign('depstaff_dept');
            $table->dropForeign('depstaff_staff');
        });
        Schema::drop('department_assign_staff');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
