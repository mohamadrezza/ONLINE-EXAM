<?php

use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'admin', 'middleware' => 'AdminRole'], function () {
    Route::prefix('lessons')->group(function () {
        Route::post('/', 'Admin\LessonController@create');
    });
    
    // Route::prefix('users')->group(function () {
    //     Route::get('/', 'Admin\UserController@getAll');
    // });
});
