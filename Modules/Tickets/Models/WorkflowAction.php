<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowAction extends Model
{
    public $timestamps = false;
    protected $table = 'workflow_action';
    protected $fillable = ['id', 'workflow_id', 'condition', 'action', 'updated_at', 'created_at'];
}
