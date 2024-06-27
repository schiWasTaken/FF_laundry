<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LaundryServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DistanceController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index']);
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::get('/request-pickup', [LaundryServiceController::class, 'index'])->name('request.pickup');
    Route::post('/save-selected-services', [OrderController::class, 'store'])->name('save.selected.services');
    Route::post('/update-order-status/{orderId}', [OrderController::class, 'updateOrderStatus']);
    Route::get('/order-status/{orderId}', [OrderController::class, 'getOrderStatus']);
    Route::get('/calculate-distance', [DistanceController::class, 'calculateDistance']);
    Route::get('/order-tracking', [OrderController::class, 'index'])->name('order.tracking');
    Route::get('/order-history', [OrderController::class, 'history'])->name('order.history');
    Route::delete('/order/{orderId}', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::post('/order/request-finished/{id}', [OrderController::class, 'requestFinished'])->name('order.requestFinished');
    Route::delete('/order/cancel/{id}', [OrderController::class, 'cancel'])->name('order.cancel');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/orders', [AdminController::class, 'index'])->name('admin.orders');
    Route::post('/admin/orders/{id}', [AdminController::class, 'update'])->name('admin.update');
});
