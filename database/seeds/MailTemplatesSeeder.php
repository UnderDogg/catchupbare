<?php
use Modules\Email\Models\MailTemplateSet;
use Modules\Email\Models\MailTemplateType;
use Modules\Email\Models\MailTemplate;

use Illuminate\Database\Seeder;

class MailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        MailTemplateSet::create(['id' => '1', 'name' => 'default', 'isactive' => '1']);

        MailTemplateType::create(['id' => '1', 'name' => 'assign-ticket']);
        MailTemplateType::create(['id' => '2', 'name' => 'check-ticket']);
        MailTemplateType::create(['id' => '3', 'name' => 'close-ticket']);
        MailTemplateType::create(['id' => '4', 'name' => 'create-ticket']);
        MailTemplateType::create(['id' => '5', 'name' => 'create-ticket-staff']);
        MailTemplateType::create(['id' => '6', 'name' => 'create-ticket-by-staff']);
        MailTemplateType::create(['id' => '7', 'name' => 'registration-notification']);
        MailTemplateType::create(['id' => '8', 'name' => 'reset-password']);
        MailTemplateType::create(['id' => '9', 'name' => 'ticket-reply']);
        MailTemplateType::create(['id' => '10', 'name' => 'ticket-reply-staff']);
        MailTemplateType::create(['id' => '11', 'name' => 'registration']);
        MailTemplateType::create(['id' => '12', 'name' => 'team_assign_ticket']);
        MailTemplateType::create(['id' => '13', 'name' => 'reset_new_password']);


        MailTemplate::create(['id' => '1', 'variable' => '0', 'name' => 'staff-assign', 'description' => 'This template is for sending notice to staff when ticket is assigned to them', 'type_id' => '1', 'message' => '<div>Hello {!!$ticket_staff_name!!},<br/><br/><b>Ticket No:</b> {!!$ticket_number!!}<br/>Has been assigned to you by {!!$ticket_assigner!!} <br/><br/>Thank You<br/>Kind Regards,<br/> {!!$system_from!!}</div>', 'set_id' => '1']);
        MailTemplate::create(['id' => '2', 'variable' => '1', 'name' => 'client-ticket-check', 'description' => 'This template is for sending notice to client with ticket link to check ticket without logging in to system', 'type_id' => '2', 'subject' => 'Check your Ticket', 'message' => '<div>Hello {!!$user!!},<br/><br/>Click the link below to view your requested ticket<br/> {!!$ticket_link_with_number!!}<br/><br/>Kind Regards,<br/> {!!$system_from!!}</div>', 'set_id' => '1']);
        MailTemplate::create(['id' => '3', 'variable' => '0', 'name' => 'client-ticket-close', 'description' => 'This template is for sending notice to client when ticket status is changed to close', 'type_id' => '3', 'message' => '<div>Hello,<br/><br/>This message is regarding your ticket ID {!!$ticket_number!!}. We are changing the status of this ticket to "Closed" as the issue appears to be resolved.<br/><br/>Thank you<br/>Kind regards,<br/> {!!$system_from!!}</div>', 'set_id' => '1']);
        MailTemplate::create(['id' => '4', 'variable' => '0', 'name' => 'client-ticket-create', 'description' => 'This template is for sending notice to client on successful ticket creation', 'type_id' => '4', 'message' => '<div><span>Hello {!!$user!!}<br/><br/></span><span>Thank you for contacting us. This is an automated response confirming the receipt of your ticket. Our team will get back to you as soon as possible. When replying, please make sure that the ticket ID is kept in the subject so that we can track your replies.<br/><br/></span><span><b>Ticket ID:</b> {!!$ticket_number!!} <br/><br/></span><span> {!!$department_sign!!}<br/></span>You can check the status of or update this ticket online at: {!!$system_link!!}</div>', 'set_id' => '1']);
        MailTemplate::create(['id' => '5', 'variable' => '0', 'name' => 'staff-ticket-create', 'description' => 'This template is for sending notice to staff on new ticket creation', 'type_id' => '5', 'message' => '<div>Hello {!!$ticket_staff_name!!},<br/><br/>New ticket {!!$ticket_number!!}created <br/><br/><b>From</b><br/><b>Name:</b> {!!$ticket_client_name!!}   <br/><b>E-mail:</b> {!!$ticket_client_email!!}<br/><br/> {!!$content!!}<br/><br/>Kind Regards,<br/> {!!$system_from!!}</div>', 'set_id' => '1']);
        MailTemplate::create(['id' => '6', 'variable' => '0', 'name' => 'client-ticket-by-staff', 'description' => 'This template is for sending notice to client on new ticket created by staff in name of client', 'type_id' => '6', 'message' => '<div> {!!$content!!}<br><br> {!!$staff_sign!!}<br><br>You can check the status of or update this ticket online at: {!!$system_link!!}</div>', 'set_id' => '1']);
        MailTemplate::create(['id' => '7', 'variable' => '1', 'name' => 'client-new-registration', 'description' => 'This template is for sending notice to client on new registration during new ticket creation for unregistered clients', 'type_id' => '7', 'subject' => 'Registration Confirmation', 'message' => '<p>Hello {!!$user!!}, </p><p>This email is confirmation that you are now registered at our helpdesk.</p><p><b>Registered Email:</b> {!!$email_address!!}</p><p><b>Password:</b> {!!$user_password!!}</p><p>You can visit the helpdesk to browse articles and contact us at any time: {!!$system_link!!}</p><p>Thank You.</p><p>Kind Regards,</p><p> {!!$system_from!!} </p>', 'set_id' => '1']);
        MailTemplate::create(['id' => '8', 'variable' => '1', 'name' => 'client-password-reset', 'description' => 'This template is for sending notice to any user about reset password option', 'type_id' => '8', 'subject' => 'Reset your Password', 'message' => 'Hello {!!$user!!},<br/><br/>You asked to reset your password. To do so, please click this link:<br/><br/> {!!$password_reset_link!!}<br/><br/>This will let you change your password to something new.' . " If you didn't ask for this, don't worry, we'll keep your password safe.<br/><br/>Thank You.<br/><br/>Kind Regards,<br/>" . ' {!!$system_from!!}', 'set_id' => '1']);
        MailTemplate::create(['id' => '9', 'variable' => '0', 'name' => 'client-ticket-reply', 'description' => 'This template is for sending notice to client when a reply made to his/her ticket', 'type_id' => '9', 'message' => '<span></span><div><span></span><p> {!!$content!!}<br/></p><p> {!!$staff_sign!!} </p><p><b>Ticket Details</b></p><p><b>Ticket ID:</b> {!!$ticket_number!!}</p></div>', 'set_id' => '1']);
        MailTemplate::create(['id' => '10', 'variable' => '0', 'name' => 'staff-ticket-reply-by-client', 'description' => 'This template is for sending notice to staff when ticket reply is made by client on a ticket', 'type_id' => '10', 'message' => '<div>Hello {!!$ticket_staff_name!!},<br/><b><br/></b>A reply been made to ticket {!!$ticket_number!!}<br/><b><br/></b><b>From<br/></b><b>Name: </b>{!!$ticket_client_name!!}<br/><b>E-mail: </b>{!!$ticket_client_email!!}<br/><b><br/></b> {!!$content!!}<br/><b><br/></b>Kind Regards,<br/> {!!$system_from!!}</div>', 'set_id' => '1']);
        MailTemplate::create(['id' => '11', 'variable' => '1', 'name' => 'client-registration-confirmation', 'description' => 'This template is for sending notice to client about registration confirmation link', 'type_id' => '11', 'subject' => 'Verify your email address', 'message' => '<p>Hello {!!$user!!}, </p><p>This email is confirmation that you are now registered at our helpdesk.</p><p><b>Registered Email:</b> {!!$email_address!!}</p><p>Please click on the below link to activate your account and Login to the system {!!$password_reset_link!!}</p><p>Thank You.</p><p>Kind Regards,</p><p> {!!$system_from!!} </p>', 'set_id' => '1']);
        MailTemplate::create(['id' => '12', 'variable' => '1', 'name' => 'team-ticket-assigned', 'description' => 'This template is for sending notice to team when ticket is assigned to team', 'type_id' => '12', 'message' => '<div>Hello {!!$ticket_staff_name!!},<br /><br /><b>Ticket No:</b> {!!$ticket_number!!}<br />Has been assigned to your team : {!!$team!!} by {!!$ticket_assigner!!} <br /><br />Thank You<br />Kind Regards,<br />{!!$system_from!!}</div>', 'set_id' => '1']);
        MailTemplate::create(['id' => '13', 'variable' => '1', 'name' => 'client-password-changed', 'description' => 'This template is for sending notice to client when password is changed', 'type_id' => '13', 'subject' => 'Verify your email address', 'message' => 'Hello {!!$user!!},<br /><br />Your password is successfully changed.Your new password is : {!!$user_password!!}<br /><br />Thank You.<br /><br />Kind Regards,<br /> {!!$system_from!!}', 'set_id' => '1']);

    }
}