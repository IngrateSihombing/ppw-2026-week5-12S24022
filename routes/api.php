
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BukuApiController;
use App\Http\Controllers\Api\V1\AuthApiController;
use App\Http\Controllers\Api\V1\OpenLibraryController;

Route::prefix('v1')->group(function () {

    // Endpoint login (publik)
    Route::post('/login', [AuthApiController::class, 'login']);

    // Endpoint yang membutuhkan autentikasi
    Route::middleware('auth:sanctum')->group(function () {

        // Daftar buku SIPUS-Del
        Route::get('/bukus', [BukuApiController::class, 'index']);

        // Pencarian metadata buku dari OpenLibrary
        Route::get('/openlibrary/search', [OpenLibraryController::class, 'search']);

        // Logout
        Route::post('/logout', [AuthApiController::class, 'logout']);

    });

});
