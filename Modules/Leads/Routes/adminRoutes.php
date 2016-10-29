<?php


Route::group(['prefix' => 'leadspanel'], function () {
    Route::get(   '',      ['as' => 'leadspanel',          'uses' => 'LeadsController@index']);

}); // End of ADMIN group
