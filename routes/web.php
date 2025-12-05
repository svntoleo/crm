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

use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;

Route::middleware(['auth','verified'])->group(function () {
    // Quotations





    Route::get('/quotations', [QuotationController::class, 'index'])->name('quotations.index');
    Route::get('/quotations/create', [QuotationController::class, 'create'])->name('quotations.create');
    Route::post('/quotations', [QuotationController::class, 'store'])->name('quotations.store');
    Route::get('/quotations/{quotation}/edit', [QuotationController::class, 'edit'])->name('quotations.edit');
    Route::put('/quotations/{quotation}', [QuotationController::class, 'update'])->name('quotations.update');
    Route::delete('/quotations/{quotation}', [QuotationController::class, 'destroy'])->name('quotations.destroy');
    Route::get('/quotations/{quotation}', [QuotationController::class, 'show'])->name('quotations.show');
    Route::post('/quotations/move', [QuotationController::class, 'move'])->name('quotations.move');
    
    // Quotation Items
    Route::post('/quotations/{quotation}/items', [QuotationController::class, 'storeItem'])->name('quotations.items.store');
    Route::put('/quotations/{quotation}/items/{item}', [QuotationController::class, 'updateItem'])->name('quotations.items.update');
    Route::delete('/quotations/{quotation}/items/{item}', [QuotationController::class, 'destroyItem'])->name('quotations.items.destroy');

    // Service Orders
    Route::get('/service-orders', [ServiceOrderController::class, 'index'])->name('service_orders.index');
    Route::get('/service-orders/create', [ServiceOrderController::class, 'create'])->name('service_orders.create');
    Route::post('/service-orders', [ServiceOrderController::class, 'store'])->name('service_orders.store');
    Route::get('/service-orders/{serviceOrder}/edit', [ServiceOrderController::class, 'edit'])->name('service_orders.edit');
    Route::put('/service-orders/{serviceOrder}', [ServiceOrderController::class, 'update'])->name('service_orders.update');
    Route::delete('/service-orders/{serviceOrder}', [ServiceOrderController::class, 'destroy'])->name('service_orders.destroy');
    Route::get('/service-orders/{serviceOrder}', [ServiceOrderController::class, 'show'])->name('service_orders.show');
    Route::post('/service-orders/move', [ServiceOrderController::class, 'move'])->name('service_orders.move');
    
    // Service Order Items
    Route::post('/service-orders/{serviceOrder}/items', [ServiceOrderController::class, 'storeItem'])->name('service_orders.items.store');
    Route::put('/service-orders/{serviceOrder}/items/{item}', [ServiceOrderController::class, 'updateItem'])->name('service_orders.items.update');
    Route::delete('/service-orders/{serviceOrder}/items/{item}', [ServiceOrderController::class, 'destroyItem'])->name('service_orders.items.destroy');

    // Products (admin only)
    Route::middleware('admin')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Product Categories (admin only)
    Route::middleware('admin')->group(function () {
        Route::get('/product-categories', [ProductCategoryController::class, 'index'])->name('product_categories.index');
        Route::get('/product-categories/create', [ProductCategoryController::class, 'create'])->name('product_categories.create');
        Route::post('/product-categories', [ProductCategoryController::class, 'store'])->name('product_categories.store');
        Route::get('/product-categories/{productCategory}/edit', [ProductCategoryController::class, 'edit'])->name('product_categories.edit');
        Route::put('/product-categories/{productCategory}', [ProductCategoryController::class, 'update'])->name('product_categories.update');
        Route::delete('/product-categories/{productCategory}', [ProductCategoryController::class, 'destroy'])->name('product_categories.destroy');
    });

    // Customers (admin only)
    Route::middleware('admin')->group(function () {
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    });

    // Users (admin only)
    Route::middleware('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
