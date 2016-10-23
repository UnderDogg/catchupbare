<?php

namespace Modules\Email\Models;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    protected $table = 'mailtemplates';
    protected $fillable = [
        'id', 'name', 'status', 'template_set_to_clone', 'language', 'internal_note',
    ];
}
