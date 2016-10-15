<?php namespace App\Repositories\Criteria\Staff;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class StaffWhereEmailEquals extends Criteria {

    private $str;


    public function __construct($str)
    {
        $this->str = $str;
    }

    /**
     * @param $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function apply( $model, Repository $repository )
    {
        $model = $model->where('email', '=', $this->str);
        return $model;
    }

}
