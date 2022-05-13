<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategorieController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {

        // Below mention routes are public, user can access those without any restriction.
        // Create New User
        Route::post('register', [AuthController::class, 'register']);

        // Login User
        Route::post('login', [AuthController::class, 'login']);
        
        // Refresh the JWT Token
        Route::get('refresh', [AuthController::class, 'refresh']);
        
        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:api')->group(function () {
            // Get user info
            Route::get('user', [AuthController::class, 'user']);
            
            // Logout user from application
            Route::post('logout', [AuthController::class, 'logout']);
            
            // Products request
            Route::prefix('products')->group(function () {
                Route::get('/', [ProductController::class, 'index']);

                Route::post('add', [ProductController::class, 'create']);
    
                Route::get('show/{id}', [ProductController::class, 'show']);

                Route::post('update/{id}', [ProductController::class, 'update']);
    
                Route::delete('delete/{id}', [ProductController::class, 'destroy']);
            });

            // Categories request
            Route::prefix('categories')->group(function () {
                Route::get('/', [CategorieController::class, 'index']);
            });

        });
    });
});