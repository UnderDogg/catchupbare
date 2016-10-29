<?php


Route::group(['prefix' => 'kbkpanel'], function () {
    Route::get(   '',      ['as' => 'kbkpanel',          'uses' => 'KnowledgeBaseController@index']);

}); // End of ADMIN group
