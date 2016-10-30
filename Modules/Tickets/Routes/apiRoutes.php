<?php
use Illuminate\Routing\Router;

Route::get('/ticketsdata', ['as' => 'tickets.data', 'uses' => 'TicketsController@anyData']);
Route::get('/slaplansdata', ['as' => 'slaplans.data', 'uses' => 'SlaPlansController@anyData']);
Route::get('/tickettypesdata', ['as' => 'tickettypes.data', 'uses' => 'TicketTypesController@anyData']);
Route::get('/ticketprioritiesdata', ['as' => 'ticketpriorities.data', 'uses' => 'TicketPrioritiesController@anyData']);
Route::get('/ticketstatusesdata', ['as' => 'ticketstatuses.data', 'uses' => 'TicketStatusesController@anyData']);
Route::get('/tickethelptopicsdata', ['as' => 'tickethelptopics.data', 'uses' => 'TicketHelpTopicsController@anyData']);
Route::get('/ticketcategoriesdata', ['as' => 'ticketcategories.data', 'uses' => 'TicketCategoriesController@anyData']);
Route::get('/ticketsourcesdata', ['as' => 'ticketsources.data', 'uses' => 'TicketSourcesController@anyData']);
Route::get('/ticketlinktypesdata', ['as' => 'ticketlinktypes.data', 'uses' => 'TicketLinkTypesController@anyData']);

Route::patch('/change-owner/{id}', ['as' => 'change.owner.ticket', 'uses' => 'TicketsController@changeOwner']); /* change owner */
//To merge tickets
Route::get('/get-merge-tickets/{id}', ['as' => 'get.merge.tickets', 'uses' => 'TicketsController@getMergeTickets']);
Route::get('/check-merge-ticket/{id}', ['as' => 'check.merge.tickets', 'uses' => 'TicketsController@checkMergeTickets']);
Route::get('/get-parent-tickets/{id}', ['as' => 'get.parent.ticket', 'uses' => 'TicketsController@getParentTickets']);
Route::patch('/merge-tickets/{id}', ['as' => 'merge.tickets', 'uses' => 'TicketsController@mergeTickets']);

/**
 * TICKETS
 */
Route::patch('/updatestatus/{id}', 'TicketsController@updateStatus');
Route::patch('/updateassign/{id}', 'TicketsController@updateAssign');
Route::post('/updatetime/{id}', 'TicketsController@updateTime');
Route::post('/invoice/{id}', 'TicketsController@invoice');
Route::post('/comments/{id}', 'CommentController@store');
Route::post('select_all', ['as' => 'select_all', 'uses' => 'TicketsController@select_all']);
