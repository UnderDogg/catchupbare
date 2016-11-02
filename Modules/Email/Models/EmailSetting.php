<?php

namespace Modules\Email\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    /* Using Email table  */

    protected $table = 'settings_email';
    /* Set fillable fields in table */
    protected $fillable = [
        'id', 'template', 'sys_email', 'alert_email', 'admin_email', 'mta', 'email_fetching', 'strip',
        'separator', 'all_emails', 'email_collaborator', 'attachment',
    ];
}
