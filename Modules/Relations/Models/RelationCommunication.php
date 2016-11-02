<?php
namespace Modules\Relations\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentTaggable\Taggable;
use Carbon;

class RelationCommunication extends Model
{
    protected $table = 'relations__communication';

    protected $fillable = [
        'ismain', 'communicationtype_id', 'phonenumber', 'mobilenumber', 'faxnumber', 'website'
    ];

}
