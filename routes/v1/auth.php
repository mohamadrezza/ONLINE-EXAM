<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware('jwt.verify')->group(function () {
    Route::get('/me', 'Auth\AuthController@me');
});
