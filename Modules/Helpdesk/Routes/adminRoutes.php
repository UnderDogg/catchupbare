<?php

Route::group(['prefix' => 'helpdeskpanel'], function () {
    Route::get(   '',      ['as' => 'helpdeskpanel',          'uses' => 'HelpdeskController@index']);

}); // End of ADMIN group
