<?php

use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\PengembalianController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ApprovalPeminjamanController;
use App\Http\Controllers\Admin\ApprovalPengembalianController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/laporanbarang', [BarangController::class, 'downloadbarang'])->name('downloadbarang');
Route::get('/laporanpeminjaman', [PeminjamanController::class, 'downloadpeminjaman'])->name('downloadpeminjaman');
Route::get('/laporanpengembalian', [PengembalianController::class, 'downloadpengembalian'])->name('downloadpengembalian');

// 🔒 Approval Peminjaman (via Filament Panel)
Route::prefix('admin/approval/peminjaman')->name('admin.approval.peminjaman.')->group(function () {
    Route::get('/', [ApprovalPeminjamanController::class, 'index'])->name('index');
    Route::get('/{id}', [ApprovalPeminjamanController::class, 'show'])->name('show');
    Route::post('/{id}/approve', [ApprovalPeminjamanController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject', [ApprovalPeminjamanController::class, 'reject'])->name('reject');
});

// 🔒 Approval Pengembalian (via Filament Panel)
Route::prefix('admin/approval/pengembalian')->name('admin.approval.pengembalian.')->group(function () {
    Route::get('/', [ApprovalPengembalianController::class, 'index'])->name('index');
    Route::get('/{id}', [ApprovalPengembalianController::class, 'show'])->name('show');
    Route::post('/{id}/approve', [ApprovalPengembalianController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject', [ApprovalPengembalianController::class, 'reject'])->name('reject');
});
