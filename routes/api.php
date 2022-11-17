<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\WalletController;

use App\Http\Controllers\MasterAdmin\MasterAdminController;

Route::middleware(['guest'])->group(function()
{
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

    Route::prefix('masteradmin')->group(function()
    {
        Route::prefix('company')->group(function()
        {
            /* company controller route */
            Route::post('/read', [MasterAdminController::class, 'read']);
            Route::post('/list', [MasterAdminController::class, 'list']);
            Route::post('/update', [MasterAdminController::class, 'update']);
            Route::post('/delete', [MasterAdminController::class, 'delete']);
        });
        
        Route::prefix('wallet')->group(function()
        {
            /* wallet controller route */
            Route::post('/show', [MasterAdminController::class, 'show']);
            Route::post('/index', [MasterAdminController::class, 'index']);
            Route::post('/edit', [MasterAdminController::class, 'edit']);
            Route::post('/destroy', [MasterAdminController::class, 'destroy']);
        });
    });
});
    
Route::post('/clear', function() {
    
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('optimize');

    return "
    cache:clear
    config:clear
    config:cache
    view:clear
    route:clear
    route:cache
    optimize
    Cleared!
    ";

});
