<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentDetailsController;
use App\Http\Controllers\ProductController;
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



Route::get('/signup', function () {
    return view('signup');
})->name('signup');

// Route::middleware(['screen_locked'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');    // Add other routes that need to be protected
// });

// Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/admin', [UserController::class, 'index']);


Route::get('/lock-screen', function () {
    return view('auth.lock-screen');
})->name('lock-screen');

Route::post('/lock-screen', function () {
    session(['screen_locked' => true]);
    return response()->json(['status' => 'locked']);
});
Route::get('/dashboard', function () {
    if (session('screen_locked', false)) {
        return redirect()->route('lock-screen');
    }

    // Proceed to dashboard if screen is unlocked
    return view('dashboard');
})->middleware('auth')->name('dashboard');
Route::post('/unlock-screen', [AuthController::class, 'unlockScreen'])->name('unlock-screen');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/viewusers', [UserController::class, 'viewUsers'])->name('viewusers');
Route::get('/viewusers/create', [UserController::class, 'create'])->name('viewusers.create');
Route::post('/viewusers', [UserController::class, 'store'])->name('viewusers.store');
Route::get('/viewusers/{user}', [UserController::class, 'show'])->name('viewusers.show');
Route::get('/viewusers/{user}/edit', [UserController::class, 'edit'])->name('viewusers.edit');
Route::put('/viewusers/{user}', [UserController::class, 'update'])->name('viewusers.update');
Route::delete('/viewusers/{user}', [UserController::class, 'destroy'])->name('viewusers.destroy');

Route::get('/chartjs-page', [UserController::class, 'loadChartJsPage'])->name('chartjs-page');
Route::get('/add_admin', [UserController::class, 'add_admin'])->name('add_admin');
Route::get('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generate.pdf');
Route::get('/report/user-report', [PDFController::class, 'downloadUserReport'])->name('report.user-report');
Route::get('/export-table-pdf', [PDFController::class, 'exportTableToPDF'])->name('export.table.pdf');
Route::get('/api/users-admins-count', [UserController::class, 'getUsersAndAdminsCount']);


// // Routes that need authentication and lock check
// Route::middleware(['auth', 'check.locked'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard'); // Adjust as needed
//     })->name('dashboard');
// });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/sign_in', function () {
        return view('sign_in');
    })->name('sign_in');
    Route::get('/payment-details', [PaymentDetailsController::class, 'edit'])->name('payment-details.edit');
    Route::put('/payment-details', [PaymentDetailsController::class, 'update'])->name('payment-details.update');
});
// Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');