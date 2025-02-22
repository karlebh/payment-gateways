<?php

use App\Http\Controllers\FlutterwaveController;
use App\Http\Controllers\OpayController;
use App\Http\Controllers\PaystackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/paystack/create', [PaystackController::class, 'create'])->name('paystack.create');
Route::get('/paystack/verify', [PaystackController::class, 'verifyPayment'])->name('paystack.verify');
Route::post('/paystack/pay', [PaystackController::class, 'initiatePayment'])->name('paystack.pay');
Route::get('/paystack/index', [PaystackController::class, 'allTransactions'])->name('paystack.index');

Route::get('/opay/create', [OpayController::class, 'create'])->name('opay.create');
Route::get('/opay/verify', [OpayController::class, 'verifyPayment'])->name('opay.verify');
Route::post('/opay/pay', [OpayController::class, 'initiatePayment'])->name('opay.pay');
// Route::get('/opay/index', [OpayController::class, 'allTransactions'])->name('opay.index');

Route::get('/flutterwave/create', [FlutterwaveController::class, 'create'])->name('flutterwave.create');
Route::get('/flutterwave/verify', [FlutterwaveController::class, 'verifyPayment'])->name('flutterwave.verify');
Route::post('/flutterwave/pay', [FlutterwaveController::class, 'initiatePayment'])->name('flutterwave.pay');
// Route::get('/flutterwave/index', [FlutterwaveController::class, 'allTransactions'])->name('flutterwave.index');
