<?php

Route::group(['prefix' => 'invoicespanel'], function () {
    Route::get(   '',      ['as' => 'invoicespanel',          'uses' => 'InvoicesController@index']);

}); // End of ADMIN group
