<?php



Route::group(['prefix' => 'ticketspanel'], function () {

    Route::resource('tickets', 'TicketsController');

    Route::get('', ['as' => 'ticketsdash',          'uses' => 'TicketsDashBoardController@ticketsdashboard']);
    Route::get('/', ['as' => 'ticketspanel', 'uses' => 'TicketsDashBoardController@ticketsdashboard']);
    Route::get('/ticketinbox', ['as' => 'get.inbox.ticket', 'uses' => 'TicketsController@get_inbox']);  /* Get tickets in datatable */
    Route::get('/autoresponder', ['as' => 'autoresponder', 'uses' => 'TicketsController@autoresponder']);

  //To get department tickets data
  //open tickets of department
  Route::get('/get-open-tickets/{id}', ['as' => 'get.dept.open', 'uses' => 'Tickets2Controller@getOpenTickets']);
  //close tickets of deartment
  Route::get('/get-closed-tickets/{id}', ['as' => 'get.dept.close', 'uses' => 'Tickets2Controller@getCloseTickets']);
  //in progress ticket of department
  Route::get('/get-under-process-tickets/{id}', ['as' => 'get.dept.inprocess', 'uses' => 'Tickets2Controller@getInProcessTickets']);



    Route::get('/inbox', ['as' => 'ticketsinbox', 'uses' => 'TicketsController@inbox_ticket_list']);
    Route::get('/mytickets', ['as' => 'ticketsmytickets', 'uses' => 'TicketsController@myticket_ticket_list']); /*  Get Tickets Assigned to logged user */
    Route::get('/unassigned', ['as' => 'ticketsunassigned', 'uses' => 'TicketsController@unassigned']);
    Route::get('/overdue', ['as' => 'ticketsoverdue', 'uses' => 'TicketsController@overdue_ticket_list']);
    Route::get('/answered', ['as' => 'ticketsanswered', 'uses' => 'TicketsController@answered_ticket_list']);  /* Get tickets in datatable */


    Route::resource('ticketsettings', 'TicketSettingsController');
    Route::resource('ticketcategories', 'TicketCategoriesController');
    Route::resource('tickettypes', 'TicketTypesController');
    Route::resource('ticketstatuses', 'TicketStatusesController');
    Route::resource('ticketpriorities', 'TicketPrioritiesController');
    Route::resource('tickethelptopics', 'TicketHelpTopicsController');
    Route::resource('ticketlinktypes', 'TicketLinkTypesController');
    Route::resource('slaplans', 'SlaPlansController');
    Route::resource('autocloserules', 'AutoCloseRulesController');
    Route::resource('batchactions', 'BatchActionsController');
    Route::resource('ticketworkflows', 'WorkFlowsController');

    Route::get('/escalatetickets', ['as' => 'escalatetickets', 'uses' => 'TicketsEscalations@escalatetickets']);



    Route::get('/openperdepartment/{$department}', ['as' => 'dept.open.ticket', 'uses' => 'TicketsController@openticketsperdepartment']);
    Route::get('/inprogressperdepartment/{$department}', ['as' => 'dept.inprogress.ticket', 'uses' => 'TicketsController@inprogressticketsperdepartment']);
    Route::get('/closedperdepartment/{$department}', ['as' => 'dept.closed.ticket', 'uses' => 'TicketsController@closedticketsperdepartment']);



}); // End of ADMIN group


Route::group(['prefix' => '/tickets'], function () {
    Route::resource('tickets', 'TicketsController');
    /**
     * TICKETS
     */
    Route::patch('/updatestatus/{id}', 'TicketsController@updateStatus');
    Route::patch('/updateassign/{id}', 'TicketsController@updateAssign');
    Route::post('/updatetime/{id}', 'TicketsController@updateTime');
    Route::post('/invoice/{id}', 'TicketsController@invoice');
    Route::post('/comments/{id}', 'CommentController@store');
    Route::post('select_all', ['as' => 'select_all', 'uses' => 'TicketsController@select_all']);



    // append
});


