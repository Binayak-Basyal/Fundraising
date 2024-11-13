<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminFundController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\DonationController;
use App\Http\Controllers\KMeansController;
use App\Http\Controllers\UserController;


// Public Routes
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/funds', [FundController::class, 'userIndex'])->name('allfunds');
Route::get('/', [FundController::class, 'home'])->name('home');

// Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
Route::post('/funds/donate', [DonationController::class, 'store'])->name('funds.donate');



Route::get('/kmeans', [KMeansController::class, 'index'])->name('kmeans.index');
Route::get('/admin/kmeans', [KMeansController::class, 'index'])->name('admin.kmeans');
Route::get('/admin/kmeans', [KMeansController::class, 'index'])->name('admin.kmeans');





Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [FundController::class, 'home'])->name('home');
    Route::get('/funds', [FundController::class, 'index'])->name('funds.index');
    Route::get('/filter-funds/{categoryId}', [FundController::class, 'filterFund']);
    Route::get('/fundhere', [FundController::class, 'showSellForm'])->name('fundhere');
    Route::post('/fundhere', [FundController::class, 'store'])->name('fundhere.store');
    Route::get('/funds', [FundController::class, 'userIndex'])->name('allfunds');
    Route::get('/funds/{id}', [FundController::class, 'show'])->name('funds.show');

    Route::get('/myfunds/{id}', [FundController::class, 'myfunds'])->name('funds.myfunds')->middleware('auth');
    
    Route::put('/funds/{id}', [FundController::class, 'update'])->name('funds.update');
    Route::delete('/funds/{id}', [FundController::class, 'destroy'])->name('funds.destroy');
    Route::get('/funds/{id}', [FundController::class, 'displayFund'])->name('funds.show');
    Route::post('/funds/donate', [FundController::class, 'donate'])->name('funds.donate');
});


// Admin Authentication Routes
Route::get('admin/login', [AdminLoginController::class, 'index'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'login']);
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Admin Routes
Route::prefix('admin')->middleware(['auth:admin'])->name('admin.')->group(function () {
    Route::get('dashboard', [AdminLoginController::class, 'dashboard'])->name('dashboard');

    Route::get('users', [AdminUserController::class, 'showAllUsers'])->name('users.index');
    Route::post('users/{id}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
    Route::post('users/{id}/decline', [AdminUserController::class, 'decline'])->name('users.decline');
    Route::delete('users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Define the route for managing categories
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Authentication Routes
Route::get('admin/login', [AdminLoginController::class, 'index'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'login']);
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Admin Routes
Route::prefix('admin')->middleware(['auth:admin'])->name('admin.')->group(function () {
    Route::get('dashboard', [AdminLoginController::class, 'dashboard'])->name('dashboard');

    Route::get('users', [AdminUserController::class, 'showAllUsers'])->name('users');
    Route::post('users/{id}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
    Route::post('users/{id}/decline', [AdminUserController::class, 'decline'])->name('users.decline');
    Route::delete('users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Define the route for managing categories
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [AdminCategoryController::class, 'storeCategory'])->name('categories.store');
    Route::post('categories/{category}', [AdminCategoryController::class, 'updateCategory'])->name('categories.update');
    Route::delete('categories/{category}', [AdminCategoryController::class, 'destroyCategory'])->name('categories.destroy');
    
    Route::get('/admin/funds', [AdminFundController::class, 'index'])->name('fund.index');
Route::delete('/funds/{id}', [AdminFundController::class, 'destroy'])->name('fund.destroy');    
});
// Profile Routes
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/{id}', [UserController::class, 'show'])->name('show');
    Route::put('/update', [UserController::class, 'update'])->name('update');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password');
    Route::post('/destroy', [UserController::class, 'destroy'])->name('destroy');
});
