<?php

namespace Modules\Email\Models;

use Illuminate\Database\Eloquent\Model;

class Banlist extends Model
{
    protected $table = 'banlist';
    protected $fillable = [
        'id', 'ban_status', 'email_address', 'internal_notes',
    ];
}
