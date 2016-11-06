<?php
namespace Modules\Email\Models;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    protected $table = 'mailtemplates';
    protected $fillable = ['name', 'is_active', 'type_id', 'set_id', 'message', 'variable', 'subject'];
}
