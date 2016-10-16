<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class AssignTeamStaff extends Model
{
    protected $table = 'team_assign_staff';
    protected $fillable = ['id', 'team_id', 'agent_id'];
}
