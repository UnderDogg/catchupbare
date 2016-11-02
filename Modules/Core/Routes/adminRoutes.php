<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
/*
 * Webhook
 */
\Event::listen('ticket.details', function ($details) {
    $api_control = new \App\Http\Controllers\Common\ApiSettings();
    $api_control->ticketDetailEvent($details);
});


// Routes in this group must be authorized.
//'middleware' => 'authorize'
Route::group([], function () {

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
    Route::get('staff/profile', ['as' => 'staff.profile', 'uses' => 'StaffController@profile']);
    Route::patch('staff/profile', ['as' => 'staff.profile.patch', 'uses' => 'StaffController@profileUpdate']);

    // Site administration section
    Route::group(['prefix' => 'adminpanel'], function () {

        Route::get('', ['as' => 'adminpanel', 'uses' => 'DashboardController@index']);

        Route::get('companies/getcompany', ['as' => 'adminpanel', 'uses' => 'CompaniesController@getcompany']);
        Route::get('companies/deletelogo', ['as' => 'deletecompanylogo', 'uses' => 'CompaniesController@getcompany']);


        //Notification marking
        Route::post('mark-read/{id}', 'Common\NotificationController@markRead');
        Route::post('mark-all-read/{id}', 'Common\NotificationController@markAllRead');
        /*        Breadcrumbs::register('notification.list', function ($breadcrumbs) {
                    $breadcrumbs->parent('dashboard');
                    $breadcrumbs->push('All Notifications', route('notification.list'));
                });*/
        Route::get('notifications-list', ['as' => 'notification.list', 'uses' => 'Common\NotificationController@show']);
        Route::post('notification-delete/{id}', ['as' => 'notification.delete', 'uses' => 'Common\NotificationController@delete']);
        /*        Breadcrumbs::register('notification.settings', function ($breadcrumbs) {
                    $breadcrumbs->parent('setting');
                    $breadcrumbs->push('Notifications Settings', route('notification.settings'));
                });*/
        Route::get('settings-notification', ['as' => 'notification.settings', 'uses' => 'Admin\helpdesk\SettingsController@notificationSettings']);
        Route::get('delete-read-notification', 'Admin\helpdesk\SettingsController@deleteReadNoti');
        Route::post('delete-notification-log', 'Admin\helpdesk\SettingsController@deleteNotificationLog');

        Route::get('job-scheduler', ['as' => 'get.job.scheduler', 'uses' => 'CronJobsController@getScheduler']); //to get ob scheduler form page
        /*        Breadcrumbs::register('get.job.scheder', function ($breadcrumbs) {
                    $breadcrumbs->parent('setting');
                    $breadcrumbs->push(Lang::get('lang.cron-jobs'), route('get.job.scheder'));
                });*/


        /*
         * Error and debugging
         */
        //route for showing error and debugging setting form page
        Route::get('error-and-debugging-options', ['as' => 'err.debug.settings', 'uses' => 'Admin\helpdesk\ErrorAndDebuggingController@showSettings']);
        /*Breadcrumbs::register('err.debug.settings', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.error-debug-settings'), route('err.debug.settings'));
        });*/
        //route for submit error and debugging setting form page
        Route::post('post-settings', ['as' => 'post.error.debug.settings',
            'uses' => 'Admin\helpdesk\ErrorAndDebuggingController@postSettings',]);
        //route to error logs table page
        Route::get('show-error-logs', [
            'as' => 'error.logs',
            'uses' => 'Admin\helpdesk\ErrorAndDebuggingController@showErrorLogs',
        ]);


        Route::get('test', ['as' => 'test', 'uses' => 'Common\PushNotificationController@response']);

        // Staff routes
        Route::post('staff/enableSelected', ['as' => 'admin.staff.enable-selected', 'uses' => 'StaffController@enableSelected']);
        Route::post('staff/disableSelected', ['as' => 'admin.staff.disable-selected', 'uses' => 'StaffController@disableSelected']);
        Route::get('staff/search', ['as' => 'admin.staff.search', 'uses' => 'StaffController@searchByName']);
        Route::get('staff/list', ['as' => 'admin.staff.list', 'uses' => 'StaffController@listByPage']);
        Route::post('staff/getInfo', ['as' => 'admin.staff.get-info', 'uses' => 'StaffController@getInfo']);
        Route::post('staff', ['as' => 'admin.staff.store', 'uses' => 'StaffController@store']);
        Route::get('staff', ['as' => 'admin.staff.index', 'uses' => 'StaffController@index']);
        Route::get('staff/manage', ['as' => 'admin.staff.manage', 'uses' => 'StaffController@index']);
        Route::get('staff/create', ['as' => 'admin.staff.create', 'uses' => 'StaffController@create']);
        Route::get('staff/{staffId}', ['as' => 'admin.staff.show', 'uses' => 'StaffController@show']);
        Route::patch('staff/{staffId}', ['as' => 'admin.staff.patch', 'uses' => 'StaffController@update']);
        Route::put('staff/{staffId}', ['as' => 'admin.staff.update', 'uses' => 'StaffController@update']);
        Route::delete('staff/{staffId}', ['as' => 'admin.staff.destroy', 'uses' => 'StaffController@destroy']);
        Route::get('staff/{staffId}/edit', ['as' => 'admin.staff.edit', 'uses' => 'StaffController@edit']);
        Route::get('staff/{staffId}/confirm-delete', ['as' => 'admin.staff.confirm-delete', 'uses' => 'StaffController@getModalDelete']);
        Route::get('staff/{staffId}/delete', ['as' => 'admin.staff.delete', 'uses' => 'StaffController@destroy']);
        Route::get('staff/{staffId}/enable', ['as' => 'admin.staff.enable', 'uses' => 'StaffController@enable']);
        Route::get('staff/{staffId}/disable', ['as' => 'admin.staff.disable', 'uses' => 'StaffController@disable']);


        Route::post('department', ['as' => 'admin.departments.store', 'uses' => 'DepartmentsController@store']);
        Route::get('departments', ['as' => 'admin.departments.index', 'uses' => 'DepartmentsController@index']);
        Route::get('departments/manage', ['as' => 'admin.departments.manage', 'uses' => 'DepartmentsController@index']);
        Route::get('department/create', ['as' => 'admin.departments.create', 'uses' => 'DepartmentsController@create']);
        Route::get('department/{departmentId}', ['as' => 'admin.departments.show', 'uses' => 'DepartmentsController@show']);
        Route::patch('department/{departmentId}', ['as' => 'admin.departments.patch', 'uses' => 'DepartmentsController@update']);
        Route::put('department/{departmentId}', ['as' => 'admin.departments.update', 'uses' => 'DepartmentsController@update']);
        Route::delete('department/{departmentId}', ['as' => 'admin.departments.destroy', 'uses' => 'DepartmentsController@destroy']);
        Route::get('department/{departmentId}/edit', ['as' => 'admin.departments.edit', 'uses' => 'DepartmentsController@edit']);
        Route::get('department/{departmentId}/confirm-delete', ['as' => 'admin.departments.confirm-delete', 'uses' => 'DepartmentsController@getModalDelete']);
        Route::get('department/{departmentId}/delete', ['as' => 'admin.departments.delete', 'uses' => 'DepartmentsController@destroy']);


        Route::post('team', ['as' => 'admin.teams.store', 'uses' => 'TeamsController@store']);
        Route::get('teams', ['as' => 'admin.teams.index', 'uses' => 'TeamsController@index']);
        Route::get('teams/manage', ['as' => 'admin.teams.manage', 'uses' => 'TeamsController@index']);
        Route::get('team/create', ['as' => 'admin.teams.create', 'uses' => 'TeamsController@create']);
        Route::get('team/{teamId}', ['as' => 'admin.teams.show', 'uses' => 'TeamsController@show']);
        Route::patch('team/{teamId}', ['as' => 'admin.teams.patch', 'uses' => 'TeamsController@update']);
        Route::put('team/{teamId}', ['as' => 'admin.teams.update', 'uses' => 'TeamsController@update']);
        Route::delete('team/{teamId}', ['as' => 'admin.teams.destroy', 'uses' => 'TeamsController@destroy']);
        Route::get('team/{teamId}/edit', ['as' => 'admin.teams.edit', 'uses' => 'TeamsController@edit']);
        Route::get('team/{teamId}/confirm-delete', ['as' => 'admin.teams.confirm-delete', 'uses' => 'TeamsController@getModalDelete']);
        Route::get('team/{teamId}/delete', ['as' => 'admin.teams.delete', 'uses' => 'TeamsController@destroy']);

        /*        // resource is a function to process create,edit,read and delete
                Route::resource('groups', 'Admin\helpdesk\GroupController'); // for group module, for CRUD

                Breadcrumbs::register('groups.index', function ($breadcrumbs) {
                    $breadcrumbs->parent('setting');
                    $breadcrumbs->push(Lang::get('lang.groups'), route('groups.index'));
                });
                Breadcrumbs::register('groups.create', function ($breadcrumbs) {
                    $breadcrumbs->parent('groups.index');
                    $breadcrumbs->push(Lang::get('lang.create'), route('groups.create'));
                });
                Breadcrumbs::register('groups.edit', function ($breadcrumbs) {
                    $breadcrumbs->parent('groups.index');
                    $breadcrumbs->push(Lang::get('lang.edit'), url('groups/{groups}/edit'));
                });
                Route::resource('departments', 'Admin\helpdesk\DepartmentController'); // for departments module, for CRUD
                Breadcrumbs::register('departments.index', function ($breadcrumbs) {
                    $breadcrumbs->parent('setting');
                    $breadcrumbs->push(Lang::get('lang.departments'), route('departments.index'));
                });
                Breadcrumbs::register('departments.create', function ($breadcrumbs) {
                    $breadcrumbs->parent('departments.index');
                    $breadcrumbs->push(Lang::get('lang.create'), route('departments.create'));
                });
                Breadcrumbs::register('departments.edit', function ($breadcrumbs) {
                    $breadcrumbs->parent('departments.index');
                    $breadcrumbs->push(Lang::get('lang.edit'), url('departments/{departments}/edit'));
                });
                Route::resource('teams', 'Admin\helpdesk\TeamController'); // in teams module, for CRUD
                Breadcrumbs::register('teams.index', function ($breadcrumbs) {
                    $breadcrumbs->parent('setting');
                    $breadcrumbs->push(Lang::get('lang.teams'), route('teams.index'));
                });
                Breadcrumbs::register('teams.create', function ($breadcrumbs) {
                    $breadcrumbs->parent('teams.index');
                    $breadcrumbs->push(Lang::get('lang.create'), route('teams.create'));
                });
                Breadcrumbs::register('teams.edit', function ($breadcrumbs) {
                    $breadcrumbs->parent('teams.index');
                    $breadcrumbs->push(Lang::get('lang.edit'), url('teams/{teams}/edit'));
                });
                Route::get('/teams/show/{id}', ['as' => 'teams.show', 'uses' => 'Admin\helpdesk\TeamController@show']); /*  Get Team View * /
                 Breadcrumbs::register('teams.show', function ($breadcrumbs) {
                     $breadcrumbs->parent('teams.index');
                     $breadcrumbs->push(Lang::get('lang.show'), url('teams/{teams}/show'));
                 });
                Route::get('getshow/{id}', ['as' => 'teams.getshow.list', 'uses' => 'Admin\helpdesk\TeamController@getshow']);
                Route::resource('agents', 'Admin\helpdesk\AgentController'); // in agents module, for CRUD
                Breadcrumbs::register('agents.index', function ($breadcrumbs) {
                    $breadcrumbs->parent('setting');
                    $breadcrumbs->push(Lang::get('lang.agents'), route('agents.index'));
                });
                Breadcrumbs::register('agents.create', function ($breadcrumbs) {
                    $breadcrumbs->parent('agents.index');
                    $breadcrumbs->push(Lang::get('lang.create'), route('agents.create'));
                });
                Breadcrumbs::register('agents.edit', function ($breadcrumbs) {
                    $breadcrumbs->parent('agents.index');
                    $breadcrumbs->push(Lang::get('lang.edit'), url('agents/{agents}/edit'));
                });*/

        // Role routes
        Route::post('roles/enableSelected', ['as' => 'admin.roles.enable-selected', 'uses' => 'RolesController@enableSelected']);
        Route::post('roles/disableSelected', ['as' => 'admin.roles.disable-selected', 'uses' => 'RolesController@disableSelected']);
        Route::get('roles/search', ['as' => 'admin.roles.search', 'uses' => 'RolesController@searchByName']);
        Route::post('roles/getInfo', ['as' => 'admin.roles.get-info', 'uses' => 'RolesController@getInfo']);
        Route::post('roles', ['as' => 'admin.roles.store', 'uses' => 'RolesController@store']);
        Route::get('roles', ['as' => 'admin.roles.index', 'uses' => 'RolesController@index']);
        Route::get('roles/manage', ['as' => 'admin.roles.manage', 'uses' => 'RolesController@index']);
        Route::get('roles/create', ['as' => 'admin.roles.create', 'uses' => 'RolesController@create']);
        Route::get('roles/{roleId}', ['as' => 'admin.roles.show', 'uses' => 'RolesController@show']);
        Route::patch('roles/{roleId}', ['as' => 'admin.roles.patch', 'uses' => 'RolesController@update']);
        Route::put('roles/{roleId}', ['as' => 'admin.roles.update', 'uses' => 'RolesController@update']);
        Route::delete('roles/{roleId}', ['as' => 'admin.roles.destroy', 'uses' => 'RolesController@destroy']);
        Route::get('roles/{roleId}/edit', ['as' => 'admin.roles.edit', 'uses' => 'RolesController@edit']);
        Route::get('roles/{roleId}/confirm-delete', ['as' => 'admin.roles.confirm-delete', 'uses' => 'RolesController@getModalDelete']);
        Route::get('roles/{roleId}/delete', ['as' => 'admin.roles.delete', 'uses' => 'RolesController@destroy']);
        Route::get('roles/{roleId}/enable', ['as' => 'admin.roles.enable', 'uses' => 'RolesController@enable']);
        Route::get('roles/{roleId}/disable', ['as' => 'admin.roles.disable', 'uses' => 'RolesController@disable']);
        // Menu routes
        Route::post('menus', ['as' => 'admin.menus.save', 'uses' => 'MenusController@save']);
        Route::get('menus', ['as' => 'admin.menus.index', 'uses' => 'MenusController@index']);
        Route::get('menus/getData/{menuId}', ['as' => 'admin.menus.get-data', 'uses' => 'MenusController@getData']);
        Route::get('menus/{menuId}/confirm-delete', ['as' => 'admin.menus.confirm-delete', 'uses' => 'MenusController@getModalDelete']);
        Route::get('menus/{menuId}/delete', ['as' => 'admin.menus.delete', 'uses' => 'MenusController@destroy']);
        // Modules routes
        Route::get('modules', ['as' => 'admin.modules.index', 'uses' => 'ModulesController@index']);
        Route::get('modules/{slug}/initialize', ['as' => 'admin.modules.initialize', 'uses' => 'ModulesController@initialize']);
        Route::get('modules/{slug}/uninitialize', ['as' => 'admin.modules.uninitialize', 'uses' => 'ModulesController@uninitialize']);
        Route::get('modules/{slug}/enable', ['as' => 'admin.modules.enable', 'uses' => 'ModulesController@enable']);
        Route::get('modules/{slug}/disable', ['as' => 'admin.modules.disable', 'uses' => 'ModulesController@disable']);
        Route::post('modules/enableSelected', ['as' => 'admin.modules.enable-selected', 'uses' => 'ModulesController@enableSelected']);
        Route::post('modules/disableSelected', ['as' => 'admin.modules.disable-selected', 'uses' => 'ModulesController@disableSelected']);
        Route::get('modules/optimize', ['as' => 'admin.modules.optimize', 'uses' => 'ModulesController@optimize']);
        // Permission routes
        Route::get('permissions/generate', ['as' => 'admin.permissions.generate', 'uses' => 'PermissionsController@generate']);
        Route::post('permissions/enableSelected', ['as' => 'admin.permissions.enable-selected', 'uses' => 'PermissionsController@enableSelected']);
        Route::post('permissions/disableSelected', ['as' => 'admin.permissions.disable-selected', 'uses' => 'PermissionsController@disableSelected']);
        Route::post('permissions', ['as' => 'admin.permissions.store', 'uses' => 'PermissionsController@store']);
        Route::get('permissions', ['as' => 'admin.permissions.index', 'uses' => 'PermissionsController@index']);
        Route::get('permissions/create', ['as' => 'admin.permissions.create', 'uses' => 'PermissionsController@create']);
        Route::get('permissions/{permissionId}', ['as' => 'admin.permissions.show', 'uses' => 'PermissionsController@show']);
        Route::patch('permissions/{permissionId}', ['as' => 'admin.permissions.patch', 'uses' => 'PermissionsController@update']);
        Route::put('permissions/{permissionId}', ['as' => 'admin.permissions.update', 'uses' => 'PermissionsController@update']);
        Route::delete('permissions/{permissionId}', ['as' => 'admin.permissions.destroy', 'uses' => 'PermissionsController@destroy']);
        Route::get('permissions/{permissionId}/edit', ['as' => 'admin.permissions.edit', 'uses' => 'PermissionsController@edit']);
        Route::get('permissions/{permissionId}/confirm-delete', ['as' => 'admin.permissions.confirm-delete', 'uses' => 'PermissionsController@getModalDelete']);
        Route::get('permissions/{permissionId}/delete', ['as' => 'admin.permissions.delete', 'uses' => 'PermissionsController@destroy']);
        Route::get('permissions/{permissionId}/enable', ['as' => 'admin.permissions.enable', 'uses' => 'PermissionsController@enable']);
        Route::get('permissions/{permissionId}/disable', ['as' => 'admin.permissions.disable', 'uses' => 'PermissionsController@disable']);

        // Error routes
        Route::get('errors', ['as' => 'admin.errors.index', 'uses' => 'ErrorsController@index']);
        Route::get('errors/purge', ['as' => 'admin.errors.purge', 'uses' => 'ErrorsController@purge']);
        Route::get('errors/{errorId}/show', ['as' => 'admin.errors.show', 'uses' => 'ErrorsController@show']);
        // Settings routes
        Route::post('settings', ['as' => 'admin.settings.store', 'uses' => 'SettingsController@store']);
        Route::get('settings', ['as' => 'admin.settings.index', 'uses' => 'SettingsController@index']);
        Route::get('settings/load', ['as' => 'admin.settings.load', 'uses' => 'SettingsController@load']);
        Route::get('settings/create', ['as' => 'admin.settings.create', 'uses' => 'SettingsController@create']);
        Route::get('settings/{settingKey}', ['as' => 'admin.settings.show', 'uses' => 'SettingsController@show']);
        Route::patch('settings/{settingKey}', ['as' => 'admin.settings.patch', 'uses' => 'SettingsController@update']);
        Route::put('settings/{settingKey}', ['as' => 'admin.settings.update', 'uses' => 'SettingsController@update']);
        Route::delete('settings/{settingKey}', ['as' => 'admin.settings.destroy', 'uses' => 'SettingsController@destroy']);
        Route::get('settings/{settingKey}/edit', ['as' => 'admin.settings.edit', 'uses' => 'SettingsController@edit']);
        Route::get('settings/{settingKey}/confirm-delete', ['as' => 'admin.settings.confirm-delete', 'uses' => 'SettingsController@getModalDelete']);
        Route::get('settings/{settingKey}/delete', ['as' => 'admin.settings.delete', 'uses' => 'SettingsController@destroy']);

        Route::get('test', ['as' => 'test', 'uses' => 'Common\PushNotificationController@response']);

        Route::get('mail/config/service', ['as' => 'mail.config.service', 'uses' => 'Job\MailController@serviceForm']);
        /*
         * Queue
         */
        /*Breadcrumbs::register('queue', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.queues'), route('queue'));
        });*/
        Route::get('queue', ['as' => 'queue', 'uses' => 'Job\QueueController@index']);
        Route::get('form/queue', ['as' => 'queue.form', 'uses' => 'Job\QueueController@getForm']);
        /*Breadcrumbs::register('queue.edit', function ($breadcrumbs) {
            $id = \Input::segment(2);
            $breadcrumbs->parent('queue');
            $breadcrumbs->push(Lang::get('lang.edit'), route('queue.edit', $id));
        });*/
        Route::get('queue/{id}', ['as' => 'queue.edit', 'uses' => 'Job\QueueController@edit']);
        Route::post('queue/{id}', ['as' => 'queue.update', 'uses' => 'Job\QueueController@update']);
        Route::get('queue/{id}/activate', ['as' => 'queue.activate', 'uses' => 'Job\QueueController@activate']);
        Route::get('get-ticket-number', ['as' => 'get.ticket.number', 'uses' => 'Admin\helpdesk\SettingsController@getTicketNumber']);
        Route::get('genereate-pdf/{threadid}', ['as' => 'thread.pdf', 'uses' => 'Agent\helpdesk\TicketController@pdfThread']);

        /*
         * Url Settings
         */
        /*Breadcrumbs::register('url', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push('URL', route('url.settings'));
        });*/
        Route::get('url/settings', ['as' => 'url.settings', 'uses' => 'Admin\helpdesk\UrlSettingController@settings']);
        Route::patch('url/settings', ['as' => 'url.settings.post', 'uses' => 'Admin\helpdesk\UrlSettingController@postSettings']);

        /*
         * Social media settings
         */
        /*Breadcrumbs::register('social', function ($breadcrumbs) {
            $breadcrumbs->parent('setting');
            $breadcrumbs->push(Lang::get('lang.social-media'), route('social'));
        });*/
        /*Breadcrumbs::register('social.media', function ($breadcrumbs) {
            $id = \Input::segment(2);
            $breadcrumbs->parent('social');
            $breadcrumbs->push(Lang::get('lang.settings'), route('social.media', $id));
        });*/
        Route::get('social/media', ['as' => 'social', 'uses' => 'Admin\helpdesk\SocialMedia\SocialMediaController@index']);
        Route::get('social/media/{provider}', ['as' => 'social.media', 'uses' => 'Admin\helpdesk\SocialMedia\SocialMediaController@settings']);
        Route::post('social/media/{provider}', ['as' => 'social.media.post', 'uses' => 'Admin\helpdesk\SocialMedia\SocialMediaController@postSettings']);


        /*
         * Webhook
         */
        \Event::listen('ticket.details', function ($details) {
            $api_control = new \App\Http\Controllers\Common\ApiSettings();
            $api_control->ticketDetailEvent($details);
        });


        // user---arindam
        Route::post('rolechangeadmin/{id}', ['as' => 'user.post.rolechangeadmin', 'uses' => 'Agent\helpdesk\UserController@changeRoleAdmin']);
        Route::post('rolechangeagent/{id}', ['as' => 'user.post.rolechangeagent', 'uses' => 'Agent\helpdesk\UserController@changeRoleAgent']);
        Route::post('rolechangeuser/{id}', ['as' => 'user.post.rolechangeuser', 'uses' => 'Agent\helpdesk\UserController@changeRoleUser']);
        Route::get('password', ['as' => 'user.changepassword', 'uses' => 'Agent\helpdesk\UserController@randomPassword']);
        Route::post('changepassword/{id}', ['as' => 'user.post.changepassword', 'uses' => 'Agent\helpdesk\UserController@randomPostPassword']);
        Route::post('delete/{id}', ['as' => 'user.post.delete', 'uses' => 'Agent\helpdesk\UserController@deleteAgent']);


    }); // End of ADMIN group

    // Uncomment to enable Rapyd datagrid.
//    require __DIR__.'/rapyd.php';
});
