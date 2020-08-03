<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*-----
|------Auth
-----*/
Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

/*-----
|------User
-----*/
Route::get('/user', fn() => Auth::user())->name('user');
Route::get('/users/{id}', 'UserController@show')->name('user.show');

/*-----
|------Post
-----*/
Route::get('/posts', 'PostController@index')->name('post.index');
Route::get('/posts/{id}', 'PostController@show')->name('post.show');
Route::post('/posts', 'PostController@create')->name('post.create');

/*-----
|------Profile
-----*/
Route::post('/profiles', 'ProfileController@create')->name('profile.create');

/*-----
|------FollowUser
-----*/
Route::post('/follow/{id}', 'FollowUserController@store')->name('follow');
Route::delete('/unfollow/{id}', 'FollowUserController@destroy')->name('unfollow');
Route::get('/following/{id}', 'FollowUserController@followIndex')->name('follow.index');
Route::get('/follower/{id}' , 'FollowUserController@followerIndex')->name('follower.index');
Route::get('/timeline', 'FollowUserController@timeLine')->name('timeline');
