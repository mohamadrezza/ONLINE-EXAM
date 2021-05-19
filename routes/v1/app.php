<?php

use App\User;
use Illuminate\Support\Facades\Route;



Route::post('register', "Auth\AuthController@register");
Route::post('login', 'Auth\AuthController@login');


Route::get('lessons', 'Auth\AuthController@login');
Route::get('exams', 'Auth\AuthController@login');

Route::get('test',function(){
    return auth()->login(User::find(2));
});


Route::group(['prefix' => 'lessons'], function () {
    Route::get('/', 'NotificationController@saveToken');

    Route::group(['prefix' => '{id}/exams'], function () {
        Route::get('/', 'NotificationController@saveToken');
        Route::post('/create', 'ExamController@create')->middleware('TeacherRole');
        Route::get('/{examId}', 'ExamController@getById');
        Route::get('/{examId}/start', 'ExamController@start');

        Route::group(['prefix' => '{id}/questions'], function () {
            Route::get('/', 'QuestionController@create');
            Route::post('/', 'NotificationController@get');
        });


    });
});


