<?php

// Site administration section
Route::group(['prefix' => 'api'], function () {
    Route::get(   'relationsdata',                  ['as' => 'api.relations.data',           'uses' => 'RelationsController@anyData']);

}); // End of ADMIN group
