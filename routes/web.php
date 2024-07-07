<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminListingController;
use App\Http\Controllers\ReportController;

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

//routes that require logged in and verified email
Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/teams/sendJoinRequest', [TeamController::class, 'sendJoinRequest'])->name('teams.sendJoinRequest');
    Route::get('/teams/{team}/admit/{user}', [TeamController::class, 'admit'])->name('teams.admit');


    Route::get('/sign_in', function () {
        return view('sign_in');
    })->name('sign_in');
    
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    
    Route::get('/payment-details', [PaymentDetailsController::class, 'edit'])->name('payment-details.edit');
    Route::put('/payment-details', [PaymentDetailsController::class, 'update'])->name('payment-details.update');
    
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::get('/teams/create', [TeamController::class, 'join'])->name('teams.join');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');

    Route::post('/contributions', [ContributionController::class, 'store'])->name('contributions.store');
    
    // Route::get('/products', [ProductController::class, 'index'])->name('products');
    // Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    Route::get('/test', function () {
        return 'Route is working';
    });
    Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment');
    Route::post('/handle-payment', [PaymentController::class, 'handlePayment'])->name('payment.handle');

    Route::middleware('can:admin')->group(function () {
        Route::get('/admin/listings', [AdminListingController::class, 'index'])->name('listing_management');
        Route::put('/admin/listings/{product}/approve', [AdminListingController::class, 'approve'])->name('admin.listings.approve');
        Route::put('/admin/listings/{product}/reject', [AdminListingController::class, 'reject'])->name('admin.listings.reject');
    });
});

//public routes
Route::get('/', function () {
    return view('home');
    })->name('home');

Route::get('/signup', function () {
    return view('signup');
})->name('signup');

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
    Route::post('/products/{product}/bid', [ProductController::class, 'placeBid'])->name('products.placeBid');

});
// Route::get('/products', [ProductController::class, 'index'])->name('products');
// Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

 // Product Routes
 Route::get('/products', [ProductController::class, 'index'])->name('products.index');
 Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
 Route::get('/products/{product}/winner', [ProductController::class, 'determineWinner'])->name('products.determineWinner');
 Route::delete('/products/{bid}/remove-bid', 'ProductController@removeBid')->name('products.removeBid');
 Route::delete('/bids/{bid}', [ProductController::class, 'removeBid'])->name('products.removeBid');
 Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove/{product}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::resource('products', ProductController::class);
Route::post('/bids/{bid}/approve', [ProductController::class, 'approveBid'])->name('bids.approve');
Route::post('/bids/{bid}/deny', [ProductController::class, 'denyBid'])->name('bids.deny');


Route::get('/test-payment', function () {
    $payment = new \App\Models\Payment();
    $payment->user_id = 9; // Replace with a valid user ID
    $payment->amount = 100.00;
    $payment->stripe_payment_intent_id = 'test_intent_id';
    $payment->status = 'succeeded';
    $payment->save();

    return 'Payment saved successfully!';
});

Route::get('allocation/report/{team}', [ReportController::class, 'generate'])->name('allocation.report.pdf');





