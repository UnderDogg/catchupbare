<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//auth:api
//authorize


// Routes in this group must be authorized.
Route::group(['middleware' => ''], function() {
    // Site administration section
    Route::group(['prefix' => 'api'], function () {
        Route::get(   'staffdata',                  ['as' => 'api.staff.data',           'uses' => 'StaffController@anyData']);
    }); // End of ADMIN group
});