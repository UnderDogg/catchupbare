<?php

namespace Modules\Email\Models;

use Illuminate\Database\Eloquent\Model;

class CannedResponse extends Model
{
    /* define the table name */

    protected $table = 'cannedresponses';

    /* Define the fillable fields */
    protected $fillable = ['user_id', 'title', 'message', 'created_at', 'updated_at'];
}
