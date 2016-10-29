<?php

Route::group(['prefix' => 'helpdeskspanel'], function () {
    Route::get(   '',      ['as' => 'helpdeskpanel',          'uses' => 'HelpdeskController@index']);

}); // End of ADMIN group
