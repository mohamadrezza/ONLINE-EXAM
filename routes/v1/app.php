<?php

use App\Exam;
use App\User;
use App\Question;
use App\StudentResult;
use App\QuestionAnswers;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Resources\QuizResource;
use Illuminate\Support\Facades\Route;

####################### Auth ###########################
Route::post('register', "Auth\AuthController@register");
Route::post('login', 'Auth\AuthController@login');
########################################################




Route::group(['prefix' => 'lessons'], function () {
    #Tested
    Route::get('/', 'LessonController@getAll');
    Route::get('/{id}', 'LessonController@getById');

    Route::group(['prefix' => '/{id}/questions'], function () {
        Route::get('/', 'QuestionController@getAllByLessonId');
        Route::post('/', 'QuestionController@create')->middleware('auth');
        Route::put('/{questionId}/accept', 'QuestionController@accept')->middleware('TeacherRole');

        ######################### Answers ########################
        Route::group(['prefix' => '/{questionId}/answers'], function () {
            Route::post('/', 'AnswerController@create')->middleware('auth');
            Route::get('/', 'AnswerController@get');
        });
        ##########################################################
    });

    ######################### Exams ###########################
    Route::group(['prefix' => '/{id}/exams'], function () {
        Route::post('/', 'ExamController@create')->middleware('TeacherRole');
        Route::post('/{examId}/questions', 'ExamController@selectExamQuestions')->middleware('TeacherRole');
        Route::get('/{examId}/start', 'ExamController@start')->middleware('auth');
        Route::post('/{examId}/finish', 'ExamController@finish')->middleware('auth');
        Route::get('/{examId}/result', 'ExamController@result')->middleware('auth');
    });
    ###########################################################
});
Route::get('/test', function () {
    $data = [
        ['hash' => '4iVcWt', 'questionId' => '20'],
        ['hash' => 'hxORjP', 'questionId' => 40]
    ];
    
        StudentResult::create([
            'exam_id' => 2,
            'student_id' => 2,
            'result' => QuestionAnswers::whereIn('question_id', Arr::pluck($data, 'questionId'))
            ->whereIn('hash', Arr::pluck($data, 'hash'))
            ->sum('is_correct')
        ]);
});
