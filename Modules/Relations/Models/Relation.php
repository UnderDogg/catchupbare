<?php
namespace Modules\Relations\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentTaggable\Taggable;
use Carbon;

class Relation extends Model
{
    use Sluggable, Taggable;

    protected $table = 'relations';

    protected $fillable = [
        'name', 'shortname', 'relationtype_id'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'shortname' => [
                'source' => 'company_name'
            ]
        ];
    }

    public function addresses()
    {
        return $this->hasMany(RelationAddress::class, 'relation_id', 'id');
    }

    public function userAssignee()
    {
        return $this->belongsTo(Staff::class, 'fk_staff_id', 'id');
    }

    public function alltickets()
    {
        return $this->hasMany(Ticket::class, 'fk_relation_id', 'id')
            ->orderBy('status_id', 'asc')
            ->orderBy('created_at', 'desc');
    }

    public function allleads()
    {
        return $this->hasMany(Lead::class, 'fk_relation_id', 'id')
            ->orderBy('status_id', 'asc')
            ->orderBy('created_at', 'desc');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'fk_relation_id', 'id');
    }

    public function leads()
    {
        return $this->hasMany(Ticket::class, 'fk_relation_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'fk_relation_id', 'id');
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class);
    }
}
