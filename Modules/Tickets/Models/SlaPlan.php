<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class SlaPlan extends Model
{
    protected $table = 'slaplans';
    protected $fillable = [
        'name', 'grace_period', 'admin_note', 'status', 'transient', 'ticket_overdue',
    ];
}
