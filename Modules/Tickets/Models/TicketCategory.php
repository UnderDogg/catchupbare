<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    protected $table = 'ticketcategories';
    protected $fillable = [
        'name'
    ];
}
