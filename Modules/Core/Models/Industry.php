<?php
namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $table = 'lookup_industry';

    public function relation()
    {
        return $this->belongsTo(Relation::class);
    }
}


