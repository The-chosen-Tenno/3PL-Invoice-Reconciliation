<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::view('/', 'auth.login')->name('login');
    Route::view('/register', 'auth.create')->name('register');
});
//View
Route::middleware('auth')->prefix('pages')->group(function () {
    Route::view('/dashboard', 'pages.dashboard')->name('dashboard');
    Route::view('/orders', 'pages.orders')->name('orders');
});

//Auth
Route::post('/user', [UserController::class, 'NewUser'])->name('store.user');
Route::post('/login', [AuthController::class, 'Login']);
Route::post('/logout', [AuthController::class, 'Logout'])->middleware('auth');

// Users (tested)
Route::middleware('auth')->controller(UserController::class)->group(function () {
    Route::get('/users', 'AllUsers');
    Route::get('/user/{id}', 'UserById');
    Route::patch('/user/{id}', 'UpdateUser');
    Route::patch('/user/accept/{id}', 'AcceptUser');
    Route::patch('/user/decline/{id}', 'DeclineUser');
});
