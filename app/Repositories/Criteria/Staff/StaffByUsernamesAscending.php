<?php namespace App\Repositories\Criteria\Staff;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class StaffByUsernamesAscending extends Criteria {


    /**
     * @param $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function apply( $model, Repository $repository )
    {
        $model = $model->orderBy('username', 'ASC');
        return $model;
    }

}
