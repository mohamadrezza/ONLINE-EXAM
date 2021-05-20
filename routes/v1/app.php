<?php

use App\User;
use Illuminate\Support\Facades\Route;


####################### Auth ############################
Route::post('register', "Auth\AuthController@register");
Route::post('login', 'Auth\AuthController@login');
########################################################




Route::group(['prefix' => 'lessons'], function () {
    Route::get('/', 'LessonController@getAll');
    Route::get('/{id}', 'LessonController@getById');


    Route::group(['prefix' => '/{id}/questions'], function () {
        Route::get('/', 'QuestionController@getAllByLessonId');
        Route::post('/', 'QuestionController@create')->middleware('auth');
        
    });
});


Route::get('test', function () {
    $x = ['a', 'b'];
    dd(in_array('c', $x));
    return auth()->login(User::find(2));
});
