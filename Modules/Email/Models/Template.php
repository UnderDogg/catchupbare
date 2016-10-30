<?php

namespace Modules\Email\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'templates';
    protected $fillable = ['name', 'message', 'type', 'variable', 'subject'];
}
