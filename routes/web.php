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
Route::get('/leden', 'UserController@index')->name('users.index');
Route::delete('/leden/{user}', 'UserController@destroy')->name('users.destroy');
Route::get('/leden/{user}/bewerken', 'UserController@edit')->name('users.edit');
Route::patch('/leden/{user}/bewerken', 'UserController@update')->name('users.update');
Route::post('/leden/activeer', 'UserController@activate')->name('users.activate');
Route::get('/leden/aanmaken', 'UserController@create')->name('users.create');
Route::post('/leden', 'UserController@store')->name('users.store');
Route::get('/storage/profile-pictures/{profile_picture}', 'UserController@picture');

// Passwords
Route::get('/change-password', 'ChangePasswordController@index')->name('change-password-index');
Route::post('/change-password', 'ChangePasswordController@ChangePassword')->name('change-password');

// Products
Route::get('/merchandise', 'ProductController@index')->name('products.index');
Route::get('/merchandise/aanmaken', 'ProductController@create')->name('products.create');
Route::post('/merchandise', 'ProductController@store')->name('products.store');
Route::get('/merchandise/{product}/bewerken', 'ProductController@edit')->name('products.edit');
Route::patch('/merchandise/{product}', 'ProductController@update')->name('products.update');
Route::delete('/merchandise/{product}', 'ProductController@destroy')->name('products.destroy');
Route::get('/storage/product-pictures/{product_picture}', 'ProductController@picture');

// Orders
Route::post('/bestellingen', 'OrderController@store')->name('orders.store');
Route::get('/bestellingen', 'OrderController@index')->name('orders.index');
Route::get('/bestellingen/{order}', 'OrderController@show')->name('orders.show');
Route::patch('/bestellingen/{order}', 'OrderController@update')->name('orders.update');

// Events
Route::get('/evenementen', 'EventController@index')->name('events.index');
Route::get('/evenementen/aanmaken', 'EventController@create')->name('events.create');
Route::post('/evenementen', 'EventController@store')->name('events.store');

Route::get('/gallerij', 'GalleryController@index')->name('galleries.index');
Route::get('/gallerij/aanmaken', 'GalleryController@create')->name('galleries.create');
Route::post('/gallerij/aanmaken', 'GalleryController@store')->name('galleries.store');
Route::get('/gallerij/{gallery}', 'GalleryController@show')->name('galleries.show');
Route::patch('/gallerij/{gallery}', 'GalleryController@update')->name('galleries.update');
Route::delete('/gallerij/{gallery}', 'GalleryController@destroy')->name('galleries.destroy');
Route::get('/storage/galleries/{gallery}/{picture}', 'GalleryController@picture');

// Route::group(['middleware' => ['auth']], function () {
//     Route::get('/storage/product-pictures/{picture}', function ($file) {
//      //This method will look for the file and get it from drive
//     $path = storage_path('app/uploads/product-pictures/' . $file);
//     try {
//         $file = File::get($path);
//         $type = File::mimeType($path);
//         $response = Response::make($file, 200);
//         $response->header("Content-Type", $type);
//         return $response;
//     } catch (FileNotFoundException $exception) {
//         abort(404);
//     }
//     });
// });
