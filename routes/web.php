<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/',[AuthController::class,'login'])->name('login');
Route::post('/',[AuthController::class,'handleLogin'])->name('handleLogin');

//Route sécurisé

Route::get('dashboard',[AppController::class,'index'])->name('dashboard');