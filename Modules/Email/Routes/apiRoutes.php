<?php

use Illuminate\Http\Request;



Route::group(['prefix' => 'api'], function () {

    Route::get('mailboxesdata', [
        'as' => 'mailboxes.data',
        'uses' => 'MailboxesController@anyData',
        //'middleware' => 'can:mailboxes.mailboxes.index'
    ]);


    Route::get('banlistdata', [
        'as' => 'banlist.data',
        'uses' => 'BanlistController@anyData',
        //'middleware' => 'can:mailboxes.mailboxes.index'
    ]);


    Route::get('breaklinesdata', [
        'as' => 'breaklines.data',
        'uses' => 'BreakLinesController@anyData',
        //'middleware' => 'can:mailboxes.mailboxes.index'
    ]);

    Route::get('mailrulesdata', [
        'as' => 'mailrules.data',
        'uses' => 'MailRulesController@anyData',
        //'middleware' => 'can:mailboxes.mailboxes.index'
    ]);

}); // End of ADMIN group
