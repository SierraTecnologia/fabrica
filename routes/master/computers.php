<?php

Route::resource('/computers', 'ComputerController')->parameters([
    'computers' => 'id'
]);
Route::resource('/directories', 'DirectoryController')->parameters([
    'directories' => 'id'
]);
Route::resource('/files', 'FileController')->parameters([
    'files' => 'id'
]);
