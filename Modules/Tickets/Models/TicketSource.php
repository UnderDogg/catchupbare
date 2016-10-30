<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class TicketSource extends Model
{
    public $timestamps = false;
    protected $table = 'ticketsources';
    protected $fillable = [
        'name', 'value',
    ];
}
