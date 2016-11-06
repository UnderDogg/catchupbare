<?php
use Illuminate\Routing\Router;


Route::post('validating-email-settings', ['as' => 'validating.email.settings', 'uses' => 'MailboxesController@validatingMailboxSettings']); // route to check email input validation
Route::post('validating-email-settings-on-update/{id}', ['as' => 'validating.email.settings.update', 'uses' => 'MailboxesController@validatingMailboxSettingsUpdate']); // route to check email input validation

Route::get('getemail', 'Admin\helpdesk\SettingsController@getemail'); // direct to email setting page
Route::patch('postemail/{id}', 'Admin\helpdesk\SettingsController@postemail'); // Updating the Email table with requests


/*
        Route::resource('emails', 'Admin\helpdesk\EmailsController'); // in emails module, for CRUD
        Breadcrumbs::register('emails.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.emails'), route('emails.index'));
        });
        Breadcrumbs::register('emails.create', function ($breadcrumbs) {
            $breadcrumbs->parent('emails.index');
            $breadcrumbs->push(Lang::get('lang.create'), route('emails.create'));
        });
        Breadcrumbs::register('emails.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('emails.index');
            $breadcrumbs->push(Lang::get('lang.edit'), url('emails/{emails}/edit'));
        });
        Route::resource('banlist', 'Admin\helpdesk\BanlistController'); // in banlist module, for CRUD
        Breadcrumbs::register('banlist.index', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.banlists'), route('banlist.index'));
        });
        Breadcrumbs::register('banlist.create', function ($breadcrumbs) {
            $breadcrumbs->parent('banlist.index');
            $breadcrumbs->push(Lang::get('lang.add'), route('banlist.create'));
        });
        Breadcrumbs::register('banlist.edit', function ($breadcrumbs) {
            $breadcrumbs->parent('banlist.index');
            $breadcrumbs->push(Lang::get('lang.edit'), url('agents/{agents}/edit'));
        });
        Route::get('banlist/delete/{id}', ['as' => 'banlist.delete', 'uses' => 'Admin\helpdesk\BanlistController@delete']); // in banlist module, for CRUD
*/

/*
 * Templates
 *  /
Breadcrumbs::register('template-sets.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('All Template sets', route('template-sets.index'));
});
Breadcrumbs::register('show.templates', function ($breadcrumbs) {
    $page = App\Model\Common\Template::whereId(1)->first();
    $breadcrumbs->parent('template-sets.index');
    $breadcrumbs->push('All Templates', route('show.templates', $page->id));
});
Breadcrumbs::register('templates.edit', function ($breadcrumbs) {
    $page = App\Model\Common\Template::whereId(1)->first();
    $breadcrumbs->parent('show.templates');
    $breadcrumbs->push('Edit Template', route('templates.edit', $page->id));
});
Route::resource('templates', 'Common\TemplateController');
Route::get('get-templates', 'Common\TemplateController@GetTemplates');
Route::get('templates-delete', 'Common\TemplateController@destroy');
Route::get('testmail/{id}', 'Common\TemplateController@mailtest');
Route::resource('template-sets', 'Common\TemplateSetController'); // in template module, for CRUD
Route::get('delete-sets/{id}', ['as' => 'sets.delete', 'uses' => 'Common\TemplateSetController@deleteSet']);
Route::get('show-template/{id}', ['as' => 'show.templates', 'uses' => 'Common\TemplateController@showTemplate']);
Route::get('activate-templateset/{name}', ['as' => 'active.template-set', 'uses' => 'Common\TemplateSetController@activateSet']);
Route::resource('template', 'Admin\helpdesk\TemplateController'); // in template module, for CRUD
Route::get('list-directories', 'Admin\helpdesk\TemplateController@listdirectories');
Route::get('activate-set/{dir}', ['as' => 'active.set', 'uses' => 'Admin\helpdesk\TemplateController@activateset']);
Route::get('list-templates/{template}/{directory}', ['as' => 'template.list', 'uses' => 'Admin\helpdesk\TemplateController@listtemplates']);
Route::get('read-templates/{template}/{directory}', ['as' => 'template.read', 'uses' => 'Admin\helpdesk\TemplateController@readtemplate']);
Route::patch('write-templates/{contents}/{directory}', ['as' => 'template.write', 'uses' => 'Admin\helpdesk\TemplateController@writetemplate']);
Route::post('create-templates', ['as' => 'template.createnew', 'uses' => 'Admin\helpdesk\TemplateController@createtemplate']);
Route::get('delete-template/{template}/{path}', ['as' => 'templates.delete', 'uses' => 'Admin\helpdesk\TemplateController@deletetemplate']);
Route::get('getdiagno', ['as' => 'getdiagno', 'uses' => 'Admin\helpdesk\TemplateController@formDiagno']); // for getting form for diagnostic
Breadcrumbs::register('getdiagno', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.email_diagnostic'), route('getdiagno'));
});
Route::post('postdiagno', ['as' => 'postdiagno', 'uses' => 'Admin\helpdesk\TemplateController@postDiagno']); // for getting form for diagnostic
*/
Route::patch('postemail/{id}', 'Admin\helpdesk\SettingsController@postemail'); // Updating the Email table with requests

// Route::get('getaccess', 'Admin\helpdesk\SettingsController@getaccess'); // direct to access setting page
// Route::patch('postaccess/{id}', 'Admin\helpdesk\SettingsController@postaccess'); // Updating the Access table with requests



// Templates
/*Breadcrumbs::register('security.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.security_settings'), route('security.index'));
});
// Templates > Upload Templates
Breadcrumbs::register('security.create', function ($breadcrumbs) {
    $breadcrumbs->parent('security.index');
    $breadcrumbs->push('Upload security', route('security.create'));
});
// Templates > [Templates Name]
Breadcrumbs::register('security.show', function ($breadcrumbs, $photo) {
    $breadcrumbs->parent('security.index');
    $breadcrumbs->push($photo->title, route('security.show', $photo->id));
});
// Templates > [Templates Name] > Edit Templates
Breadcrumbs::register('security.edit', function ($breadcrumbs, $photo) {
    $breadcrumbs->parent('security.show', $photo);
    $breadcrumbs->push('Edit security', route('security.edit', $photo->id));
});*/


Route::get('/test', ['as' => 'thr', 'uses' => 'MailController@fetchdata']); /*  Fetch Emails */

Route::get('/email/ban/{id}', ['as' => 'ban.email', 'uses' => 'TicketController@ban']); /*  Get Ban Email */


Route::get('/getMail/{id}', ['as' => 'getmail', 'uses' => 'EMailController@getMail']);
Route::get('/connectexchange/{id}', ['as' => 'connectexchange', 'uses' => 'EMailController@connectexchange']);

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


    Route::get('autoresponder', ['as' => 'autoresponder', 'uses' => 'AutoResponsesController@getresponder']); // direct to responder setting page
    /*
    Breadcrumbs::register('getresponder', function ($breadcrumbs) {
       $breadcrumbs->parent('setting');
       $breadcrumbs->push(Lang::get('lang.auto_responce'), route('getresponder'));
    });*/
    Route::patch('postresponder/{id}', 'AutoResponsesController@postresponder'); // Updating the Responder table with requests



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

        Route::delete('/{mailtemplate}', [
            'as' => 'mailpanel.mailtemplates.destroy',
            'uses' => 'MailTemplatesController@destroy',
            //'middleware' => 'can:mailboxes.mailboxes.destroy'
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