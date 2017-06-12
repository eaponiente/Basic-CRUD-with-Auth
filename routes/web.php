<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Route::any('login', 'LoginController@login')->name('user_login');

Route::post('register', 'LoginController@register')->name('user_register');

Route::get('logout', 'LoginController@logout')->name('user_logout');

Route::group(['middleware' => 'auth.user'], function() {
    Route::resource('users', 'UsersController');
});

