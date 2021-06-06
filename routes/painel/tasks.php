<?php

Route::resource('/issues', 'IssueController')->parameters([
    'issues' => 'id'
]);