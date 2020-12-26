<?php

Route::resource('/fields', 'FieldController')->parameters([
    'fields' => 'id'
]);
