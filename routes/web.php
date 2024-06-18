<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentDetailsController;

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

// Routes for unlocking the screen and logging out
Route::middleware(['auth'])->group(function () {
    Route::post('/unlock-screen', [AuthController::class, 'unlockScreen'])->name('unlock-screen');
    Route::get('/lockscreen', [AuthController::class, 'lockScreen'])->name('lock-screen');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Home route
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/home', function () {
    return view('home');
})->name('home');

// Sign in and sign up routes
Route::get('/sign_in', function () {
    return view('sign_in');
})->name('sign_in');

Route::get('/signup', function () {
    return view('signup');
})->name('signup');

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Admin route
Route::get('/admin', [UserController::class, 'index']);

// Middleware-protected routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// User routes
Route::get('/viewusers', [UserController::class, 'viewUsers'])->name('viewusers');
// Route::get('/viewusers/create', [UserController::class, 'create'])->name('viewusers.create');
Route::post('/viewusers', [UserController::class, 'store'])->name('viewusers.store');
Route::get('/viewusers/{user}', [UserController::class, 'show'])->name('viewusers.show');
Route::get('/viewusers/{user}/edit', [UserController::class, 'edit'])->name('viewusers.edit');
Route::put('/viewusers/{user}', [UserController::class, 'update'])->name('viewusers.update');
Route::delete('/viewusers/{user}', [UserController::class, 'destroy'])->name('viewusers.destroy');

// Chart.js page route
Route::get('/chartjs-page', [UserController::class, 'loadChartJsPage'])->name('chartjs-page');

// PDF generation routes
Route::get('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generate.pdf');
Route::get('/report/user-report', [PDFController::class, 'downloadUserReport'])->name('report.user-report');
Route::get('/export-table-pdf', [PDFController::class, 'exportTableToPDF'])->name('export.table.pdf');

// Routes that need authentication and lock check
Route::middleware(['auth', 'check.locked'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Adjust as needed
    })->name('dashboard');
});

// Payment details routes
Route::middleware(['auth'])->group(function () {
    Route::get('/payment-details', [PaymentDetailsController::class, 'edit'])->name('payment-details.edit');
    Route::put('/payment-details', [PaymentDetailsController::class, 'update'])->name('payment-details.update');
});
