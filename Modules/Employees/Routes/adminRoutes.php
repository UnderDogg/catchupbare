<?php

Route::group(['prefix' => 'employeespanel'], function () {
    Route::get(   '',      ['as' => 'employeespanel',          'uses' => 'EmployeesController@index']);

}); // End of ADMIN group
