<?php namespace app\Models;

use App\Traits\BaseModelTrait;
use App\Staff;
use Tylercd100\LERN\Models\ExceptionModel;

class Error extends ExceptionModel
{
    use BaseModelTrait;

    public function user()
    {
        return $this->belongsTo(Staff::class);
    }

//    /**
//     * @return string
//     */
//    public function getTraceAttribute()
//    {
//        return $this->Label;
//    }

}
