<?php
use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/mailboxes'], function () {

    Route::resource('notifications', 'NotificationsController');
    /**
     * NOTIFICATIONS
     */
    //Route::get('/getall', 'NotificationsController@getAll')->name('notifications.get');
    //Route::post('/markread', 'NotificationsController@markRead');
    //Route::get('/markall', 'NotificationsController@markAll');
    // append
});
