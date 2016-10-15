<?php namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use BaseModelTrait;

    /**
     * @var array
     */
    protected $fillable = ['staff_id', 'category', 'message', 'data', 'data_parser', 'replay_route'];

    public function user()
    {
        return $this->belongsTo('App\Staff');
    }

}
