<?php

use Illuminate\Support\Facades\Route;



Route::post('register', "Auth\AuthController@register");
Route::get('test',function(){
    return 's';
});
