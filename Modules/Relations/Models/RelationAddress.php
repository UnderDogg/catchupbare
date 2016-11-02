<?php
namespace Modules\Relations\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentTaggable\Taggable;
use Carbon;

class RelationAddress extends Model
{
    use Sluggable, Taggable;

    protected $table = 'relations__addresses';

    protected $fillable = [
        'ismain', 'addresstype_id', 'address', 'address2', 'housenumber', 'housenumberaddition', 'postalcode', 'city_id', 'country_id'
    ];

}
