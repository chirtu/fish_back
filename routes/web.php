<?php

use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderConfirmationsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::middleware('guest:customer')->controller(CustomerAuthController::class)->group(function (): void {
    Route::view('/register', 'auth.register')->name('customer.register');
    Route::post('/register', 'register')->middleware('throttle:10,1')->name('customer.register.store');
    Route::view('/customer/login', 'auth.customer-login')->name('customer.login');
    Route::post('/customer/login', 'login')->middleware('throttle:10,1')->name('customer.login.store');
});

Route::middleware('auth:customer')->group(function (): void {
    Route::view('/customer/account', 'auth.customer-account')->name('customer.account');
    Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
});

Route::middleware(['auth:web', 'can:access-admin-dashboard'])->group(function (): void {
    Route::get('/', HomeController::class)->name('home');

    Route::get('/home', HomeController::class)->name('home');
    Route::get('users', [UsersController::class, 'index'])->name('users.index');
    Route::post('users', [UsersController::class, 'store'])->name('users.store');
    Route::delete('users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
    Route::get('product-categories', [ProductCategoriesController::class, 'index'])->name('productCategories.index');
    Route::post('product-categories', [ProductCategoriesController::class, 'store'])->name('productCategories.store');
    Route::put('product-categories', [ProductCategoriesController::class, 'update'])->name('productCategories.update');

    Route::delete('product-categories', [ProductCategoriesController::class, 'destroy'])->name('productCategories.destroy');
    Route::get('products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('products', [ProductsController::class, 'store'])->name('products.store');
    Route::get('products/{product}', [ProductsController::class, 'show'])->name('products.show');
    Route::get('products/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
    Route::get('customers', [CustomersController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [CustomersController::class, 'show'])->name('customers.show');
    Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
    Route::put('order/update-status/{status}', [OrdersController::class, 'updateStatus'])->name('order.update.status');
    Route::patch('order-confirmations/{order}', [OrderConfirmationsController::class, 'update'])->name('orderConfirmations.update');
    Route::get('payments', [PaymentsController::class, 'index'])->name('payments.index');
    Route::get('payments/{payment}', [PaymentsController::class, 'show'])->name('payments.show');
});
