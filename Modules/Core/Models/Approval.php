<?php

namespace App\Model\helpdesk\Settings;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    /* Using Ticket table  */

    protected $table = 'approval';
    /* Set fillable fields in table */
    protected $fillable = [
        'id', 'name', 'status', 'created_at', 'updated_at',
    ];
}
