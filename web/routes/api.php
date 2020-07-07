<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*-----
|------Auth
-----*/
Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');