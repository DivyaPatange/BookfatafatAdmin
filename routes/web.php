<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Auth\VendorLoginController;
use App\Http\Controllers\Auth\VendorRegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\OrderPlacedController;
use App\Http\Controllers\Admin\ListController;

// Vendor Controller
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\ServiceController;
use App\Http\Controllers\Vendor\ProfileController;
use App\Http\Controllers\Vendor\ChangePasswordController;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\DesignController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\User\OrderController;

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
    return view('admin.login');
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return 'DONE'; //Return anything
});

Route::get('/routeList', function () {
    $exitCode = Artisan::call('route:list');
    return Artisan::output(); //Return anything
});

Route::get('/seed', function () {
    $exitCode = Artisan::call('db:seed');
    return 'DONE'; //Return anything
});


Route::prefix('admin')->name('admin.')->group(function() {
    // Admin Authentication Route
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::resource('/vendorUser', VendorController::class);
    Route::resource('/services', App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('categories', CategoryController::class);
    Route::post('/get-category', [CategoryController::class, 'getCategory'])->name('get.category');
    Route::post('/category/update', [CategoryController::class, 'updateCategory']);
    Route::resource('/sub-category', SubCategoryController::class);
    Route::post('/get-sub-category', [SubCategoryController::class, 'getSubCategory'])->name('get.sub-category');
    Route::post('/sub-category/update', [SubCategoryController::class, 'updateSubCategory']);
    Route::resource('/products', App\Http\Controllers\Admin\ProductController::class);
    Route::get('/get-category-list', [App\Http\Controllers\Admin\ProductController::class, 'getCategoryList']);
    Route::post('/get-time-slot', [App\Http\Controllers\Admin\ServiceController::class, 'getTimeSlot'])->name('get.time-slot');
    Route::delete('/time-slot/delete/{id}', [App\Http\Controllers\Admin\ServiceController::class, 'deleteServiceTime']);
    Route::post('/service-time/update', [App\Http\Controllers\Admin\ServiceController::class, 'updateServiceTime'])->name('service-time.update');
    Route::post('/service-time/add', [App\Http\Controllers\Admin\ServiceController::class, 'addServiceTime'])->name('service-time.add');
    Route::resource('/users', AdminRoleController::class);
    Route::post('/get-user', [AdminRoleController::class, 'getUser'])->name('get.user');
    Route::post('/users/update', [AdminRoleController::class, 'updateUser']);
    Route::get('/placed-order', [OrderPlacedController::class, 'index'])->name('placed-order');
    Route::get('/confirmed-order', [OrderPlacedController::class, 'confirmedOrder'])->name('confirmed-order');
    Route::get('/shipped-order', [OrderPlacedController::class, 'shippedOrder'])->name('shipped-order');
    Route::get('/delivered-order', [OrderPlacedController::class, 'deliveredOrder'])->name('delivered-order');
    Route::get('/rejected-order', [OrderPlacedController::class, 'rejectedOrder'])->name('rejected-order');
    Route::get('/view-placed-order/{id}', [OrderPlacedController::class, 'show'])->name('view-placed-order');
    Route::get('/today-register-list', [ListController::class, 'todayRegisterUser'])->name('todayRegisterUser');
    Route::get('/today-placed-order', [ListController::class, 'todayOrderPlaced'])->name('todayOrderPlaced');
    Route::get('/today-payment-collection', [ListController::class, 'todayPaymentCollection'])->name('todayPaymentCollection');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('vendors')->name('vendor.')->group(function() {
    // Admin Authentication Route
    Route::get('/login', [VendorLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [VendorLoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [VendorRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [VendorRegisterController::class, 'register'])->name('register.submit');
    Route::get('/', [App\Http\Controllers\Auth\VendorController::class, 'index'])->name('dashboard')->middleware('vendor.status');
    Route::get('/logout', [VendorLoginController::class, 'logout'])->name('logout');
    Route::resource('product', ProductController::class);
    Route::get('/get-sub-category-list', [ProductController::class, 'getSubCategoryList']);
    Route::resource('/service', ServiceController::class);
    Route::post('/available-date/store', [ServiceController::class, 'storeAvailableDate'])->name('available-date.store');
    Route::get('/get-date/{id}', [ServiceController::class, 'getDate'])->name('service.getDate');
    Route::delete('/available-date/{id}', [ServiceController::class, 'deleteAvailableDate']);
    Route::post('/get-service-date', [ServiceController::class, 'editServiceDate'])->name('get.service-date');
    Route::post('/service-date/update', [ServiceController::class, 'updateDate'])->name('update.service-date');
    Route::post('/get-time-slot', [ServiceController::class, 'getTimeSlot'])->name('get.time-slot');
    Route::delete('/time-slot/delete/{id}', [ServiceController::class, 'deleteServiceTime']);
    Route::post('/service-time/update', [ServiceController::class, 'updateServiceTime'])->name('service-time.update');
    Route::post('/service-time/add', [ServiceController::class, 'addServiceTime'])->name('service-time.add');

    // Profile Route
    Route::resource('/profile', ProfileController::class);

    // Change Password Route
    Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change-password.index');
    Route::post('/change-password/update', [ChangePasswordController::class, 'store'])->name('change-password.update');
    Route::get('/all-orders', [App\Http\Controllers\Vendor\OrderPlacedController::class, 'allOrders'])->name('all-orders');
    Route::get('/view-placed-order/{id}', [App\Http\Controllers\Vendor\OrderPlacedController::class, 'show'])->name('view-placed-order');
    Route::post('/order-confirmed', [App\Http\Controllers\Vendor\OrderPlacedController::class, 'orderConfirmed']);
    Route::post('/order-rejected', [App\Http\Controllers\Vendor\OrderPlacedController::class, 'orderRejected']);

    Route::get('/confirmed-order', [App\Http\Controllers\Vendor\OrderPlacedController::class, 'confirmedOrderList'])->name('confirmed-order');
    Route::get('/rejected-order', [App\Http\Controllers\Vendor\OrderPlacedController::class, 'rejectedOrderList'])->name('rejected-order');

    Route::post('/ship-status', [App\Http\Controllers\Vendor\OrderPlacedController::class, 'shippingStatus']);
    Route::get('/shipped-order', [App\Http\Controllers\Vendor\OrderPlacedController::class, 'shippedOrderList'])->name('shipped-order');
    Route::post('/deliver-status', [App\Http\Controllers\Vendor\OrderPlacedController::class, 'deliveryStatus']);
    Route::get('/delivered-order', [App\Http\Controllers\Vendor\OrderPlacedController::class, 'deliveredOrderList'])->name('delivered-order');

});
