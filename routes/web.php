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

// All auth routes except registration, reset and verify
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

// Homepage
Route::get('/', function () {
    return view('index');
})->name('index');

// Leden
Route::get('/leden', 'UserController@index')->name('users-index');
Route::post('/leden/verwijder', 'UserController@destroy')->name('users-destroy');
Route::get('/leden/{id}/bewerken', 'UserController@edit')->where('id', '[0-9]+')->name('users-edit');
Route::patch('/leden/{id}/bewerken', 'UserController@update')->where('id', '[0-9]+')->name('users-update');
Route::post('/leden/activeer', 'UserController@activate')->name('users-activate');
Route::get('/leden/aanmaken', 'UserController@create')->name('users-create');
Route::post('/leden', 'UserController@store')->name('users-store');

// Passwords
Route::get('/change-password', 'ChangePasswordController@index')->name('change-password-index');
Route::post('/change-password', 'ChangePasswordController@changePassword')->name('change-password');