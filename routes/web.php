<?php

use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::post('/contact', [FrontEndController::class, 'sendEmail'])->name('contact.send');
