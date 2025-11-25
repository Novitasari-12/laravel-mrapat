<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\GetDataController;
use App\Http\Controllers\Api\NotulenController;
use App\Http\Controllers\Api\RapatController;
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

Route::group(['prefix' => 'document'], function () {
    // Route::post('/', 'Api\DocumentController@postDocument')->name('post.document');
    Route::get('/{keyDocument}', [DocumentController::class, 'getDocument'])->name('get.document');
});

Route::group(['prefix' => 'absensi'], function () {
    Route::post('/login', [AbsensiController::class, 'loginV2']);
    Route::post('/', [AbsensiController::class, 'absensi']);
    Route::post('/change_password/{phone_key}', [AbsensiController::class, 'changePassword']);
    Route::post('/change_profile/{phone_key}', [AbsensiController::class, 'changeProfile']);
});

Route::group(['prefix' => 'action'], function () {
    Route::post('/batal_persetujuan_rapat', [AbsensiController::class, 'batalPersetujuanRapat']);
    Route::post('/batal_publish_notulen', [NotulenController::class, 'batalPublishNotulen']);
});

Route::group(['prefix' => 'data'], function () {
    Route::post('/', [GetDataController::class, 'getData']);
    Route::get('/', [BannerController::class, 'index']);
});

Route::group(['prefix' => 'rapat'], function () {
    Route::get('/{id}', [RapatController::class, 'show']);
});
