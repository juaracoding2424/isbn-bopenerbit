<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IsbnBatalController;
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
        Route::get('penerbit/isbn/data/kdt/{id}', [IsbnDataController::class, 'viewPDF']);
        
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
        Route::get('penerbit/isbn/permohonan/detail-jilid/{id}', [IsbnPermohonanController::class, 'getDetailJilid']);
        Route::get('penerbit/isbn/permohonan/jilid-lengkap', [IsbnPermohonanController::class, 'getJilidLengkap']);
        Route::get('penerbit/isbn/permohonan/file/{id}', [IsbnPermohonanController::class, 'getFile']);
        Route::get('penerbit/isbn/permohonan/delete/{id}', [IsbnPermohonanController::class, 'rollback_permohonan']);
        Route::get('penerbit/isbn/permohonan/delete-file/{id}', [IsbnPermohonanController::class, 'deleteFile']);
        Route::post('penerbit/isbn/permohonan/check/title', [IsbnPermohonanController::class, 'checkTitleExists']);
        Route::post('penerbit/isbn/permohonan/check/bulan-terbit-min', [IsbnPermohonanController::class, 'checkBulanTerbitMin']);
        Route::post('penerbit/isbn/permohonan/check/tahun-terbit-min', [IsbnPermohonanController::class, 'checkTahunTerbitMin']);

        Route::get('penerbit/isbn/batal', [IsbnBatalController::class, 'index']);
        Route::get('penerbit/isbn/batal/datatable', [IsbnBatalController::class, 'datatable']);
        Route::get('penerbit/isbn/batal/pulihkan-permohonan/{id}', [IsbnBatalController::class, 'pulihkanPermohonan']);
        Route::get('penerbit/isbn/batal/detail/{id}/get', [IsbnPermohonanController::class, 'getDetail']);

        Route::post('penerbit/dropzone/store', [DropZoneController::class, 'store']);
        Route::post('penerbit/dropzone/delete', [DropZoneController::class, 'delete']);

       

        Route::get('penerbit/report/isbn', [ReportController::class, 'index']);
        Route::get('penerbit/report/isbn/show-data', [ReportController::class, 'showData']);
        Route::get('penerbit/report/isbn/show-frequency', [ReportController::class, 'showFrequency']);
    });
    
        Route::get('penerbit/dashboard/notvalid', [DashboardController::class, 'notValid']);
        Route::get('penerbit/profile', [ProfilController::class, 'index']);
        Route::get('penerbit/profile/detail', [ProfilController::class, 'getDetail']);
        Route::post('penerbit/profile/submit', [ProfilController::class, 'submit']);
        Route::post('penerbit/profile/change-email', [ProfilController::class, 'changeEmail']);

        Route::get('auth/logout', [AuthController::class, 'logout']);

        Route::get('penerbit/change-password', [ChangePasswordController::class, 'index']);
        Route::post('penerbit/change-password/submit', [ChangePasswordController::class, 'submit']);

        Route::get('location/province', [LocationController::class, 'getProvince']);
        Route::get('location/kabupaten/{id}', [LocationController::class, 'getKabupaten']);
        Route::get('location/kecamatan/{id}', [LocationController::class, 'getKecamatan']);
        Route::get('location/kelurahan/{id}', [LocationController::class, 'getKelurahan']);

        Route::get('penerbit/history', [HistoryController::class, 'index']);
        Route::get('penerbit/history/data', [HistoryController::class, 'data']);
        Route::get('penerbit/history/datatable', [HistoryController::class, 'datatable']);

});
Route::get('/', [AuthController::class, 'login']);
Route::get('login', [AuthController::class, 'login']);
Route::get('reset-password', [AuthController::class, 'resetPassword']);
Route::post('reset-password/send', [AuthController::class, 'resetPasswordSend']);
Route::get('reset-password-next', [AuthController::class, 'resetPasswordNext']);
Route::post('reset-password-next', [AuthController::class, 'resetPasswordNextSubmit']);
Route::post('auth/submit', [AuthController::class, 'submit']);
Route::match(array('GET', 'POST'), 'page/redirect', [AuthController::class, 'redirectFromLandingPage']);


Route::get('penerbit/isbn/data/view-kdt/{id}', [IsbnDataController::class, 'viewPDF']);
Route::get('penerbit/isbn/data/generate-pdf/{id}', [IsbnDataController::class, 'generatePDF']);
Route::get('penerbit/isbn/data/generate-barcode/{id}', [IsbnDataController::class, 'generateBarcode']);