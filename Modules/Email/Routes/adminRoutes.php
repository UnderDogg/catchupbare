<?php
use Illuminate\Routing\Router;


Route::post('validating-email-settings', ['as' => 'validating.email.settings', 'uses' => 'MailboxesController@validatingMailboxSettings']); // route to check email input validation
Route::post('validating-email-settings-on-update/{id}', ['as' => 'validating.email.settings.update', 'uses' => 'MailboxesController@validatingMailboxSettingsUpdate']); // route to check email input validation

Route::get('getemail', 'Admin\helpdesk\SettingsController@getemail'); // direct to email setting page
Route::patch('postemail/{id}', 'Admin\helpdesk\SettingsController@postemail'); // Updating the Email table with requests


Route::get('/test', ['as' => 'thr', 'uses' => 'MailController@fetchdata']); /*  Fetch Emails */

Route::get('/email/ban/{id}', ['as' => 'ban.email', 'uses' => 'TicketController@ban']); /*  Get Ban Email */


Route::get('/getMail/{id}',  ['as' => 'getmail', 'uses' => 'EMailController@getMail']);
Route::get('/connectexchange/{id}',  ['as' => 'connectexchange', 'uses' => 'EMailController@connectexchange']);

/*
  |=============================================================
  |  Cron Job links
  |=============================================================
  |	These links are for cron job execution
  |
 */
/*Route::get('getMail', ['as' => 'getMail', 'uses' => 'EMailController@getMail']);
Route::get('readmails', ['as' => 'readmails', 'uses' => 'EMailController@readmails']);*/
/*
  |=============================================================
  |  /Cron Job links
  |=============================================================
  |	These links ^^^ are for cron job execution
  |
 */

Route::group(['prefix' => 'mailpanel'], function () {
    //Route::resource('mailboxes', 'MailboxesController');


    Route::get('/', [
        'as' => 'admin.mailboxes.mailpanel.index',
        'uses' => 'MailboxesController@maildashboard',
        //'middleware' => 'can:mailboxes.mailboxes.index'
    ]);


    Route::group(['prefix' => '/inbox'], function () {
        Route::resource('mailboxes', 'MailboxesController');
        Route::resource('emailmessages', 'EMailController');

        Route::get('/', [
            'as' => 'admin.mailpanel.mailboxes.inboxall',
            'uses' => 'EMailController@inboxall',
            //'middleware' => 'can:mailboxes.mailboxes.index'
        ]);


        Route::get('/{id}', [
            'as' => 'admin.mailpanel.mailboxes.inbox',
            'uses' => 'EMailController@inbox',
            //'middleware' => 'can:mailboxes.mailboxes.index'
        ]);
    });


    Route::group(['prefix' => '/mailbanlist'], function () {
        Route::resource('banlist', 'BanlistController'); // in banlist module, for CRUD
        Route::get('/', [
            'as' => 'admin.mailpanel.mailbanlist.manage',
            'uses' => 'BanlistController@index',
            //'middleware' => 'can:mailboxes.mailboxes.index'
        ]);
    });

    Route::group(['prefix' => '/maildiagno'], function () {
        //Route::get('getdiagno', 'Admin\helpdesk\TemplateController@formDiagno'); // for getting form for diagnostic
        //Route::post('postdiagno', 'Admin\helpdesk\TemplateController@postDiagno'); // for getting form for diagnostic
        Route::get('/getmaildiagno', [
            'as' => 'admin.mailpanel.getmaildiagno',
            'uses' => 'MailTemplatesController@formDiagno',
            //'middleware' => 'can:mailboxes.mailboxes.index'
        ]);

        Route::get('/postdiagno', [
            'as' => 'admin.mailpanel.postmaildiagno',
            'uses' => 'MailTemplatesController@postDiagno',
            //'middleware' => 'can:mailboxes.mailboxes.index'
        ]);
    });

//getmaildiagno
    Route::group(['prefix' => '/mailtemplates'], function () {
        Route::resource('mailtemplates', 'MailTemplatesController'); // in template module, for CRUD

        Route::get('/', [
            'as' => 'admin.mailpanel.mailtemplates.manage',
            'uses' => 'MailTemplatesController@index',
            //'middleware' => 'can:mailboxes.mailboxes.index'
        ]);

        Route::get('/create', [
            'as' => 'mailpanel.mailtemplates.create',
            'uses' => 'MailTemplatesController@create',
            //'middleware' => 'can:mailboxes.mailboxes.index'
        ]);

    });


    Route::group(['prefix' => '/mailtemplategroups'], function () {
        Route::resource('mailtemplategroups', 'MailTemplateGroupsController'); // in template module, for CRUD

        Route::get('/', [
            'as' => 'admin.mailpanel.mailtemplategroups.manage',
            'uses' => 'MailTemplateGroupsController@index',
            //'middleware' => 'can:mailboxes.mailboxes.index'
        ]);
    });


    Route::group(['prefix' => '/autoresponses'], function () {
        Route::resource('autoresponses', 'AutoResponsesController'); // in template module, for CRUD

        Route::get('/', [
            'as' => 'admin.mailpanel.autoresponses.manage',
            'uses' => 'AutoResponsesController@index',
            //'middleware' => 'can:mailboxes.mailboxes.index'
        ]);
    });


    Route::group(['prefix' => '/mailrules'], function () {
        Route::resource('mailrules', 'MailRulesController'); // in template module, for CRUD

        Route::get('/', [
            'as' => 'admin.mailpanel.mailrules.manage',
            'uses' => 'MailRulesController@index',
            //'middleware' => 'can:mailboxes.mailboxes.index'
        ]);
    });

    Route::group(['prefix' => '/breaklines'], function () {
        Route::resource('breaklines', 'BreakLinesController'); // in template module, for CRUD

        Route::get('/', [
            'as' => 'admin.mailpanel.breaklines.manage',
            'uses' => 'BreakLinesController@index',
            //'middleware' => 'can:mailboxes.mailboxes.index'
        ]);
    });


    Route::group(['prefix' => '/mailboxes'], function () {
        //Route::resource('mailboxes', 'MailboxesController');

        Route::get('/', [
            'as' => 'admin.mailboxes.mailboxes.manage',
            'uses' => 'MailboxesController@manage',
            //'middleware' => 'can:mailboxes.mailboxes.index'
        ]);

        Route::get('/manage', [
            'as' => 'admin.mailboxes.mailboxes.manage',
            'uses' => 'MailboxesController@manage',
            //'middleware' => 'can:mailboxes.mailboxes.create'
        ]);

        /*        Route::get('/manage', [
                    'as' => 'admin.mailboxes.mailboxes.manage',
                    'uses' => 'MailboxesController@manage',
                    //'middleware' => 'can:mailboxes.mailboxes.index'
                ]);*/
    });

    Route::group(['prefix' => '/mailbox'], function () {
        //Route::resource('mailboxes', 'MailboxesController');

        Route::get('/create', [
            'as' => 'admin.mailboxes.mailbox.create',
            'uses' => 'MailboxesController@create',
            //'middleware' => 'can:mailboxes.mailboxes.create'
        ]);
        Route::post('/', [
            'as' => 'admin.mailboxes.mailbox.store',
            'uses' => 'MailboxesController@store',
            //'middleware' => 'can:mailboxes.mailboxes.store'
        ]);
        Route::get('/{mailbox}/edit', [
            'as' => 'admin.mailboxes.mailbox.edit',
            'uses' => 'MailboxesController@edit',
            //'middleware' => 'can:mailboxes.mailboxes.edit'
        ]);
        Route::put('/{mailbox}', [
            'as' => 'admin.mailboxes.mailbox.update',
            'uses' => 'MailboxesController@update',
            //'middleware' => 'can:mailboxes.mailboxes.update'
        ]);
        Route::delete('/{mailbox}', [
            'as' => 'admin.mailboxes.mailbox.destroy',
            'uses' => 'MailboxesController@destroy',
            //'middleware' => 'can:mailboxes.mailboxes.destroy'
        ]);
        // append
    });

    // append
}); // End of MailPanel group