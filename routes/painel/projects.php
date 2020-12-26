<?php

Route::resource('/projects', 'ProjectController')->parameters([
    'projects' => 'id'
]);

Route::prefix('arquitetura')->group(
    function () {
        Route::group(
            ['as' => 'arquitetura.'], function () {
                Route::get('/', 'ArquiteturaController@index')->name('index');
            }
        );
    }
);
Route::prefix('fields')->group(
    function () {
        Route::group(
            ['as' => 'fields.'], function () {
                Route::get('/', 'FieldsController@index')->name('index');
            }
        );
    }
);
