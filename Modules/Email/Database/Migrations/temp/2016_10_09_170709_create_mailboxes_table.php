<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMailboxesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailboxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email_address')->default('')->index('email_address');
            $table->string('email_name')->default('')->index('email_name');
            $table->boolean('is_active')->default(0);
            $table->integer('department_id')->unsigned()->nullable()->default(0)->index('department_id');
            $table->integer('priority_id')->unsigned()->nullable()->default(0)->index('priority_id');
            $table->integer('helptopic_id')->unsigned()->nullable()->default(0)->index('helptopic_id');
            $table->string('username')->default('')->index('username');
            $table->string('userpassword')->default('')->index('userpassword');
            $table->string('mailbox_type')->default('IMAP');
            $table->string('fetchtype', 30)->default('pipe');
            $table->boolean('fetching_status');
            $table->string('fetching_host')->default('imap.gmail.com');
            $table->string('fetching_port', 10)->default('993');
            $table->string('fetching_protocol');
            $table->string('fetching_encryption');
            $table->string('imap_config');
            $table->boolean('sending_status');
            $table->string('sending_host')->default('smtp.gmail.com');
            $table->string('sending_port', 10)->default('465');
            $table->string('sending_protocol');
            $table->string('sending_encryption');
            $table->string('smtp_validate');
            $table->string('smtp_authentication');
            $table->integer('tickettypeid')->default(0);
            $table->integer('priorityid')->default(0);
            $table->integer('ticketstatusid')->default(0);
            $table->boolean('auto_response')->default(0);
            $table->boolean('replyautoresponse')->default(0);
            $table->boolean('leavecopyonserver')->default(0);
            $table->timestamps();
            $table->index(['department_id', 'priority_id', 'helptopic_id'], 'department');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('emailqueues');
    }

}
