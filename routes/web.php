<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/register',        [UserController::class, 'index'])->name("register.view");
Route::post('/register-user',  [UserController::class, 'RegisterUser'])->name('user.register');