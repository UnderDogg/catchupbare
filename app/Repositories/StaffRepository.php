<?php namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class StaffRepository extends Repository
{
    public function model()
    {
        return 'Modules\Core\Models\Staff';
    }

}
