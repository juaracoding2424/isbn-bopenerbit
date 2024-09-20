<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IsbnDataController;
use App\Http\Controllers\IsbnMasalahController;
use App\Http\Controllers\IsbnPermohonanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DropZoneController;
use App\Http\Controllers\KDTController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReportController;

use App\Http\Middleware\ProtectLoginMiddleware;
use App\Http\Middleware\PenerbitValidMiddleware;

Route::group(['middleware' => ProtectLoginMiddleware::class], function () {
    Route::group(['middleware' => PenerbitValidMiddleware::class], function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('penerbit/dashboard', [DashboardController::class, 'index']);
        Route::get('penerbit/dashboard/year', [DashboardController::class, 'getYear']);
        Route::get('penerbit/dashboard/total-isbn', [DashboardController::class, 'getTotalIsbn']);
        Route::get('penerbit/dashboard/statistik-isbn', [DashboardController::class, 'getStatistikIsbn']);
        Route::get('penerbit/dashboard/berita', [DashboardController::class, 'getBerita']);
        Route::get('penerbit/dashboard/kckr-perpusnas', [DashboardController::class, 'getKckrPerpusnas']);
        Route::get('penerbit/dashboard/kckr-provinsi', [DashboardController::class, 'getKckrProvinsi']);
        
        Route::get('penerbit/isbn/data', [IsbnDataController::class, 'index']);
        Route::get('penerbit/isbn/data/datatable', [IsbnDataController::class, 'datatable']);
        Route::get('penerbit/isbn/data/detail/{id}', [IsbnDataController::class, 'detail']);
        Route::get('penerbit/isbn/data/kdt/{id}', [IsbnDataController::class, 'getKDT']);
        Route::get('penerbit/isbn/data/generate-pdf/{id}', [IsbnDataController::class, 'generatePDF']);
        Route::get('penerbit/isbn/data/generate-barcode/{id}', [IsbnDataController::class, 'generateBarcode']);

        Route::get('penerbit/kdt/data', [KDTController::class, 'index']);
        Route::get('penerbit/kdt/data/datatable', [KDTController::class, 'datatable']);

        Route::get('penerbit/isbn/masalah', [IsbnMasalahController::class, 'index']);
        Route::get('penerbit/isbn/masalah/datatable', [IsbnMasalahController::class, 'datatable']);

        Route::get('penerbit/isbn/permohonan', [IsbnPermohonanController::class, 'index']);
        Route::get('penerbit/isbn/permohonan/datatable', [IsbnPermohonanController::class, 'datatable']);
        Route::get('penerbit/isbn/permohonan/new', [IsbnPermohonanController::class, 'new']);
        Route::post('penerbit/isbn/permohonan/new/submit', [IsbnPermohonanController::class, 'submit']);
        Route::get('penerbit/isbn/permohonan/detail/{noresi}', [IsbnPermohonanController::class, 'detail']);
        Route::get('penerbit/isbn/permohonan/detail/{id}/get', [IsbnPermohonanController::class, 'getDetail']);
        Route::get('penerbit/isbn/permohonan/jilid-lengkap', [IsbnPermohonanController::class, 'getJilidLengkap']);
        Route::get('penerbit/isbn/permohonan/file/{id}', [IsbnPermohonanController::class, 'getFile']);
        Route::get('penerbit/isbn/permohonan/delete/{id}', [IsbnPermohonanController::class, 'rollback_permohonan']);
        Route::get('penerbit/isbn/permohonan/delete-file/{id}', [IsbnPermohonanController::class, 'deleteFile']);

        Route::post('penerbit/dropzone/store', [DropZoneController::class, 'store']);
        Route::post('penerbit/dropzone/delete', [DropZoneController::class, 'delete']);

        Route::get('penerbit/history/data', [HistoryController::class, 'index']);

        Route::get('penerbit/report/isbn', [ReportController::class, 'index']);
        Route::get('penerbit/report/isbn/show-data', [ReportController::class, 'showData']);
        Route::get('penerbit/report/isbn/show-frequency', [ReportController::class, 'showFrequency']);
    });
    
        Route::get('penerbit/dashboard/notvalid', [DashboardController::class, 'notValid']);
        Route::get('penerbit/profile', [ProfilController::class, 'index']);
        Route::get('penerbit/profile/detail', [ProfilController::class, 'getDetail']);
        Route::post('penerbit/profile/submit', [ProfilController::class, 'submit']);

        Route::get('auth/logout', [AuthController::class, 'logout']);

        Route::get('penerbit/change-password', [ChangePasswordController::class, 'index']);
        Route::post('penerbit/change-password/submit', [ChangePasswordController::class, 'submit']);

        Route::get('location/province', [LocationController::class, 'getProvince']);
        Route::get('location/kabupaten/{id}', [LocationController::class, 'getKabupaten']);
        Route::get('location/kecamatan/{id}', [LocationController::class, 'getKecamatan']);
        Route::get('location/kelurahan/{id}', [LocationController::class, 'getKelurahan']);

});
Route::get('login', [AuthController::class, 'login']);
Route::post('auth/submit', [AuthController::class, 'submit']);
Route::get('penerbit/isbn/data/view-kdt/{id}', [IsbnDataController::class, 'viewPDF']);


