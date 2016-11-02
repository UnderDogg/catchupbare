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

Route::group(['middleware' => ['web']], function () {
        Route::get('social/login/redirect/{provider}/{redirect?}', ['uses' => 'Auth\AuthController@redirectToProvider', 'as' => 'social.login']);
        Route::get('social/login/{provider}', ['as' => 'social.login.callback', 'uses' => 'Auth\AuthController@handleProviderCallback']);
        Route::get('social-sync', ['as' => 'social.sync', 'uses' => 'Client\helpdesk\GuestController@sync']);
    Route::get('getmail/{token}', 'Auth\AuthController@getMail');




    /*
      |------------------------------------------------------------------
      |Guest Routes
      |--------------------------------------------------------------------
      | Here defining Guest User's routes
      |
      |
     */
    // search
//    Route::POST('tickets/search/', function () {
//        $keyword = Illuminate\Support\Str::lower(Input::get('auto'));
//        $models = App\Model\Ticket\Tickets::where('ticket_number', '=', $keyword)->orderby('ticket_number')->take(10)->skip(0)->get();
//        $count = count($models);
//        return Illuminate\Support\Facades\Redirect::back()->with('contents', $models)->with('counts', $count);
//    });
    Route::any('getdata', function () {
        $term = Illuminate\Support\Str::lower(Input::get('term'));
        $data = Illuminate\Support\Facades\DB::table('tickets')->distinct()->select('ticket_number')->where('ticket_number', 'LIKE', $term.'%')->groupBy('ticket_number')->take(10)->get();
        foreach ($data as $v) {
            return [
                'value' => $v->ticket_number,
            ];
        }
    });

    Route::post('postform/{id}', 'Client\helpdesk\FormController@postForm'); /* post the AJAX form for create a ticket by guest user */
    Route::post('postedform', ['as' => 'client.form.post', 'uses' => 'Client\helpdesk\FormController@postedForm']); /* post the form to store the value */
    Route::get('check', 'CheckController@getcheck'); //testing checkbox auto-populate
    Route::post('postcheck/{id}', 'CheckController@postcheck');
    Route::get('get-helptopic-form', 'Client\helpdesk\FormController@getCustomForm');
    Breadcrumbs::register('home', function ($breadcrumbs) {
        $breadcrumbs->push('Home', route('home'));
    });
    Route::get('home', ['as' => 'home', 'uses' => 'Client\helpdesk\WelcomepageController@index']); //guest layout
    Breadcrumbs::register('/', function ($breadcrumbs) {
        $breadcrumbs->push('Home', route('/'));
    });
    Route::get('/', ['as' => '/', 'uses' => 'Client\helpdesk\WelcomepageController@index']);
    Breadcrumbs::register('form', function ($breadcrumbs) {
        $breadcrumbs->push('Create Ticket', route('form'));
    });
    Route::get('create-ticket', ['as' => 'form', 'uses' => 'Client\helpdesk\FormController@getForm']); //getform
    Route::get('mytickets/{id}', ['as' => 'ticketinfo', 'uses' => 'Client\helpdesk\GuestController@singleThread']); //detail ticket information
    Route::post('checkmyticket', 'Client\helpdesk\UnAuthController@PostCheckTicket'); //ticket ckeck

    Route::get('check_ticket/{id}', ['as' => 'check_ticket', 'uses' => 'Client\helpdesk\GuestController@get_ticket_email']); //detail ticket information
    Breadcrumbs::register('check_ticket', function ($breadcrumbs, $id) {
        $page = \App\Model\helpdesk\Ticket\Tickets::whereId(1)->first();
        $breadcrumbs->parent('ticket2');
        $breadcrumbs->push('Check Ticket');
    });
// show ticket via have a ticket
    Route::get('show-ticket/{id}/{code}', ['as' => 'show.ticket', 'uses' => 'Client\helpdesk\UnAuthController@showTicketCode']); //detail ticket information
    Breadcrumbs::register('show.ticket', function ($breadcrumbs) {
        $breadcrumbs->push('Ticket', route('form'));
    });



    Route::get('checkticket', 'Client\helpdesk\ClientTicketController@getCheckTicket'); /* Check your Ticket */
    Route::get('myticket', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@getMyticket']); /* Get my tickets */
    Route::get('myticket/{id}', ['as' => 'ticket', 'uses' => 'Client\helpdesk\GuestController@thread']); /* Get my tickets */
    Route::post('postcheck', 'Client\helpdesk\GuestController@PostCheckTicket'); /* post Check Ticket */
    Route::get('postcheck', 'Client\helpdesk\GuestController@PostCheckTicket');
    Route::post('post-ticket-reply/{id}', 'Client\helpdesk\FormController@post_ticket_reply');

    /*
      |=============================================================
      |  View all the Routes
      |=============================================================
     */
    Route::get('/aaa', function () {
        $routeCollection = Route::getRoutes();
        echo "<table style='width:100%'>";
        echo '<tr>';
        echo "<td width='10%'><h4>HTTP Method</h4></td>";
        echo "<td width='10%'><h4>Route</h4></td>";
        echo "<td width='10%'><h4>Url</h4></td>";
        echo "<td width='80%'><h4>Corresponding Action</h4></td>";
        echo '</tr>';
        foreach ($routeCollection as $value) {
            echo '<tr>';
            echo '<td>'.$value->getMethods()[0].'</td>';
            echo '<td>'.$value->getName().'</td>';
            echo '<td>'.$value->getPath().'</td>';
            echo '<td>'.$value->getActionName().'</td>';
            echo '</tr>';
        }
        echo '</table>';
    });
    /*
      |=============================================================
      |  Error Routes
      |=============================================================
     */
    Route::get('500', ['as' => 'error500', function () {
        return view('errors.500');
    }]);
    Breadcrumbs::register('error500', function ($breadcrumbs) {
        $breadcrumbs->push('500');
    });
    Route::get('404', ['as' => 'error404', function () {
        return view('errors.404');
    }]);
    Breadcrumbs::register('error404', function ($breadcrumbs) {
        $breadcrumbs->push('404');
    });

    Route::get('error-in-database-connection', ['as' => 'errordb', function () {
        return view('errors.db');
    }]);

    Breadcrumbs::register('errordb', function ($breadcrumbs) {
        $breadcrumbs->push('Error establishing connection to database');
    });

    Route::get('unauthorized', ['as' => 'unauth', function () {
        return view('errors.unauth');
    }]);

    Breadcrumbs::register('unauth', function ($breadcrumbs) {
        $breadcrumbs->push('Unauthorized Access');
    });
    Route::get('board-offline', ['as' => 'board.offline', function () {
        return view('errors.offline');
    }]);
    Breadcrumbs::register('board.offline', function ($breadcrumbs) {
        $breadcrumbs->push('Board Offline');
    });








});
