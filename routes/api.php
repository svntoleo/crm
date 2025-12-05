<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QuotationController;
use App\Http\Controllers\Api\ServiceOrderController;

Route::middleware('auth:web')->group(function () {
    // Quotations - explicit routes before parameterized ones
    Route::post('quotations/move', [QuotationController::class, 'move']);
    Route::get('quotations', [QuotationController::class, 'index']);
    Route::post('quotations', [QuotationController::class, 'store']);
    Route::get('quotations/{quotation}', [QuotationController::class, 'show']);
    Route::put('quotations/{quotation}', [QuotationController::class, 'update']);
    Route::delete('quotations/{quotation}', [QuotationController::class, 'destroy']);
    Route::post('quotations/{quotation}/items', [\App\Http\Controllers\Api\QuotationItemController::class, 'store']);
    Route::put('quotations/{quotation}/items/{item}', [\App\Http\Controllers\Api\QuotationItemController::class, 'update']);
    Route::delete('quotations/{quotation}/items/{item}', [\App\Http\Controllers\Api\QuotationItemController::class, 'destroy']);

    // Service orders - explicit routes before parameterized ones
    Route::post('service-orders/move', [ServiceOrderController::class, 'move']);
    Route::get('service-orders', [ServiceOrderController::class, 'index']);
    Route::post('service-orders', [ServiceOrderController::class, 'store']);
    Route::get('service-orders/{serviceOrder}', [ServiceOrderController::class, 'show']);
    Route::put('service-orders/{serviceOrder}', [ServiceOrderController::class, 'update']);
    Route::delete('service-orders/{serviceOrder}', [ServiceOrderController::class, 'destroy']);
    Route::post('service-orders/{serviceOrder}/items', [\App\Http\Controllers\Api\ServiceOrderItemController::class, 'store']);
    Route::put('service-orders/{serviceOrder}/items/{item}', [\App\Http\Controllers\Api\ServiceOrderItemController::class, 'update']);
    Route::delete('service-orders/{serviceOrder}/items/{item}', [\App\Http\Controllers\Api\ServiceOrderItemController::class, 'destroy']);
});
