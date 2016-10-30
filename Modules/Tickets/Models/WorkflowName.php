<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowName extends Model
{
    public $timestamps = false;
    protected $table = 'workflow_name';
    protected $fillable = ['id', 'name', 'status', 'order', 'target', 'internal_note', 'updated_at', 'created_at'];
}
