<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\PengembalianController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\Admin\AdminPeminjamanController;
use App\Http\Controllers\Api\Admin\AdminPengembalianController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']); // Login dan dapatkan token

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']); // Logout & revoke token
        Route::get('/me', [AuthController::class, 'profile']);           // Get user login
    });
});

Route::middleware('auth:sanctum')->group(function () {
    // 📦 Barang (untuk kebutuhan user melihat barang)
    Route::apiResource('/barang', BarangController::class)->only(['index', 'show']);

    // 📄 Peminjaman (oleh user mobile)
    Route::apiResource('/peminjaman', PeminjamanController::class);

    // 🔁 Pengembalian (oleh user mobile)
    Route::apiResource('/pengembalian', PengembalianController::class);

});

// 🔐 ADMIN API ROUTES
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    // 📄 Peminjaman (manajemen oleh admin)
    Route::get('/peminjaman', [AdminPeminjamanController::class, 'index']);
    Route::get('/peminjaman/{id}', [AdminPeminjamanController::class, 'show']);
    Route::post('/peminjaman', [AdminPeminjamanController::class, 'store']);
    Route::put('/peminjaman/{id}', [AdminPeminjamanController::class, 'update']);
    Route::delete('/peminjaman/{id}', [AdminPeminjamanController::class, 'destroy']);

    // 🔁 Pengembalian (approval oleh admin)
//    Route::get('/pengembalian', [AdminPengembalianController::class, 'index']);
//    Route::get('/pengembalian/{id}', [AdminPengembalianController::class, 'show']);
//    Route::put('/pengembalian/{id}/approve', [AdminPengembalianController::class, 'approve']);
//    Route::put('/pengembalian/{id}/reject', [AdminPengembalianController::class, 'reject']);
});
