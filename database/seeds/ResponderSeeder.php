<?php
use Modules\Email\Models\AutoResponder;
use Illuminate\Database\Seeder;

class ResponderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AutoResponder::create(['id' => '1', 'new_ticket' => '1', 'agent_new_ticket' => '1']);
    }
}