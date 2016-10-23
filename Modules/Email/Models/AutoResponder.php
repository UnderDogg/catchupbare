<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class AutoResponder extends Model
{
    /* Using auto_response table  */

    protected $table = 'settings_auto_response';
    /* Set fillable fields in table */
    protected $fillable = [

        'id', 'new_ticket', 'agent_new_ticket', 'submitter', 'participants', 'overlimit',
    ];
}
