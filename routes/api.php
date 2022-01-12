<?php

use App\Http\Controllers\admin\author\AuthorController;
use App\Http\Controllers\admin\book\BookController;
use App\Http\Controllers\authentication\LoginController;
use Illuminate\Support\Facades\Route;

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

// authentication routes
Route::prefix('authentication')->group(function () {
    Route::post('login', [LoginController::class, 'login']); // author login
    Route::post('register', [RegisterController::class, 'store']); // author register
    Route::post('admin/login', [LoginController::class, 'adminLogin']); // admin login
});

Route::middleware('auth:api')->group(function () {

    // admin routes
    Route::prefix('admin')->group(function () {
        Route::prefix('authors')->group(function () {
            Route::get('authors', [AuthorController::class, 'getAuthors']);
            Route::get('author-by-id', [AuthorController::class, 'getAuthorById']);
            Route::post('action', [AuthorController::class, 'action']);
        });
       
    });

    
});
