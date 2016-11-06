<?php
use Modules\Tickets\Models\TicketHelpTopic;

use Illuminate\Database\Seeder;

class HelpTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Helptopic */
        TicketHelpTopic::create(['topic' => 'Support query', 'department_id' => '2', 'ticketstatus_id' => '1', 'ticketpriority_id' => '2', 'slaplan_id' => '1', 'ticket_num_format' => '1', 'status' => '1', 'type' => '1', 'auto_response' => '0']);
        TicketHelpTopic::create(['topic' => 'Sales query', 'department_id' => '3', 'ticketstatus_id' => '1', 'ticketpriority_id' => '2', 'slaplan_id' => '1', 'ticket_num_format' => '1', 'status' => '1', 'type' => '1', 'auto_response' => '0']);
        TicketHelpTopic::create(['topic' => 'Operational query', 'department_id' => '98', 'ticketstatus_id' => '1', 'ticketpriority_id' => '2', 'slaplan_id' => '1', 'ticket_num_format' => '1', 'status' => '0', 'type' => '0', 'auto_response' => '0']);
        TicketHelpTopic::create(['topic' => 'Development item', 'department_id' => '7', 'ticketstatus_id' => '1', 'ticketpriority_id' => '2', 'slaplan_id' => '1', 'ticket_num_format' => '1', 'status' => '1', 'type' => '0', 'auto_response' => '0']);
    }
}