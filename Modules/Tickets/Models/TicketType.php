<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $table = 'tickettypes';
    protected $fillable = [
        'id', 'ispublic', 'name', 'displayicon', 'departmentid', 'ismaster', 'displayorder'
    ];
}
