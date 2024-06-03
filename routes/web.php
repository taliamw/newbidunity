<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AuthController;
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


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/sign_in', function () {
    return view('sign_in');
})->name('sign_in');

Route::get('/signup', function () {
    return view('signup');
})->name('signup');



Route::get('/admin', [UserController::class, 'index']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/lock-screen', function () {
    return view('auth.lock-screen');
})->name('lock-screen');

Route::post('/lock-screen', function () {
    session(['screen_locked' => true]);
    return response()->json(['status' => 'locked']);
});

Route::post('/unlock-screen', [AuthController::class, 'unlockScreen'])->name('unlock-screen');
Route::get('/lockscreen', [AuthController::class, 'lockScreen'])->name('lock-screen');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/viewusers', [UserController::class, 'viewUsers'])->name('viewusers');
//Route::get('/viewusers/create', [UserController::class, 'create'])->name('viewusers.create');
Route::post('/viewusers', [UserController::class, 'store'])->name('viewusers.store');
Route::get('/viewusers/{user}', [UserController::class, 'show'])->name('viewusers.show');
Route::get('/viewusers/{user}/edit', [UserController::class, 'edit'])->name('viewusers.edit');
Route::put('/viewusers/{user}', [UserController::class, 'update'])->name('viewusers.update');
Route::delete('/viewusers/{user}', [UserController::class, 'destroy'])->name('viewusers.destroy');

Route::get('/chartjs-page', [UserController::class, 'loadChartJsPage'])->name('chartjs-page');
Route::get('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generate.pdf');
Route::get('/report/user-report', [PDFController::class, 'downloadUserReport'])->name('report.user-report');
Route::get('/export-table-pdf', [PDFController::class, 'exportTableToPDF'])->name('export.table.pdf');

// Routes for unlocking the screen and logging out
Route::middleware(['auth'])->group(function () {
    Route::post('/unlock-screen', [AuthController::class, 'unlockScreen'])->name('unlock-screen');
    Route::get('/lockscreen', [AuthController::class, 'lockScreen'])->name('lock-screen');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Routes that need authentication and lock check
Route::middleware(['auth', 'check.locked'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Adjust as needed
    })->name('dashboard');
});