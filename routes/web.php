<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\VerificationRequestController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\VouchersCategoriesController;
use Illuminate\Support\Facades\Route;

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
// FrontEnd
Route::get('/', [FrontEndController::class, 'home'])->name('homePage');
Route::get('/about', [FrontEndController::class, 'about'])->name('aboutPage');
Route::get('/faqs', [FrontEndController::class, 'faqs'])->name('faqsPage');
Route::get('/contact', [FrontEndController::class, 'contact'])->name('contactPage');
Route::get('/track-order', [FrontEndController::class, 'trackOrder'])->name('trackOrderPage');
Route::get('/privacy', [FrontEndController::class, 'privacy'])->name('privacyPage');
Route::get('/terms', [FrontEndController::class, 'terms'])->name('termsPage');
Route::get('/start-selling', [FrontEndController::class, 'startSelling'])->name('startSellingPage');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/admin/profile', [ProfileController::class, 'updateAdmin'])->name('admin.profile.update');
    Route::patch('/client/profile', [ProfileController::class, 'updateClient'])->name('client.profile.update');
    Route::patch('/seller/profile', [ProfileController::class, 'updateSeller'])->name('seller.profile.update');
    Route::patch('/seller/bank', [ProfileController::class, 'updateBankInfo'])->name('seller.bank.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::post('/contact', [FrontEndController::class, 'sendEmail'])->name('contact.send');
Route::get('/api/cities/{stateId}', [CityController::class, 'getCities']);
// Client
Route::middleware(['auth'])->prefix('client')->name('client.')->group(function () {
    Route::get('home', [ClientController::class, 'home'])->name('home');
    Route::get('profile', [ClientController::class, 'profile'])
        ->name('profile');
    Route::get('balance', [ClientController::class, 'balance'])->name('balance');
    Route::post('balance/add', [ClientController::class, 'topUp'])->name('topup');
    // Route::get('shopping', ClientController::class, 'shopping')->name('shopping');
    // Route::get('orders', ClientController::class, 'orders')->name('orders');
    // Route::get('stores', ClientController::class, 'stores')->name('stores');
    // Route::get('tickets', ClientController::class, 'tickets')->name('tickets');
    // Route::get('tickets', ClientController::class, 'tickets')->name('tickets');
    // Route::get('profile', ClientController::class, 'profile')->name('profile');
});

// Seller
Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    // Profile
    Route::get('home', [SellerController::class, 'home'])->name('home');
    Route::get('profile', [SellerController::class, 'profile'])
        ->name('profile');
    // Balance
    Route::get('balance', [SellerController::class, 'balance'])->name('balance');
    Route::post('balance/add', [SellerController::class, 'topUp'])->name('topup');
    // Verification
    Route::get('requests/verification', [VerificationRequestController::class, 'index'])->name('verification-requests.index');
    Route::get('requests/verification/create', [VerificationRequestController::class, 'create'])->name('verification-requests.create');
    Route::get('requests/verification/show/{id}', [VerificationRequestController::class, 'show'])->name('verification-requests.show');
    Route::post('requests/verification', [VerificationRequestController::class, 'store'])->name('verification-requests.store');
});

// Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('home', [AdminController::class, 'home'])->name('home');
    Route::get('profile', [AdminController::class, 'profile'])
        ->name('profile');
    Route::get('brands', [BrandsController::class, 'index'])->name('brands.index');
    Route::get('brand/create', [BrandsController::class, 'create'])->name('brands.create');
    Route::get('brand/edit/{id}', [BrandsController::class, 'edit'])->name('brands.edit');
    Route::patch('brand/update/{id}', [BrandsController::class, 'update'])->name('brands.update');
    Route::get('brand/{id}', [BrandsController::class, 'show'])->name('brands.show');
    Route::post('brand', [BrandsController::class, 'store'])->name('brands.store');
    Route::delete('brand/{id}', [BrandsController::class, 'destroy'])->name('brands.destroy');
    Route::get('brands/filter', [BrandsController::class, 'filter'])->name('brands.filter');
    // Vouchers Categories
    Route::get('vouchers-categories', [VouchersCategoriesController::class, 'index'])->name('vouchers-categories.index');
    Route::get('vouchers-categories/filter', [VouchersCategoriesController::class, 'filter'])->name('vouchers-categories.filter');
    Route::post('vouchers-categories', [VouchersCategoriesController::class, 'store'])->name('vouchers-categories.store');
    Route::patch('vouchers-categories/{id}', [VouchersCategoriesController::class, 'update'])->name('vouchers-categories.update');
    Route::delete('vouchers-categories/{id}', [VouchersCategoriesController::class, 'destroy'])->name('vouchers-categories.destroy');
    //  Vouchers
    Route::get('vouchers/', [VoucherController::class, 'index'])->name('vouchers.index');
    Route::get('vouchers/filter', [VoucherController::class, 'filter'])->name('vouchers.filter');
    Route::get('vouchers/create', [VoucherController::class, 'create'])->name('vouchers.create');
    // Route::get('vouchers/check', [VoucherController::class, 'check'])->name('vouchers.check');
    // Route::post('vouchers/show', [VoucherController::class, 'show'])->name('vouchers.show');
    Route::post('vouchers/store', [VoucherController::class, 'store'])->name('vouchers.store');
    // Sectors
    Route::get('sectors', [SectorController::class, 'index'])->name('sectors.index');
    Route::get('sectors/filter', [SectorController::class, 'filter'])->name('sectors.filter');
    Route::post('sectors', [SectorController::class, 'store'])->name('sectors.store');
    Route::delete('sectors/{id}', [SectorController::class, 'destroy'])->name('sectors.destroy');
    Route::patch('sectors/update/{id}', [SectorController::class, 'update'])->name('sectors.update');
    // Fees
    Route::get('fees', [FeeController::class, 'index'])->name('fees.index');
    Route::post('fees', [FeeController::class, 'store'])->name('fees.store');
    Route::patch('fees/update/{id}', [FeeController::class, 'update'])->name('fees.update');
    // Verification
    Route::get('requests/verification', [VerificationRequestController::class, 'AdminIndex'])->name('verification-requests.index');
    Route::get('requests/verification/filter', [VerificationRequestController::class, 'filter'])->name('verification-requests.filter');
    Route::get('requests/verification/show/{id}', [VerificationRequestController::class, 'adminShow'])->name('verification-requests.show');
    Route::patch('requests/verification/approve/{id}', [VerificationRequestController::class, 'approve'])->name('verification-requests.approve');
    Route::patch('requests/verification/reject/{id}', [VerificationRequestController::class, 'reject'])->name('verification-requests.reject');
});
