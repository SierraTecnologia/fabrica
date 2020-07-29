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

                        /**
                         * Manager
                         */
                        Route::namespace('Manager')->group(
                            function () {
                                Route::prefix('manager')->group(
                                    function () {
                                        Route::group(
                                            ['as' => 'manager.'], function () {

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
                                            }
                                        );
                                    }
                                );    
                            }
                        );



                    }
                );
            }
        );

    }
);