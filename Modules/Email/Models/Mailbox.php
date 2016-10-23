<?php

namespace Modules\Email\Models;

use Illuminate\Database\Eloquent\Model;

class Mailbox extends Model
{
    protected $table = 'mailboxes';
    protected $fillable = [
        'email_address', 'email_name', 'department_id', 'priority_id', 'helptopic_id', 'mailbox_type',
        'username', 'password', 'fetching_status', 'fetching_host', 'fetching_port', 'fetching_protocol', 'fetching_encryption',
        'sending_status', 'sending_host', 'sending_port', 'sending_protocol', 'sending_encryption', 'delete_email',
    ];
}
