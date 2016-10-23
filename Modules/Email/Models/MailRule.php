<?php

namespace Modules\Email\Models;

use Illuminate\Database\Eloquent\Model;

class MailRule extends Model
{
    /* define the table name */

    protected $table = 'mailrules';

    /* Define the fillable fields */
    protected $fillable = ['id', 'mailrule', 'isregexp', 'sortorder'];
}
