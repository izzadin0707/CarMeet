<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CreationsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VerificationController;
use App\Models\Creations;

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

//Admin
Route::get('/dashboard/login', [AdminController::class, 'loginForm'])->middleware('auth')->name('dashboard-login-form');
Route::post('/dashboard/login', [AdminController::class, 'login'])->name('dashboard-login');
Route::get('/dashboard/logout', [AdminController::class, 'logout'])->name('dashboard-logout');

Route::get('/dashboard', [AdminController::class, 'index'])->middleware('auth.admin')->name('dashboard');
Route::get('/dashboard/report', [AdminController::class, 'allReport'])->middleware('auth.admin')->name('dashboard-reports');
Route::get('/dashboard/users', [AdminController::class, 'allUser'])->middleware('auth.admin')->name('dashboard-users');
Route::get('/dashboard/creations', [AdminController::class, 'allCreation'])->middleware('auth.admin')->name('dashboard-creations');
Route::get('/dashboard/comments', [AdminController::class, 'allComment'])->middleware('auth.admin')->name('dashboard-comments');

Route::post('/dashboard/change-role', [AdminController::class, 'changeRole'])->middleware('auth.admin')->name('change-role');

Route::post('/dashboard/users-search', [AdminController::class, 'usersSearch'])->middleware('auth.admin')->name('dashboard-users-search');
Route::post('/dashboard/creations-search', [AdminController::class, 'creationsSearch'])->middleware('auth.admin')->name('dashboard-creations-search');
Route::post('/dashboard/comments-search', [AdminController::class, 'commentsSearch'])->middleware('auth.admin')->name('dashboard-comments-search');
Route::post('/dashboard/reports-search', [AdminController::class, 'reportsSearch'])->middleware('auth.admin')->name('dashboard-reports-search');

Route::get('/dashboard/report/read/{id}', [ReportController::class, 'reportRead'])->middleware('auth.admin')->name('dashboard-report-read');
Route::get('/dashboard/report/drop/{id}', [ReportController::class, 'reportDrop'])->middleware('auth.admin')->name('dashboard-report-drop');
Route::get('/dashboard/users/{id}', [ReportController::class, 'usersView'])->middleware('auth.admin')->name('dashboard-users-view');
Route::get('/dashboard/creations/{id}', [ReportController::class, 'creationsView'])->middleware('auth.admin')->name('dashboard-creations-view');
Route::get('/dashboard/comments/{id}', [ReportController::class, 'commentsView'])->middleware('auth.admin')->name('dashboard-comments-view');

Route::get('/dashboard/users/banned/{id}', [ReportController::class, 'bannedUser'])->middleware('auth.admin')->name('dashboard-users-banned');
Route::get('/dashboard/users/unbanned/{id}', [ReportController::class, 'unbannedUser'])->middleware('auth.admin')->name('dashboard-users-unbanned');
Route::get('/dashboard/creations/deleted/{id}', [ReportController::class, 'deletedCreation'])->middleware('auth.admin')->name('dashboard-creations-deleted');
Route::get('/dashboard/comments/deleted/{id}', [ReportController::class, 'deletedComment'])->middleware('auth.admin')->name('dashboard-comments-deleted');

//Users

Route::get('/auth', [AuthController::class, 'index'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('user-login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::post('/resend', [AuthController::class, 'resend'])->name('resend_verify');
// Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

Route::get('/upload', [UploadController::class, 'index'])->middleware('auth');
Route::post('/upload', [UploadController::class, 'upload'])->name('upload');

Route::get('/edit/{creation:creation}', [UploadController::class, 'edit'])->middleware('auth');
Route::post('/update', [UploadController::class, 'update'])->name('update');

Route::get('/remove/{creation:creation}', [UploadController::class, 'remove'])->middleware('auth');
Route::post('/delete', [UploadController::class, 'delete'])->name('delete');

Route::post('/posts/search', [CreationsController::class, 'search'])->name('search');

Route::get('/posts/save', [CreationsController::class, 'showSave'])->name('saves');
Route::post('/save', [CreationsController::class, 'save'])->name('save');
Route::post('/unsave', [CreationsController::class, 'unsave'])->name('unsave');

Route::get('/report/creation/{creation}', [ReportController::class, 'reportCreationView'])->name('report-creation-form');
Route::get('/report/comment/{comment}', [ReportController::class, 'reportCommentView'])->name('report-comment-form');
Route::get('/report/profile/{profile}', [ReportController::class, 'reportProfileView'])->name('report-profile-form');
Route::post('/report/creation', [ReportController::class, 'reportCreation'])->name('report.creation');
Route::post('/report/comment', [ReportController::class, 'reportComment'])->name('report.comment');
Route::post('/report/profile', [ReportController::class, 'reportProfile'])->name('report.profile');

Route::post('/show-comment', [CreationsController::class, 'showComment'])->name('show-comment');
Route::post('/remove-comment', [CreationsController::class, 'removeComment'])->name('remove-comment');
Route::post('/comment', [CreationsController::class, 'comment'])->name('comment');

Route::get('/posts/likes', [CreationsController::class, 'showLike'])->name('likes');
Route::post('/like', [CreationsController::class, 'like'])->name('like');
Route::post('/dislike', [CreationsController::class, 'dislike'])->name('dislike');

Route::post('/photo-profile', [ProfileController::class, 'photoProfile'])->name('photo-profile');
Route::post('/banner', [ProfileController::class, 'banner'])->name('banner');
Route::post('/change-name', [ProfileController::class, 'changeName'])->name('change-name');
Route::post('/background-color', [ProfileController::class, 'backgroundColor'])->name('background-color');
Route::post('/font-color', [ProfileController::class, 'fontColor'])->name('font-color');
Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
Route::post('/reset-theme', [ProfileController::class, 'resetTheme'])->name('reset-theme');

Route::get('/profile/setting', [ProfileController::class, 'profileSetting'])->middleware('auth')->name('profile-setting');
Route::get('/profile/{username}', [ProfileController::class, 'profile']);
Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');

Route::get('/category/{category:slug}', [CreationsController::class, 'category'])->middleware('auth');;
Route::get('/post/{creation:creation}', [CreationsController::class, 'post']);
Route::get('/posts', [CreationsController::class, 'allPost']);

Route::get('/', [CreationsController::class, 'index'])->middleware('auth')->name('home');



