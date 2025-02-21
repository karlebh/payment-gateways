<?php

use App\Http\Controllers\PaystackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/paystack/create', [PaystackController::class, 'create'])->name('paystack.create');
Route::get('/paystack/verify', [PaystackController::class, 'verifyPayment'])->name('paystack.verify');
Route::post('/paystack/pay', [PaystackController::class, 'initiatePayment'])->name('paystack.pay');
Route::get('/paystack/index', [PaystackController::class, 'allTransactions'])->name('paystack.index');
