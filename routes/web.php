<?php
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\OrderController;
use \App\Http\Controllers\EventController;
use \App\Http\Controllers\GalleryController;
use \App\Http\Controllers\PictureController;
use \App\Http\Controllers\ApplicationController;
use \App\Http\Controllers\EventApplicationController;

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
Route::get('/', fn() => view('index'))->name('index');

Route::get('/over-ons', fn() => view('about'))->name('about');

Route::get('/privacybeleid', fn() => view('legal.privacy'))->name('privacy');
Route::get('/disclaimer', fn() => view('legal.disclaimer'))->name('disclaimer');

Route::get('/leden', [UserController::class, 'index'])->name('users.index');
Route::delete('/leden/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/leden/{user}/bewerken', [UserController::class, 'edit'])->name('users.edit');
Route::patch('/leden/{user}/bewerken', [UserController::class, 'update'])->name('users.update');
Route::get('/leden/aanmaken', [UserController::class, 'create'])->name('users.create');
Route::post('/leden', [UserController::class, 'store'])->name('users.store');

Route::get('/merchandise', [ProductController::class, 'index'])->name('products.index');
Route::get('/merchandise/aanmaken', [ProductController::class, 'create'])->name('products.create');
Route::post('/merchandise', [ProductController::class, 'store'])->name('products.store');
Route::get('/merchandise/{product}/bewerken', [ProductController::class, 'edit'])->name('products.edit');
Route::patch('/merchandise/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/merchandise/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::post('/bestellingen', [OrderController::class, 'store'])->name('orders.store');
Route::get('/bestellingen', [OrderController::class, 'index'])->name('orders.index');
Route::get('/bestellingen/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::patch('/bestellingen/{order}', [OrderController::class, 'update'])->name('orders.update');

Route::get('/evenementen', [EventController::class, 'index'])->name('events.index');
Route::get('/evenementen/aanmaken', [EventController::class, 'create'])->name('events.create');
Route::post('/evenementen', [EventController::class, 'store'])->name('events.store');
Route::delete('/evenementen/{event}', [EventController::class, 'destroy'])->name('events.destroy');
Route::get('/evenementen/{event}/bewerken', [EventController::class, 'edit'])->name('events.edit');
Route::patch('/evenementen/{event}', [EventController::class, 'update'])->name('events.update');

Route::get('/gallerij', [GalleryController::class, 'index'])->name('galleries.index');
Route::post('/gallerij', [GalleryController::class, 'store'])->name('galleries.store');
Route::get('/gallerij/{gallery}', [GalleryController::class, 'show'])->name('galleries.show');
Route::get('/gallerij/{gallery}/bewerken', [GalleryController::class, 'edit'])->name('galleries.edit');
Route::patch('/gallerij/{gallery}', [GalleryController::class, 'update'])->name('galleries.update');
Route::delete('/gallerij/{gallery}', [GalleryController::class, 'destroy'])->name('galleries.destroy');

Route::delete('/pictures/{picture}', [PictureController::class, 'destroy'])->name('pictures.destroy');
Route::patch('/pictures/{picture}', [PictureController::class, 'update'])->name('pictures.update');

Route::get('/aanmelden', [ApplicationController::class, 'create'])->name('applications.create');
Route::get('/aanmeldingen', [ApplicationController::class, 'index'])->name('applications.index');
Route::get('/aanmeldingen/{application}', [ApplicationController::class, 'show'])->name('applications.show');
Route::post('/aanmelden', [ApplicationController::class, 'store'])->name('applications.store');

Route::post('/evenementen/{event}/aanmelden', [EventApplicationController::class, 'store'])
    ->name('eventApplications.store');
