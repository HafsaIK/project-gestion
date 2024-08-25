<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/',[AuthController::class,'login'])->name('login');
Route::post('/',[AuthController::class,'handleLogin'])->name('handleLogin');

Route::get('/validate-account/{email}',[AdminController::class,'defineAccess']);
Route::post('/validate-account/{email}',[AdminController::class,'SubmitDefineAccess'])->name('SubmitDefineAccess');

//Route sécurisé

Route::middleware('auth')->group(function(){
    Route::get('dashboard',[AppController::class,'index'])->name('dashboard'); 

    Route::prefix('employers')->group(function(){
        Route::get('/',[EmployerController::class,'index'])->name('employers.index') ;
        Route::get('/create',[EmployerController::class,'create'])->name('employers.create') ;
        Route::get('/edit/{employer}',[EmployerController::class,'edit'])->name('employers.edit') ;
        Route::post('/store',[EmployerController::class,'store'])->name('employers.store') ; 
        Route::put('/update/{employer}',[EmployerController::class,'update'])->name('employers.update');
        Route::get('/delete/{employer}',[EmployerController::class,'delete'])->name('employers.delete') ;
    });

    Route::prefix('departements')->group(function(){
        Route::get('/',[DepartementController::class,'index'])->name('departements.index') ;
        Route::get('/create',[DepartementController::class,'create'])->name('departements.create') ;
        Route::post('/create',[DepartementController::class, 'store'])->name('departements.store') ;
        Route::get('/edit/{departement}',[DepartementController::class,'edit'])->name('departements.edit') ;
        Route::put('/update/{departement}',[DepartementController::class,'update'])->name('departements.update') ;
        Route::get('/{departement}',[DepartementController::class,'delete'])->name('departements.delete') ;

    });

    Route::prefix('configurtions')->group(function(){
        Route::get('/',[ConfigurationController::class,'index'])->name('configurations') ;
        Route::get('/create',[ConfigurationController::class,'create'])->name('configurations.create') ;

        //Route d'actions
        Route::post('/store',[ConfigurationController::class,'store'])->name('configurations.store') ;
        Route::get('/delete/{configuration}',[ConfigurationController::class,'delete'])->name('configurations.delete') ;
    });

    Route::prefix('administrateurs')->group(function () {
        Route::get('/',[AdminController::class,'index'])->name('administrateurs.index');
        Route::get('/create', [AdminController::class, 'create'])->name('administrateurs.create');
        Route::post('/store', [AdminController::class, 'store'])->name('administrateurs.store');
        Route::get('/delete/{user}', [AdminController::class, 'delete'])->name('administrateurs.delete');

    });

    Route::prefix('payments')->group(function () {
        Route::get('/',[PaymentController::class, 'index'])->name('payments.index') ;
        Route::get('/make', [PaymentController::class,'initPayment'])->name('payments.init') ;
    
    });



});