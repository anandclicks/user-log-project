<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/',                [UserController::class, 'showHomePage'])->name('/')->middleware('auth.check');
Route::get('/register',        [UserController::class, 'registerPage'])->name("register.view");
Route::post('/register-user',  [UserController::class, 'RegisterUser'])->name('user.register');
Route::get('/login',           [UserController::class,  'loginPage'])->name('login.view');
Route::post('/login-user',      [UserController::class,  'LoginUser'])->name('user.login');
Route::post('/create-post',     [UserController::class,  'CreatePost'])->name('create.post');