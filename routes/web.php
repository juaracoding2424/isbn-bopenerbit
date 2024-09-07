<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IsbnDataController;
use App\Http\Controllers\IsbnMasalahController;
use App\Http\Controllers\IsbnPermohonanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DropZoneController;
use App\Http\Controllers\ProfilController;
use App\Http\Middleware\PenerbitMiddleware;

Route::group(['middleware' => PenerbitMiddleware::class], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('penerbit/dashboard', [DashboardController::class, 'index']);
    Route::get('penerbit/dashboard/year', [DashboardController::class, 'getYear']);
    Route::get('penerbit/dashboard/total-isbn', [DashboardController::class, 'getTotalIsbn']);
    Route::get('penerbit/dashboard/statistik-isbn', [DashboardController::class, 'getStatistikIsbn']);
    Route::get('penerbit/dashboard/berita', [DashboardController::class, 'getBerita']);

    Route::get('penerbit/isbn/data', [IsbnDataController::class, 'index']);
    Route::get('penerbit/isbn/data/datatable', [IsbnDataController::class, 'datatable']);
    Route::get('penerbit/isbn/data/detail/{noresi}', [IsbnDataController::class, 'detail']);

    Route::get('penerbit/isbn/masalah', [IsbnMasalahController::class, 'index']);
    Route::get('penerbit/isbn/masalah/datatable', [IsbnMasalahController::class, 'datatable']);

    Route::get('penerbit/isbn/permohonan', [IsbnPermohonanController::class, 'index']);
    Route::get('penerbit/isbn/permohonan/datatable', [IsbnPermohonanController::class, 'datatable']);
    Route::get('penerbit/isbn/permohonan/new', [IsbnPermohonanController::class, 'new']);
    Route::post('penerbit/isbn/permohonan/new/submit', [IsbnPermohonanController::class, 'submit']);
    Route::get('penerbit/isbn/permohonan/detail/{noresi}', [IsbnPermohonanController::class, 'detail']);
    Route::get('penerbit/isbn/permohonan/detail/{id}/get', [IsbnPermohonanController::class, 'getDetail']);
    Route::get('penerbit/isbn/permohonan/file/{id}', [IsbnPermohonanController::class, 'getFile']);
    Route::get('penerbit/isbn/permohonan/delete/{id}', [IsbnPermohonanController::class, 'rollback_permohonan']);

    Route::post('penerbit/dropzone/store', [DropZoneController::class, 'store']);
    Route::post('penerbit/dropzone/delete', [DropZoneController::class, 'delete']);

    Route::get('penerbit/profile', [ProfilController::class, 'index']);
    Route::get('penerbit/profile/detail', [ProfilController::class, 'getDetail']);

    Route::get('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/change-password', [AuthController::class, 'changePasswordIndex']);
    Route::post('auth/change-password/submit', [AuthController::class, 'changePasswordSubmit']);
});
Route::get('login', [AuthController::class, 'login']);
Route::post('auth/submit', [AuthController::class, 'submit']);


