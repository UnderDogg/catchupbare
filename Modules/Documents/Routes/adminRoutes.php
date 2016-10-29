<?php


Route::group(['prefix' => 'documentspanel'], function () {
    Route::get(   '',      ['as' => 'documentspanel',          'uses' => 'DocumentsController@index']);

}); // End of ADMIN group
