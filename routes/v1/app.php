<?php

use Illuminate\Support\Facades\Route;



Route::post('register', "Auth\AuthController@register");
Route::post('login', 'Auth\AuthController@login');


Route::get('lessons', 'Auth\AuthController@login');
Route::get('exams', 'Auth\AuthController@login');

Route::get('test',function(){
    return bcrypt('123456');
});


Route::group(['prefix' => 'lessons'], function () {
    Route::get('/', 'NotificationController@saveToken');

    Route::group(['prefix' => '{id}/exams'], function () {
        Route::get('/', 'NotificationController@saveToken');
        Route::post('/create', 'ExamController@create')->middleware('TeacherRole');
        Route::get('/{examId}', 'ExamController@getById');
        Route::get('/{examId}/start', 'ExamController@start');

        Route::group(['prefix' => 'questions'], function () {
            Route::get('/', 'NotificationController@saveToken');
            Route::post('/notif/push', 'NotificationController@pushNotif');
        });


    });
});



Route::post('confirm', 'Auth\AuthController@login');
