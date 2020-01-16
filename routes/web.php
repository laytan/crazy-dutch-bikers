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

// Products
Route::get('/merchandise', 'ProductController@index')->name('products.index');
Route::get('/merchandise/aanmaken', 'ProductController@create')->name('products.create');
Route::post('/merchandise', 'ProductController@store')->name('products.store');
Route::get('/merchandise/{product}/bewerken', 'ProductController@edit')->name('products.edit');
Route::patch('/merchandise/{product}', 'ProductController@update')->name('products.update');
Route::delete('/merchandise/{product}', 'ProductController@destroy')->name('products.destroy');

// Orders
Route::post('/bestellingen', 'OrderController@store')->name('orders.store');
Route::get('/bestellingen', 'OrderController@index')->name('orders.index');
Route::get('/bestellingen/{order}', 'OrderController@show')->name('orders.show');
Route::patch('/bestellingen/{order}', 'OrderController@update')->name('orders.update');
Route::delete('/bestellingen/{order}', 'OrderController@destroy')->name('orders.destroy');