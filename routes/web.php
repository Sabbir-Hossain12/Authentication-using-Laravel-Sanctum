<?php

use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;


//pages
Route::view('/userRegistration','pages.auth.registration-page');
Route::view('/userLogin','pages.auth.login-page');
//    ->name('login');
Route::view('/dashboard','pages.dashboard.dashboard-page');


//web api routes
Route::post('/registration',[userController::class,'registration']);
Route::post('/login',[userController::class,'login']);
Route::post('/userProfile',[userController::class,'userProfile']);
//    ->middleware('auth:sanctum');
Route::post('/update',[userController::class,'updateProfile']);
Route::post('/logout',[userController::class,'logout']);


