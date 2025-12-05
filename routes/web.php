<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';

use App\Http\Controllers\QuotationWebController;
use App\Http\Controllers\ServiceOrderWebController;
use App\Http\Controllers\ProductWebController;
use App\Http\Controllers\ProductCategoryWebController;
use App\Http\Controllers\CustomerWebController;
use App\Http\Controllers\UserWebController;

Route::middleware(['auth','verified'])->group(function () {
    // Quotations
    Route::get('/quotations', [QuotationWebController::class, 'index'])->name('quotations.index');
    Route::get('/quotations/create', [QuotationWebController::class, 'create'])->name('quotations.create');
    Route::post('/quotations', [QuotationWebController::class, 'store'])->name('quotations.store');
    Route::get('/quotations/{quotation}/edit', [QuotationWebController::class, 'edit'])->name('quotations.edit');
    Route::put('/quotations/{quotation}', [QuotationWebController::class, 'update'])->name('quotations.update');
    Route::delete('/quotations/{quotation}', [QuotationWebController::class, 'destroy'])->name('quotations.destroy');
    Route::get('/quotations/{quotation}', [QuotationWebController::class, 'show'])->name('quotations.show');
    Route::post('/quotations/move', [QuotationWebController::class, 'move'])->name('quotations.move');
    
    // Quotation Items
    Route::post('/quotations/{quotation}/items', [QuotationWebController::class, 'storeItem'])->name('quotations.items.store');
    Route::put('/quotations/{quotation}/items/{item}', [QuotationWebController::class, 'updateItem'])->name('quotations.items.update');
    Route::delete('/quotations/{quotation}/items/{item}', [QuotationWebController::class, 'destroyItem'])->name('quotations.items.destroy');

    // Service Orders
    Route::get('/service-orders', [ServiceOrderWebController::class, 'index'])->name('service_orders.index');
    Route::get('/service-orders/create', [ServiceOrderWebController::class, 'create'])->name('service_orders.create');
    Route::post('/service-orders', [ServiceOrderWebController::class, 'store'])->name('service_orders.store');
    Route::get('/service-orders/{serviceOrder}/edit', [ServiceOrderWebController::class, 'edit'])->name('service_orders.edit');
    Route::put('/service-orders/{serviceOrder}', [ServiceOrderWebController::class, 'update'])->name('service_orders.update');
    Route::delete('/service-orders/{serviceOrder}', [ServiceOrderWebController::class, 'destroy'])->name('service_orders.destroy');
    Route::get('/service-orders/{serviceOrder}', [ServiceOrderWebController::class, 'show'])->name('service_orders.show');
    Route::post('/service-orders/move', [ServiceOrderWebController::class, 'move'])->name('service_orders.move');
    
    // Service Order Items
    Route::post('/service-orders/{serviceOrder}/items', [ServiceOrderWebController::class, 'storeItem'])->name('service_orders.items.store');
    Route::put('/service-orders/{serviceOrder}/items/{item}', [ServiceOrderWebController::class, 'updateItem'])->name('service_orders.items.update');
    Route::delete('/service-orders/{serviceOrder}/items/{item}', [ServiceOrderWebController::class, 'destroyItem'])->name('service_orders.items.destroy');

    // Products (admin only)
    Route::middleware('admin')->group(function () {
        Route::get('/products', [ProductWebController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductWebController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductWebController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductWebController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductWebController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductWebController::class, 'destroy'])->name('products.destroy');
    });

    // Product Categories (admin only)
    Route::middleware('admin')->group(function () {
        Route::get('/product-categories', [ProductCategoryWebController::class, 'index'])->name('product_categories.index');
        Route::get('/product-categories/create', [ProductCategoryWebController::class, 'create'])->name('product_categories.create');
        Route::post('/product-categories', [ProductCategoryWebController::class, 'store'])->name('product_categories.store');
        Route::get('/product-categories/{productCategory}/edit', [ProductCategoryWebController::class, 'edit'])->name('product_categories.edit');
        Route::put('/product-categories/{productCategory}', [ProductCategoryWebController::class, 'update'])->name('product_categories.update');
        Route::delete('/product-categories/{productCategory}', [ProductCategoryWebController::class, 'destroy'])->name('product_categories.destroy');
    });

    // Customers (admin only)
    Route::middleware('admin')->group(function () {
        Route::get('/customers', [CustomerWebController::class, 'index'])->name('customers.index');
        Route::get('/customers/{customer}', [CustomerWebController::class, 'show'])->name('customers.show');
        Route::get('/customers/{customer}/edit', [CustomerWebController::class, 'edit'])->name('customers.edit');
        Route::put('/customers/{customer}', [CustomerWebController::class, 'update'])->name('customers.update');
    });

    // Users (admin only)
    Route::middleware('admin')->group(function () {
        Route::get('/users', [UserWebController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserWebController::class, 'create'])->name('users.create');
        Route::post('/users', [UserWebController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserWebController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserWebController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserWebController::class, 'destroy'])->name('users.destroy');
    });
});
