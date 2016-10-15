<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionStaffLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for associating permissions to staff (Many-to-Many)
        Schema::create('permission_staff', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('staff_id');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('staff')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'staff_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the table
        Schema::drop('permission_staff');
    }
}
