<?php
namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

    protected $table = 'ticketsettings';

    protected $fillable = [
        'ticket_complete_allowed',
        'ticket_assign_allowed',
        'lead_complete_allowed',
        'lead_assign_allowed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tickets()
    {
        return $this->belongsTo(Ticket::class);
    }
}
