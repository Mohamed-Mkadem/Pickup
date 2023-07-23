<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentRequestController;
use App\Http\Controllers\PickRequestController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransferController;
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
Route::get('/track-order/order', [OrderController::class, 'getOrder'])->name('order.get');
Route::get('/privacy', [FrontEndController::class, 'privacy'])->name('privacyPage');
Route::get('/terms', [FrontEndController::class, 'terms'])->name('termsPage');
Route::get('/start-selling', [FrontEndController::class, 'startSelling'])->name('startSellingPage');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/admin/profile', [ProfileController::class, 'updateAdmin'])->name('admin.profile.update');
    Route::patch('/client/profile', [ProfileController::class, 'updateClient'])->name('client.profile.update');
    Route::patch('/seller/profile', [ProfileController::class, 'updateSeller'])->name('seller.profile.update');
    Route::patch('/seller/bank', [ProfileController::class, 'updateBankInfo'])->name('seller.bank.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('profile/banned', [ProfileController::class, 'banned'])
    ->middleware('banned')
    ->name('profile.banned');

require __DIR__ . '/auth.php';

Route::post('/contact', [FrontEndController::class, 'sendEmail'])->name('contact.send');
Route::get('/api/cities/{stateId}', [CityController::class, 'getCities']);
// Client
Route::middleware(['auth', 'active', 'isClient'])->prefix('client')->name('client.')->group(function () {
    Route::get('home', [ClientController::class, 'home'])->name('home');
    Route::get('profile', [ClientController::class, 'profile'])
        ->name('profile');
    Route::get('balance', [ClientController::class, 'balance'])->name('balance');
    Route::post('balance/add', [ClientController::class, 'topUp'])->name('topup');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/filter', [NotificationController::class, 'filter'])->name('notifications.filter');
    Route::get('/getNotifications', [NotificationController::class, 'getNotifications']);
    // Stores
    Route::get('stores', [StoreController::class, 'clientIndex'])->name('stores.index');
    Route::get('stores/filter', [StoreController::class, 'clientFilter'])->name('stores.filter');
    // Show Stores
    Route::get('store/{username}/home', [StoreController::class, 'clientHome'])->name('store.home');
    // Route::get('store/{username}/reviews', [StoreController::class, 'clientReviews'])->name('store.reviews');
    Route::get('store/{username}/reviews', [StoreController::class, 'reviews'])->name('store.reviews');
    Route::get('store/{username}/cart', [StoreController::class, 'cart'])->name('store.cart');
    Route::get('store/{username}/checkout', [StoreController::class, 'checkout'])->name('store.checkout');
    Route::get('store/{username}/orders', [StoreController::class, 'clientOrders'])->name('store.orders');
    Route::get('store/{username}/order/{id}', [StoreController::class, 'clientOrder'])->name('store.order');
    Route::get('store/{username}/products', [StoreController::class, 'clientProducts'])->name('store.products');
    Route::get('store/{username}/products/filter', [StoreController::class, 'clientProductsFilter'])->name('store.products.filter');
    Route::get('store/{username}/product/{id}', [StoreController::class, 'clientProduct'])->name('store.product');
// Follows
    // Route::post('follow/{id}', [FollowController::class, 'follow'])->name('store.follow');
    Route::delete('unfollow/{store}', [FollowController::class, 'unfollow'])->name('store.unfollow');

    Route::post('follow/{store}', [FollowController::class, 'follow'])->name('store.follow');

    // Shopping
    Route::get('shopping', [ShoppingController::class, 'shopping'])->name('shopping');
    Route::get('shopping/filter', [ShoppingController::class, 'filter'])->name('shopping.filter');

    // Cart
    Route::post('product/add/{storeID}', [CartController::class, 'addProduct'])->name('cart.add');
    Route::patch('cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::patch('cart/empty/{id}', [CartController::class, 'empty'])->name('cart.empty');

    // Orders
    Route::post('order/place/{storeID}', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('orders', [OrderController::class, 'clientIndex'])->name('orders.index');
    Route::get('orders/filter', [OrderController::class, 'filter'])->name('orders.filter');
    Route::get('order/details/{id}', [OrderController::class, 'clientShow'])->name('order.show');
    Route::patch('order/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');

    // Pick Requests
    Route::patch('pick-request/{id}/refuse', [PickRequestController::class, 'refuse'])->name('pickRequest.refuse');
    Route::patch('pick-request/{id}/confirm', [PickRequestController::class, 'confirm'])->name('pickRequest.confirm');

    // Reviews
    Route::post('order/{id}/review', [ReviewController::class, 'store'])->name('order.review');
    Route::patch('review/{id}', [ReviewController::class, 'update'])->name('order.review.update');

    // Tickets
    Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('tickets/filter', [TicketController::class, 'filter'])->name('tickets.filter');
    Route::get('tickets/{id}/details', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('tickets/new-ticket', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('new-ticket', [TicketController::class, 'store'])->name('tickets.store');
    Route::post('tickets/{id}/response', [TicketController::class, 'response'])->name('tickets.response.new');
    Route::patch('ticket/{id}/close', [TicketController::class, 'close'])->name('tickets.close');
});

// Seller
Route::middleware(['auth', 'active', 'isSeller'])->prefix('seller')->name('seller.')->group(function () {
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
    // Stores
    Route::get('stores/create', [StoreController::class, 'create'])->name('stores.create');
    Route::get('stores/edit/{username}', [StoreController::class, 'edit'])->name('stores.edit');
    // Route::get('stores/edit/{id}', [StoreController::class, 'edit'])->name('stores.edit');
    Route::get('stores/subscriptions', [SubscriptionController::class, 'index'])->name('stores.subscriptions.index');
    Route::get('stores/subscriptions/create', [SubscriptionController::class, 'create'])->name('stores.subscriptions.create');
    Route::post('stores/subscriptions', [SubscriptionController::class, 'store'])->name('stores.subscriptions.store');
    Route::patch('stores/update/{username}', [StoreController::class, 'update'])->name('stores.update');
    Route::patch('stores/maintenance/enable/{id}', [StoreController::class, 'enableMaintenance'])->name('stores.enableMaintenance');
    Route::patch('stores/maintenance/disable/{id}', [StoreController::class, 'disableMaintenance'])->name('stores.disableMaintenance');
    Route::post('stores/store', [StoreController::class, 'store'])->name('stores.store');
    Route::get('stores', [StoreController::class, 'index'])->name('stores.index');
    Route::get('stores/show/{username}', [StoreController::class, 'show'])->name('stores.show');

    // Categories

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/filter', [CategoryController::class, 'filter'])->name('categories.filter');
    Route::post('categories/', [CategoryController::class, 'store'])->name('categories.store');
    Route::patch('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Products
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/filter', [ProductController::class, 'filter'])->name('products.filter');
    Route::get('products/details/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::delete('products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    // Populate Products
    Route::post('products/populate', [ProductController::class, 'populate'])->name('products.populate');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/filter', [NotificationController::class, 'filter'])->name('notifications.filter');
    // Payments
    Route::get('requests/payments', [PaymentRequestController::class, 'index'])->name('payment-requests.index');
    Route::get('requests/payments/filter', [PaymentRequestController::class, 'filter'])->name('payment-requests.filter');
    Route::get('requests/payments/{id}', [PaymentRequestController::class, 'show'])->name('payment-requests.show');
    Route::post('requests/payments', [PaymentRequestController::class, 'store'])->name('payment-requests.store');

    // Transfers

    Route::get('transfers', [TransferController::class, 'index'])->name('transfers.index');
    Route::get('transfers/filter', [TransferController::class, 'filter'])->name('transfers.filter');
    Route::post('transfers', [TransferController::class, 'store'])->name('transfers.store');

    // Inventory
    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('inventory/filter', [InventoryController::class, 'filter'])->name('inventory.filter');
    Route::patch('inventory/manage/{id}', [InventoryController::class, 'manage'])->name('inventory.manage');

    // Sales
    Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('sales/filter', [SaleController::class, 'filter'])->name('sales.filter');
    Route::get('sales/details/{id}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('sales/new', [SaleController::class, 'create'])->name('sales.create');
    Route::post('sales/store', [SaleController::class, 'store'])->name('sales.store');
    Route::delete('sales/destroy/{id}', [SaleController::class, 'destroy'])->name('sales.destroy');

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/filter', [OrderController::class, 'filter'])->name('orders.filter');
    Route::get('order/details/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('order/{id}/reject', [OrderController::class, 'reject'])->name('orders.reject');
    Route::patch('order/{id}/accept', [OrderController::class, 'accept'])->name('orders.accept');
    Route::patch('order/{id}/ready', [OrderController::class, 'ready'])->name('orders.ready');
    Route::patch('order/{id}/cancel', [OrderController::class, 'sellerCancel'])->name('orders.cancel');
    // Pick Requests
    Route::post('pick-request', [PickRequestController::class, 'store'])->name('pickRequest.store');
    // Reviews
    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/filter', [ReviewController::class, 'filter'])->name('reviews.filter');

    // Tickets
    Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('tickets/filter', [TicketController::class, 'filter'])->name('tickets.filter');
    Route::get('tickets/{id}/details', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('tickets/new-ticket', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('new-ticket', [TicketController::class, 'store'])->name('tickets.store');
    Route::post('tickets/{id}/response', [TicketController::class, 'response'])->name('tickets.response.new');
    Route::patch('ticket/{id}/close', [TicketController::class, 'close'])->name('tickets.close');
});

// Admin
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
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
    Route::get('vouchers', [VoucherController::class, 'index'])->name('vouchers.index');
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
    // Clients
    Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('clients/filter', [ClientController::class, 'filter'])->name('clients.filter');
    Route::get('clients/show/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::patch('clients/ban/{id}', [ClientController::class, 'ban'])->name('clients.ban');
    Route::patch('clients/activate/{id}', [ClientController::class, 'activate'])->name('clients.activate');
    // Sellers
    Route::get('sellers', [SellerController::class, 'index'])->name('sellers.index');
    Route::get('sellers/filter', [SellerController::class, 'filter'])->name('sellers.filter');
    Route::get('sellers/show/{id}', [SellerController::class, 'show'])->name('sellers.show');
    Route::patch('sellers/ban/{id}', [SellerController::class, 'ban'])->name('sellers.ban');
    Route::patch('sellers/activate/{id}', [SellerController::class, 'activate'])->name('sellers.activate');
    // Stores
    Route::get('stores', [StoreController::class, 'adminIndex'])->name('stores.index');
    Route::get('stores/filter', [StoreController::class, 'filter'])->name('stores.filter');

    // Show Stores
    Route::get('store/{username}/home', [StoreController::class, 'home'])->name('store.home');
    Route::get('store/{username}/reviews', [StoreController::class, 'reviews'])->name('store.reviews');
    Route::get('store/{username}/owner', [StoreController::class, 'owner'])->name('store.owner');
    Route::get('store/{username}/orders', [StoreController::class, 'orders'])->name('store.orders');
    Route::get('store/{username}/order/{id}', [StoreController::class, 'order'])->name('store.order');
    Route::get('store/{username}/sales', [SaleController::class, 'sales'])->name('store.sales');
    Route::get('store/{username}/sales/sales', [SaleController::class, 'filterSales'])->name('store.sales.filter');
    Route::get('store/{username}/sale/{id}', [SaleController::class, 'sale'])->name('store.sale');
    Route::get('store/{username}/transfers', [TransferController::class, 'transfers'])->name('store.transfers');
    Route::get('store/{username}/transfers/filter', [TransferController::class, 'transfersFilter'])->name('store.transfers.filter');
    Route::patch('store/ban/{id}', [StoreController::class, 'ban'])->name('store.ban');
    Route::patch('store/activate/{id}', [StoreController::class, 'activate'])->name('store.activate');
    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/filter', [NotificationController::class, 'filter'])->name('notifications.filter');
    Route::get('/getNotifications', [NotificationController::class, 'getNotifications']);
    // Payments
    Route::get('requests/payments', [PaymentRequestController::class, 'adminIndex'])->name('payment-requests.index');
    Route::get('requests/payments/filter', [PaymentRequestController::class, 'filter'])->name('payment-requests.filter');
    Route::get('requests/payments/{id}', [PaymentRequestController::class, 'adminShow'])->name('payment-requests.show');
    Route::patch('requests/payments/accept/{id}', [PaymentRequestController::class, 'accept'])->name('payment-requests.accept');
    Route::patch('requests/payments/reject/{id}', [PaymentRequestController::class, 'reject'])->name('payment-requests.reject');
    Route::patch('requests/payments/accept-all', [PaymentRequestController::class, 'acceptAll'])->name('payment-requests.acceptAll');
    Route::patch('requests/payments/reject-all', [PaymentRequestController::class, 'rejectAll'])->name('payment-requests.rejectAll');

    // Transfers
    Route::get('transfers', [TransferController::class, 'adminIndex'])->name('transfers.index');
    Route::get('transfers/filter', [TransferController::class, 'filter'])->name('transfers.filter');
    // Subscriptions
    Route::get('subscriptions', [SubscriptionController::class, 'adminIndex'])->name('subscriptions.index');
    Route::get('subscriptions/filter', [SubscriptionController::class, 'filter'])->name('subscriptions.filter');
    // Sales
    Route::get('sales', [SaleController::class, 'adminIndex'])->name('sales.index');
    Route::get('sales/filter', [SaleController::class, 'adminFilter'])->name('sales.filter');
    Route::get('sales/details/{id}', [SaleController::class, 'adminShow'])->name('sales.show');

    // Orders
    Route::get('orders', [OrderController::class, 'adminIndex'])->name('orders.index');
    Route::get('orders/filter', [OrderController::class, 'filter'])->name('orders.filter');
    Route::get('order/details/{id}', [OrderController::class, 'adminShow'])->name('orders.show');

    // Reviews
    Route::delete('review/{id}', [ReviewController::class, 'destroy'])->name('order.review.destroy');

    // Tickets
    Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('tickets/filter', [TicketController::class, 'filter'])->name('tickets.filter');
    Route::get('tickets/{id}/details', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('tickets/{id}/response', [TicketController::class, 'response'])->name('tickets.response.new');
    Route::patch('ticket/{id}/close', [TicketController::class, 'close'])->name('tickets.close');
});
