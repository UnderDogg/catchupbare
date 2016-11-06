<?php

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Route;
use Modules\Core\Models\Staff;
use Illuminate\Database\Seeder;

class RootSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $staffRoot = Staff::create([
            "first_name"    => "Niels",
            "last_name"     => "SuperDrost",
            "username"      => "letmein",
            "email"         => "letmein@email.com",
            "password"      => "Z6go0rBg",
            "auth_type"     => "internal",
            "enabled"       => true
        ]);
        $staffRoot->roles()->attach(1);
    }
}
