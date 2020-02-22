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

Route::get('/leden', 'UserController@index')->name('users.index');
Route::delete('/leden/{user}', 'UserController@destroy')->name('users.destroy');
Route::get('/leden/{user}/bewerken', 'UserController@edit')->name('users.edit');
Route::patch('/leden/{user}/bewerken', 'UserController@update')->name('users.update');
Route::get('/leden/aanmaken', 'UserController@create')->name('users.create');
Route::post('/leden', 'UserController@store')->name('users.store');

Route::get('/change-password', 'ChangePasswordController@index');
Route::patch('/change-password', 'ChangePasswordController@update')->name('change-password');

Route::get('/merchandise', 'ProductController@index')->name('products.index');
Route::get('/merchandise/aanmaken', 'ProductController@create')->name('products.create');
Route::post('/merchandise', 'ProductController@store')->name('products.store');
Route::get('/merchandise/{product}/bewerken', 'ProductController@edit')->name('products.edit');
Route::patch('/merchandise/{product}', 'ProductController@update')->name('products.update');
Route::delete('/merchandise/{product}', 'ProductController@destroy')->name('products.destroy');

Route::post('/bestellingen', 'OrderController@store')->name('orders.store');
Route::get('/bestellingen', 'OrderController@index')->name('orders.index');
Route::get('/bestellingen/{order}', 'OrderController@show')->name('orders.show');
Route::patch('/bestellingen/{order}', 'OrderController@update')->name('orders.update');

Route::get('/evenementen', 'EventController@index')->name('events.index');
Route::get('/evenementen/aanmaken', 'EventController@create')->name('events.create');
Route::post('/evenementen', 'EventController@store')->name('events.store');

Route::get('/gallerij', 'GalleryController@index')->name('galleries.index');
Route::get('/gallerij/aanmaken', 'GalleryController@create')->name('galleries.create');
Route::post('/gallerij', 'GalleryController@store')->name('galleries.store');
Route::get('/gallerij/{gallery}', 'GalleryController@show')->name('galleries.show');
Route::get('/gallerij/{gallery}/bewerken', 'GalleryController@edit')->name('galleries.edit');
Route::patch('/gallerij/{gallery}', 'GalleryController@update')->name('galleries.update');
Route::delete('/gallerij/{gallery}', 'GalleryController@destroy')->name('galleries.destroy');

Route::delete('/pictures/{picture}', 'PictureController@destroy')->name('pictures.destroy');

Route::get('/aanmelden', 'ApplicationController@create')->name('applications.create');
Route::get('/aanmeldingen', 'ApplicationController@index')->name('applications.index');
Route::get('/aanmeldingen/{application}', 'ApplicationController@show')->name('applications.show');
Route::post('/aanmelden', 'ApplicationController@store')->name('applications.store');
