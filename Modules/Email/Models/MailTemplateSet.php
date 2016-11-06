<?php
namespace Modules\Email\Models;

use Illuminate\Database\Eloquent\Model;

class MailTemplateSet extends Model
{
    protected $table = 'mailtemplates__sets';
    protected $fillable = ['name', 'isactive'];

}
