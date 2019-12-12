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

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/leden-toevoegen', 'AdminController@add_users')->name('leden-toevoegen');
Route::post('/leden-toevoegen', 'AdminController@register');
Route::get('/leden', 'AdminController@viewUsers')->name('view-users');
Route::post('/leden/verwijder', 'UserController@trash');
Route::post('/leden/activeer', 'UserController@activate');

// Guest routes
Route::get('/', function () {
    return view('welcome');
});

// Logged in routes
Route::group(['middleware' => ['role:member']], function() {
    Route::get('/change-password', 'ChangePasswordController@view')->name('change-password');
    Route::post('/change-password', 'ChangePasswordController@changePassword');
});
