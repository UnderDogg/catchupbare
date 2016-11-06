<?php

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

        //$this->call('ProductionSeeder');
        $this->call('MailTemplatesSeeder');

        // Example of how to call a seeder script for a given environment.
//        if( App::environment() === 'development' )
//        {
//            $this->call('DevelopmentSeeder');
//        }

        //Model::reguard();
    }
}
