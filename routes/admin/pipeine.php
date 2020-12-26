<?php

Route::resource('/status', 'StatusController')->parameters([
    'status' => 'id'
]);
Route::resource('/stages', 'StageController')->parameters([
    'stages' => 'id'
]);
Route::resource('/resolutions', 'ResolutionController')->parameters([
    'resolutions' => 'id'
]);
