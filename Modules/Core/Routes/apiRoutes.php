<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//auth:api
//authorize


// Routes in this group must be authorized.
Route::group([], function() {
    // Site administration section
    Route::group(['prefix' => 'api'], function () {
        Route::get(   'staffdata',                  ['as' => 'api.staff.data',           'uses' => 'StaffController@anyData']);
        Route::get(   'rolesdata',                  ['as' => 'api.roles.data',           'uses' => 'RolesController@anyData']);
        Route::get(   'departmentsdata',            ['as' => 'api.departments.data',     'uses' => 'DepartmentsController@anyData']);
        Route::get(   'teamsdata',                  ['as' => 'api.teams.data',           'uses' => 'TeamsController@anyData']);
    /*
      |=============================================================
      |  Cron Job links
      |=============================================================
      |	These links are for cron job execution
      |
     */
    Route::get('readmails', ['as' => 'readmails', 'uses' => 'Agent\helpdesk\MailController@readmails']);
    Route::get('notification', ['as' => 'notification', 'uses' => 'Agent\helpdesk\NotificationController@send_notification']);
    Route::get('auto-close-tickets', ['as' => 'auto.close', 'uses' => 'Client\helpdesk\UnAuthController@autoCloseTickets']);
    /*
      |=============================================================
      |  Test mail Routes
      |=============================================================
     */
//    Route::get('testmail', function () {
//        $e = 'hello';
//        Config::set('mail.host', 'smtp.gmail.com');
//        \Mail::send('errors.report', ['e' => $e], function ($message) {
//            $message->to('sujitprasad4567@gmail.com', 'sujit prasad')->subject('Error');
//        });
//    });


    }); // End of ADMIN group





//    Route::get('/report', 'HomeController@getreport');
//    Route::get('/reportdata', 'HomeController@pushdata');
    /*
     * ================================================================================================
     * @version v1
     * @access public
     * @copyright (c) 2016, Ladybird web solution
     * @author Vijay Sebastian<vijay.sebastian@ladybirdweb.com>
     * @name Faveo
     */
    Route::group(['prefix' => 'api/v1'], function () {
        Route::post('register', 'Api\v1\ApiController@register');
        Route::post('authenticate', 'Api\v1\TokenAuthController@authenticate');
        Route::get('authenticate/user', 'Api\v1\TokenAuthController@getAuthenticatedUser');
        Route::get('/database-config', ['as' => 'database-config', 'uses' => 'Api\v1\InstallerApiController@config_database']);
        Route::get('/system-config', ['as' => 'database-config', 'uses' => 'Api\v1\InstallerApiController@config_system']);
        /*
         * Helpdesk
         */
        Route::group(['prefix' => 'helpdesk'], function () {
            Route::post('create', 'Api\v1\ApiController@createTicket');
            Route::post('reply', 'Api\v1\ApiController@ticketReply');
            Route::post('edit', 'Api\v1\ApiController@editTicket');
            Route::post('delete', 'Api\v1\ApiController@deleteTicket');
            Route::post('assign', 'Api\v1\ApiController@assignTicket');
            Route::get('open', 'Api\v1\ApiController@openedTickets');
            Route::get('unassigned', 'Api\v1\ApiController@unassignedTickets');
            Route::get('closed', 'Api\v1\ApiController@closeTickets');
            Route::get('agents', 'Api\v1\ApiController@getAgents');
            Route::get('teams', 'Api\v1\ApiController@getTeams');
            Route::get('customers', 'Api\v1\ApiController@getCustomers');
            Route::get('customer', 'Api\v1\ApiController@getCustomer');
            Route::get('ticket-search', 'Api\v1\ApiController@searchTicket');
            Route::get('ticket-thread', 'Api\v1\ApiController@ticketThreads');
            Route::get('url', 'Api\v1\ApiExceptAuthController@checkUrl');
            Route::get('check-url', 'Api\v1\ApiExceptAuthController@urlResult');
            Route::get('api_key', 'Api\v1\ApiController@generateApiKey');
            Route::get('help-topic', 'Api\v1\ApiController@getHelpTopic');
            Route::get('sla-plan', 'Api\v1\ApiController@getSlaPlan');
            Route::get('priority', 'Api\v1\ApiController@getPriority');
            Route::get('department', 'Api\v1\ApiController@getDepartment');
            Route::get('tickets', 'Api\v1\ApiController@getTickets');
            Route::get('ticket', 'Api\v1\ApiController@getTicketById');
            Route::get('inbox', 'Api\v1\ApiController@inbox');
            Route::get('trash', 'Api\v1\ApiController@getTrash');
            Route::get('my-tickets-agent', 'Api\v1\ApiController@getMyTicketsAgent');
            Route::post('internal-note', 'Api\v1\ApiController@internalNote');
            /*
             * Newly added
             */
            Route::get('customers-custom', 'Api\v1\ApiController@getCustomersWith');
            Route::get('collaborator/search', 'Api\v1\ApiController@collaboratorSearch');
            Route::post('collaborator/create', 'Api\v1\ApiController@addCollaboratorForTicket');
            Route::post('collaborator/remove', 'Api\v1\ApiController@deleteCollaborator');
            Route::post('collaborator/get-ticket', 'Api\v1\ApiController@getCollaboratorForTicket');
            Route::get('my-tickets-user', 'Api\v1\ApiController@getMyTicketsUser');
            Route::get('dependency', 'Api\v1\ApiController@dependency');
        });
        /*
         * Testing Url
         */
        Route::get('create/user', 'Api\v1\TestController@createUser');
        Route::get('create/ticket', 'Api\v1\TestController@createTicket');
        Route::get('ticket/reply', 'Api\v1\TestController@ticketReply');
        Route::get('ticket/edit', 'Api\v1\TestController@editTicket');
        Route::get('ticket/delete', 'Api\v1\TestController@deleteTicket');
        Route::get('ticket/open', 'Api\v1\TestController@openedTickets');
        Route::get('ticket/unassigned', 'Api\v1\TestController@unassignedTickets');
        Route::get('ticket/closed', 'Api\v1\TestController@closeTickets');
        Route::get('ticket/assign', 'Api\v1\TestController@assignTicket');
        Route::get('ticket/agents', 'Api\v1\TestController@getAgents');
        Route::get('ticket/teams', 'Api\v1\TestController@getTeams');
        Route::get('ticket/customers', 'Api\v1\TestController@getCustomers');
        Route::get('ticket/customer', 'Api\v1\TestController@getCustomer');
        Route::get('ticket/search', 'Api\v1\TestController@getSearch');
        Route::get('ticket/thread', 'Api\v1\TestController@ticketThreads');
        Route::get('ticket/url', 'Api\v1\TestController@url');
        Route::get('ticket/api', 'Api\v1\TestController@generateApiKey');
        Route::get('ticket/help-topic', 'Api\v1\TestController@getHelpTopic');
        Route::get('ticket/sla-plan', 'Api\v1\TestController@getSlaPlan');
        Route::get('ticket/priority', 'Api\v1\TestController@getPriority');
        Route::get('ticket/department', 'Api\v1\TestController@getDepartment');
        Route::get('ticket/tickets', 'Api\v1\TestController@getTickets');
        Route::get('ticket/inbox', 'Api\v1\TestController@inbox');
        Route::get('ticket/internal', 'Api\v1\TestController@internalNote');
        Route::get('ticket/trash', 'Api\v1\TestController@trash');
        Route::get('ticket/my', 'Api\v1\TestController@myTickets');
        Route::get('ticket', 'Api\v1\TestController@getTicketById');
        /*
         * Newly added
         */
        Route::get('ticket/customers-custom', 'Api\v1\TestController@getCustomersWith');
        Route::get('generate/token', 'Api\v1\TestController@generateToken');
        Route::get('get/user', 'Api\v1\TestController@getAuthUser');

        /*
         * FCM token response
         */
        Route::post('fcmtoken', ['as' => 'fcmtoken', 'uses' => 'Common\PushNotificationController@fcmToken']);
    });










});
