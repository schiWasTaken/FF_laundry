<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LaundryServiceController;
use App\Http\Controllers\OrderController;

Route::get('/', [HomeController::class, 'index']);
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/destination-page', [LaundryServiceController::class, 'index'])->name('destination.page');
Route::post('/save-selected-services', [OrderController::class, 'store'])->name('save.selected.services');
Route::post('/update-order-status/{orderId}', [OrderController::class, 'updateOrderStatus']);
Route::get('/order-status/{orderId}', [OrderController::class, 'getOrderStatus']);

