<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::view('/',                       'welcome')->name('/')->middleware('auth.check');
Route::get('/register',        [UserController::class, 'registerPage'])->name("register.view");
Route::post('/register-user',  [UserController::class, 'RegisterUser'])->name('user.register');
Route::get('/login',           [UserController::class,  'loginPage'])->name('login.view');
Route::post('/login-user',      [UserController::class,  'LoginUser'])->name('user.login');