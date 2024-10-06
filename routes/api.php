<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JWTValidation;
use App\Http\Controllers\API\TokenController;
use App\Http\Controllers\API\PermohonanController;
use App\Http\Controllers\API\PenerbitController;
use App\Http\Controllers\API\ISBNController;
use App\Http\Controllers\API\SSOController;
use App\Http\Controllers\API\DepositController;

Route::match(array('GET', 'POST'),'/token', [TokenController::class, 'getToken']);

Route::group(['middleware' => JWTValidation::class], function () {
    Route::match(array('GET', 'POST'),'/permohonan/data', [PermohonanController::class, 'data']);
    Route::match(array('GET', 'POST'),'/permohonan/tracking/{noresi}', [PermohonanController::class, 'tracking']);
    Route::match(array('GET', 'POST'), '/permohonan/submit', [PermohonanController::class, 'submit']);
    Route::match(array('GET', 'POST'), '/permohonan/perbaikan/{noresi}', [PermohonanController::class, 'perbaikan']);
    Route::match(array('GET', 'POST'), '/penerbit/detail', [PenerbitController::class, 'detail']);

    Route::match(array('GET', 'POST'), '/isbn/data', [ISBNController::class, 'data']);
});

Route::post('/sso/login', [SSOController::class, 'login']);
Route::post('/isbn/detail', [DepositController::class, 'getIsbn']);
Route::post('/isbn/terima/perpusnas', [DepositController::class, 'receivedPerpusnas']);
Route::post('/isbn/terima/provinsi', [DepositController::class, 'receivedProvinsi']);