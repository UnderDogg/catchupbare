<?php
namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

  protected $fillable =
    [
      'name',
      'description'
    ];
}
