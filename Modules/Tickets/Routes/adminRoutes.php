<?php



Route::group(['prefix' => 'ticketspanel'], function () {
    Route::get(   '',      ['as' => 'ticketspanel',          'uses' => 'TicketsController@index']);

}); // End of ADMIN group
