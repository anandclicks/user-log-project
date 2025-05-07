<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;

Route::get('/',                [UserController::class, 'showHomePage'])->name('/');
Route::get('/register',        [UserController::class, 'registerPage'])->name("register.view");
Route::post('/register-user',  [UserController::class, 'RegisterUser'])->name('user.register');
Route::get('/login',           [UserController::class,  'loginPage'])->name('login.view');
Route::post('/login-user',     [UserController::class,  'LoginUser'])->name('user.login');
Route::post('/create-post',    [UserController::class,  'CreatePost'])->name('create.post');
Route::get('/get-post',        [UserController::class,   'showExistingPostData'])->name('get.post');
Route::get('/delete-post',     [UserController::class,   'deletePost'])->name('delete.post');



Route::post('/email',           [EmailController::class, 'sendEmail'])->name('send-email');
Route::view('/email',          'client/form');