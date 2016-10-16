<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = 'groups';
    protected $fillable = [
        'name', 'group_status', 'can_create_ticket', 'can_edit_ticket',
        'can_post_ticket', 'can_close_ticket', 'can_assign_ticket',
        'can_delete_ticket', 'can_ban_email',
        'can_manage_canned', 'can_manage_faq', 'can_view_agent_stats',
        'department_access', 'admin_notes',
    ];
}
