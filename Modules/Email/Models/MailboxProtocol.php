<?php

namespace Modules\Email\Models;

use Illuminate\Database\Eloquent\Model;

class MailboxProtocol extends Model
{
    protected $table = 'mailboxprotocols';
    public $timestamps = false;
    protected $fillable = ['id', 'name', 'value'];
}
