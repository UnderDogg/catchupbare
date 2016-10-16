<?php

namespace Modules\Core\Database\Seeds;


use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();

        //$this->call('DepartmentsSeeder');
        $this->call('TeamsSeeder');
        //$this->call('ProductionSeeder');

        // Example of how to call a seeder script for a given environment.
//        if( App::environment() === 'development' )
//        {
//            $this->call('DevelopmentSeeder');
//        }

        //Model::reguard();
    }
}
