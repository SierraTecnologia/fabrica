<?php

Route::group(
    ['middleware' => ['web']], function () {

        Route::prefix('fabrica')->group(
            function () {
                Route::group(
                    ['as' => 'fabrica.'], function () {




                        Route::resource('projects', 'ProjectController');
                        // /**
                        //  * 
                        //  */
                        // Route::get('home', 'HomeController@index')->name('home');
                        // Route::get('persons', 'HomeController@persons')->name('persons');

                        // /**
                        //  * Track
                        //  */
                        // Route::prefix('track')->group(
                        //     function () {
                        //         Route::namespace('Track')->group(
                        //             function () {
                        //                 Route::group(
                        //                     ['as' => 'track.'], function () {

                        //                         Route::get('person', 'PersonController@index')->name('person');

                        //                     }
                        //                 );
                        //             }
                        //         );
                        //     }
                        // );

                    }
                );
            }
        );

    }
);