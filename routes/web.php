<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::post('/enquiries', [EnquiryController::class, 'store'])
    ->middleware('throttle:enquiries')
    ->name('enquiries.store');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'create'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/', Admin\DashboardController::class)->name('dashboard');

    Route::resource('brands', Admin\BrandController::class)->except('show');
    Route::resource('motorcycles', Admin\MotorcycleController::class)->except('show');
    Route::resource('promotions', Admin\PromotionController::class)->except('show');
    Route::resource('enquiries', Admin\EnquiryController::class)->only(['index', 'update', 'destroy']);
    Route::resource('users', Admin\UserController::class)->except('show');
});
