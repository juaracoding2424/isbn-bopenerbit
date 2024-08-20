<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IsbnDataController;
use App\Http\Controllers\IsbnMasalahController;
use App\Http\Controllers\IsbnPermohonanController;

Route::get('/', [DashboardController::class, 'index']);
Route::get('penerbit/dashboard', [DashboardController::class, 'index']);
Route::get('penerbit/dashboard/total-isbn', [DashboardController::class, 'getTotalIsbn']);
Route::get('penerbit/dashboard/statistik-isbn', [DashboardController::class, 'getStatistikIsbn']);
Route::get('penerbit/dashboard/berita', [DashboardController::class, 'getBerita']);
Route::get('penerbit/isbn/data', [IsbnDataController::class, 'index']);
Route::get('penerbit/isbn/data/datatable', [IsbnDataController::class, 'datatable']);
Route::get('penerbit/isbn/masalah', [IsbnMasalahController::class, 'index']);
Route::get('penerbit/isbn/masalah/datatable', [IsbnMasalahController::class, 'datatable']);
Route::get('penerbit/isbn/permohonan', [IsbnPermohonanController::class, 'index']);
Route::get('penerbit/isbn/permohonan/datatable', [IsbnPermohonanController::class, 'datatable']);
Route::get('penerbit/isbn/permohonan/new', [IsbnPermohonanController::class, 'new']);