<?php


Route::group(['prefix' => 'calendarpanel'], function () {
    Route::get(   '',      ['as' => 'calendarpanel',          'uses' => 'CalendarController@index']);

}); // End of ADMIN group
