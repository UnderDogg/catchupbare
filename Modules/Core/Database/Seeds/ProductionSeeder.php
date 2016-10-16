<?php

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Route;
use Modules\Core\Models\Staff;
use Illuminate\Database\Seeder;

use Modules\Core\Models\Department;
class ProductionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createDep = new Department;
        $createDep->id = '99';
        $createDep->name = 'Management';
        $createDep->save();


        $createDep = new Department;
        $createDep->id = '98';
        $createDep->name = 'Operations';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '1';
        $createDep->name = 'General';
        $createDep->save();


        $createDep = new Department;
        $createDep->id = '2';
        $createDep->name = 'Support';
        $createDep->save();



        $createDep = new Department;
        $createDep->id = '3';
        $createDep->name = 'Sales';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '4';
        $createDep->name = 'Implementation';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '5';
        $createDep->name = 'First line Support';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '6';
        $createDep->name = 'Second Line support';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '7';
        $createDep->name = 'Development';
        $createDep->save();



    }
}
