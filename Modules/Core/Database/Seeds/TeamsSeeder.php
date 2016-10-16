<?php

namespace Modules\Core\Database\Seeds;



use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Route;
use Modules\Core\Models\Staff;
use Illuminate\Database\Seeder;

use Modules\Core\Models\Team;
class TeamsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createTeam = new Team;
        $createTeam->id = '99';
        $createTeam->name = 'Management';
        $createTeam->save();


        $createTeam = new Team;
        $createTeam->id = '98';
        $createTeam->name = 'Operations';
        $createTeam->save();

        $createTeam = new Team;
        $createTeam->id = '1';
        $createTeam->name = 'General';
        $createTeam->save();


        $createTeam = new Team;
        $createTeam->id = '2';
        $createTeam->name = 'Support';
        $createTeam->save();



        $createTeam = new Team;
        $createTeam->id = '3';
        $createTeam->name = 'Sales';
        $createTeam->save();

        $createTeam = new Team;
        $createTeam->id = '4';
        $createTeam->name = 'Implementation';
        $createTeam->save();

        $createTeam = new Team;
        $createTeam->id = '5';
        $createTeam->name = 'First line Support';
        $createTeam->save();

        $createTeam = new Team;
        $createTeam->id = '6';
        $createTeam->name = 'Second Line support';
        $createTeam->save();

        $createTeam = new Team;
        $createTeam->id = '7';
        $createTeam->name = 'Development';
        $createTeam->save();

        \DB::table('team_assign_staff')->insert([
            'team_id' => 1,
            'staff_id' => 1
        ]);

    }
}
