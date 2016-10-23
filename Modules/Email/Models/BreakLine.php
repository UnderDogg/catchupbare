<?php

namespace Modules\Email\Models;

use Illuminate\Database\Eloquent\Model;

class BreakLine extends Model
{
    /* define the table name */

    protected $table = 'breaklines';

    /* Define the fillable fields */
    protected $fillable = ['id', 'breakline', 'isregexp', 'sortorder'];
}
