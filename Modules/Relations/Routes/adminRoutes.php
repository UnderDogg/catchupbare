<?php

// Site administration section
Route::group(['prefix' => 'relationspanel'], function () {

    Route::get(   '',      ['as' => 'relationspanel',          'uses' => 'RelationsController@dashboard']);

    Route::post(  'relation',                         ['as' => 'admin.relations.store',            'uses' => 'RelationsController@store']);
    Route::get(   'relations',                         ['as' => 'admin.relations.index',            'uses' => 'RelationsController@index']);
    Route::get(   'relations/manage',                  ['as' => 'admin.relations.manage',            'uses' => 'RelationsController@index']);
    Route::get(   'relation/create',                  ['as' => 'admin.relations.create',           'uses' => 'RelationsController@create']);
    Route::get(   'relation/{relationId}',                ['as' => 'admin.relations.show',             'uses' => 'RelationsController@show']);
    Route::patch( 'relation/{relationId}',                ['as' => 'admin.relations.patch',            'uses' => 'RelationsController@update']);
    Route::put(   'relation/{relationId}',                ['as' => 'admin.relations.update',           'uses' => 'RelationsController@update']);
    Route::delete('relation/{relationId}',                ['as' => 'admin.relations.destroy',          'uses' => 'RelationsController@destroy']);
    Route::get(   'relation/{relationId}/edit',           ['as' => 'admin.relations.edit',             'uses' => 'RelationsController@edit']);
    Route::get(   'relation/{relationId}/confirm-delete', ['as' => 'admin.relations.confirm-delete',   'uses' => 'RelationsController@getModalDelete']);
    Route::get(   'relation/{relationId}/delete',         ['as' => 'admin.relations.delete',           'uses' => 'RelationsController@destroy']);


}); // End of ADMIN group
