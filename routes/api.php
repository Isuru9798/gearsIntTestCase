<?php

use App\Http\Controllers\admin\author\AuthorController;
use App\Http\Controllers\admin\book\BookController;
use App\Http\Controllers\authentication\LoginController;
use App\Http\Controllers\authentication\RegisterController;
use App\Http\Controllers\author\AuthorBookController;
use App\Http\Controllers\front\FrontController;
use App\Http\Controllers\upload\ImageUploadController;
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
        Route::prefix('books')->group(function () {
            Route::get('books', [BookController::class, 'getBooks']);
            Route::get('get-books-by-author', [BookController::class, 'getBooksByAuthor']);
            Route::get('get-books-by-id',  [BookController::class, 'getBooksById']);
            Route::post('action',  [BookController::class, 'action']);
        });
    });

    // author routes
    Route::prefix('author')->group(function () {
        Route::get('get-books', [AuthorBookController::class, 'getBooks']);
        Route::post('add-book', [AuthorBookController::class, 'addBook']);
        Route::get('get-books-by-id', [AuthorBookController::class, 'getBooksById']);
    });

    // image upload route
    Route::prefix('upload')->group(function () {
        Route::post('cover-image', [ImageUploadController::class, 'store']);
    });

    // get user permission
    Route::get('authentication/get-permission', [LoginController::class, 'getUserPermission']);
});

Route::get('get-books', [FrontController::class, 'getBooks']);
