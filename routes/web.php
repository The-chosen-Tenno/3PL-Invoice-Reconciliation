<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceShipmentController;
use App\Http\Controllers\ImportBatchController;

Route::middleware('guest')->group(function () {
    Route::view('/', 'auth.login')->name('login');
    Route::view('/register', 'auth.create')->name('register');
});

//Auth
Route::post('/user', [UserController::class, 'NewUser'])->name('store.user');
Route::post('/login', [AuthController::class, 'Login']);
Route::post('/logout', [AuthController::class, 'Logout'])->middleware('auth');

//View
Route::middleware('auth')->prefix('pages')->group(function () {
    Route::view('/dashboard', 'pages.dashboard')->name('dashboard');
    Route::view('/orders', 'pages.orders')->name('orders');
});

// // Invoices
// Route::middleware('auth')->controller(InvoiceShipmentController::class)->group(function () {
//     Route::post('/invoices/upload', 'upload')->name('invoices.upload');
// });

Route::middleware('auth')->group(function () {
    Route::post('/invoices/upload', [InvoiceShipmentController::class, 'upload'])->name('invoices.upload');
    Route::get('/import-batches/{batch}/progress', [ImportBatchController::class, 'progress'])
        ->name('import-batches.progress');
});
