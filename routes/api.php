<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JWTValidation;
use App\Http\Controllers\API\TokenController;
use App\Http\Controllers\API\PermohonanController;
use App\Http\Controllers\API\PenerbitController;
use App\Http\Controllers\API\ISBNController;

Route::match(array('GET', 'POST'),'/token', [TokenController::class, 'getToken']);

Route::group(['middleware' => JWTValidation::class], function () {
    Route::match(array('GET', 'POST'),'/permohonan/tracking/{noresi}', [PermohonanController::class, 'tracking']);
    Route::match(array('GET', 'POST'), '/permohonan/submit', [PermohonanController::class, 'submit']);
    Route::match(array('GET', 'POST'), '/penerbit/detail', [PenerbitController::class, 'detail']);

    Route::match(array('GET', 'POST'), '/isbn/data', [ISBNController::class, 'data']);
});