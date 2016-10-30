<?php
namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    protected $table = 'ticketstatuses';
    protected $fillable = [
        'id', 'name', 'state', 'mode', 'message', 'hasflags', 'statusorder', 'email_user', 'icon_class', 'properties',
    ];
}
