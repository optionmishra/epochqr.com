<?php

use Illuminate\Support\Facades\Auth;

//
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrController;
use Illuminate\Support\Facades\Artisan;

// Admin
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClickController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\TransactionController;

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

// Auth
// Auth::routes();

// Admin
Route::prefix('admin')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard.index');
    Route::get('/click', [TransactionController::class, 'index'])->name('admin.click.index');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/block-user/{user}', [UserController::class, 'block'])->name('admin.user.block');
    Route::get('/unblock-user/{user}', [UserController::class, 'unblock'])->name('admin.user.unblock');
});

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Registration
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Login
// Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/login', [HomeController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'store'])->name('login');

// Admin Login
Route::get('/adminlogin', [LoginController::class, 'form'])->name('admin.login');
Route::post('/adminlogin', [LoginController::class, 'formProcess'])->name('admin.login.formProcess');
Route::post('/adminlogout', [LoginController::class, 'logout'])->name('logout');

// Projects
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::post('/projects/add', [ProjectController::class, 'store'])->name('projects.add');
Route::get('/delete-project/{project}', [ProjectController::class, 'destroy'])->name('projects.delete');
Route::get('/archive-project/{project}', [ProjectController::class, 'archive'])->name('projects.archive');
Route::get('/unarchive-project/{project}', [ProjectController::class, 'unarchive'])->name('projects.unarchive');

// QR Codes
Route::get('/projects/{project:id}/qr-codes/', [QrController::class, 'index'])->name('qr-codes.index');
Route::post('/projects/{project}/qr-code/add', [QrController::class, 'formProcess'])->name('qr-code.formProcess');
Route::post('/projects/{project}/qr-code/multiple-add', [QrController::class, 'multiple_store'])->name('create-multiple-qr');
Route::post('/multiple-qr-download', [QrController::class, 'multiple_download'])->name('download-multiple-qr');
Route::post('/multiple-qr-archive', [QrController::class, 'multiple_archive'])->name('archive-multiple-qr');
Route::post('/update-qr/{campaign}', [QrController::class, 'update'])->name('qr-code.update');
Route::get('/delete-qr/{campaign}', [QrController::class, 'destroy'])->name('qr-code.delete');
Route::get('/archive-qr/{campaign}', [QrController::class, 'archive'])->name('qr-code.archive');
Route::get('/unarchive-qr/{campaign}', [QrController::class, 'unarchive'])->name('qr-code.unarchive');

// Route::get('/projects/{project}/qr-code/add', [QrController::class, 'form'])->name('qr-code.add');
//Clear View cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return 'Storage link has been created.';
});

//
Route::get('/{str}', [ClickController::class, 'globalClick'])->name('click.redirect');
// Route::get('/linkstorage', function () {
    // Artisan::call('storage:link');
// });
