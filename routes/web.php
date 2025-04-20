<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannedController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CreationsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/auth', [AuthController::class, 'index'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('user-login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/upload', [UploadController::class, 'upload'])->middleware('auth')->name('upload');
Route::post('/delete', [UploadController::class, 'delete'])->middleware('auth')->name('delete');

Route::get('/posts/save', [CreationsController::class, 'showSave'])->middleware('auth')->name('saves');
Route::post('/save', [CreationsController::class, 'save'])->middleware('auth')->name('save');
Route::post('/unsave', [CreationsController::class, 'unsave'])->middleware('auth')->name('unsave');

Route::get('/report/{type?}', [ReportController::class, 'index'])->middleware('auth')->name('report');
Route::post('/storereport', [ReportController::class, 'storeReport'])->middleware('auth')->name('store-report');
Route::post('/deletereport', [ReportController::class, 'deleteReport'])->middleware('auth')->name('delete-report');

Route::post('/ban-user', [BannedController::class, 'banUser'])->middleware('auth')->name('ban-user');
Route::post('/unban-user', [BannedController::class, 'unbanUser'])->middleware('auth')->name('unban-user');

Route::post('/remove-comment', [CreationsController::class, 'removeComment'])->middleware('auth')->name('remove-comment');
Route::post('/comment', [CreationsController::class, 'comment'])->middleware('auth')->name('comment');

Route::get('/posts/likes', [CreationsController::class, 'showLike'])->middleware('auth')->name('likes');
Route::post('/like', [CreationsController::class, 'like'])->middleware('auth')->name('like');
Route::post('/dislike', [CreationsController::class, 'dislike'])->middleware('auth')->name('dislike');

Route::post('/profileupdate', [ProfileController::class, 'profileUpdate'])->middleware('auth')->name('profile-update');
Route::post('/change-password', [ProfileController::class, 'changePassword'])->middleware('auth')->name('change-password');

Route::get('/profile/{username?}/{tab?}', [ProfileController::class, 'index'])->middleware('auth')->name('profile');

Route::get('/category/{category:slug}', [CreationsController::class, 'category'])->middleware('auth');
Route::get('/post/{creation:creation}', [CreationsController::class, 'post'])->middleware('auth');
Route::get('/posts', [CreationsController::class, 'allPost'])->middleware('auth');

Route::get('/event', [EventController::class, 'index'])->middleware('auth')->name('event');
Route::get('/event/form/{id?}', [EventController::class, 'form'])->middleware('auth')->name('event-form');
Route::post('/event/upload', [EventController::class, 'upload'])->middleware('auth')->name('event-upload');
Route::post('/event/update', [EventController::class, 'update'])->middleware('auth')->name('event-update');
Route::get('/event/delete/{id}', [EventController::class, 'delete'])->middleware('auth')->name('event-delete');
Route::get('/event/{id}', [EventController::class, 'detail'])->middleware('auth')->name('event-detail');

Route::get('/{category?}', [CreationsController::class, 'index'])->middleware('auth')->name('home');

Route::get('/posting/{category}/{id}', [CreationsController::class, 'detail'])->middleware('auth')->name('post-detail');