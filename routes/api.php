<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\WalletController;

Route::group(['middleware' => ['guest']], function()
{
/* This is a group of routes that are only accessible to guests. */
	Route::post('/login', [AuthController::class, 'login']);
	Route::post('/register', [AuthController::class, 'register']);

});

Route::middleware(['auth:user'])->group(function()
{
/* This is a route that is only accessible to logged in users. */
	Route::post('/logout', [AuthController::class, 'logout']);
	Route::post('/profile', [AuthController::class, 'profile']);

    Route::prefix('user')->group(function()
    {
        Route::post('/create', [UserController::class, 'create']);
        Route::post('/read', [UserController::class, 'read']);
        Route::post('/list', [UserController::class, 'list']);
        Route::post('/update', [UserController::class, 'update']);
        Route::post('/delete', [UserController::class, 'delete']);
    });

    Route::prefix('company')->group(function()
    {
        Route::post('/create', [CompanyController::class, 'create']);
        Route::post('/read', [CompanyController::class, 'read']);
        Route::post('/list', [CompanyController::class, 'list']);
        Route::post('/update', [CompanyController::class, 'update']);
        Route::post('/delete', [CompanyController::class, 'delete']);
    });

    Route::prefix('wallet')->group(function()
    {
        Route::post('/create', [WalletController::class, 'create']);
        Route::post('/read', [WalletController::class, 'read']);
        Route::post('/list', [WalletController::class, 'list']);
        Route::post('/update', [WalletController::class, 'update']);
        Route::post('/delete', [WalletController::class, 'delete']);
    });

});