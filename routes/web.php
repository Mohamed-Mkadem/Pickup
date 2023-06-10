<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontEndController;

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/admin/profile', [ProfileController::class, 'updateAdmin'])->name('admin.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::post('/contact', [FrontEndController::class, 'sendEmail'])->name('contact.send');
Route::get('/api/cities/{stateId}', [CityController::class,'getCities']);

Route::middleware(['auth', 'verified'])->prefix('client')->name('client.')->group(function (){
    Route::get('home', [ClientController::class, 'home'])->name('home');
    // Route::get('shopping', ClientController::class, 'shopping')->name('shopping');
    // Route::get('orders', ClientController::class, 'orders')->name('orders');
    // Route::get('stores', ClientController::class, 'stores')->name('stores');
    // Route::get('tickets', ClientController::class, 'tickets')->name('tickets');
    // Route::get('tickets', ClientController::class, 'tickets')->name('tickets');
    // Route::get('profile', ClientController::class, 'profile')->name('profile');
});
Route::middleware(['auth', 'verified'])->prefix('seller')->name('seller.')->group(function (){
    Route::get('home',[SellerController::class, 'home'])->name('home');

});
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function (){
    Route::get('home', [AdminController::class, 'home'])->name('home');
    Route::get('profile', [AdminController::class, 'profile'])
    ->name('profile');
});