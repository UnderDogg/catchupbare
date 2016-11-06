<?php

namespace Modules\Email\Models;

use Illuminate\Database\Eloquent\Model;

class MailTemplateType extends Model
{
    protected $table = 'mailtemplates__types';
    protected $fillable = ['name'];
}
