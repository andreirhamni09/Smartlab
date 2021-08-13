<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin')->group(function () {
    # LOGIN USERLAB 
    Route::match(['get', 'post'], 'loginuserlab/{email?}/{password?}', [ApiController::class, 'LoginUserLab']);
    # LOGIN USERLAB sdsds

    #PARAMETER
    Route::get('getparameter', [ApiController::class, 'GetParameters']);
    #PARAMETER

    #GET JENIS SAMPEL
    Route::get('getjenissampel', [ApiController::class, 'GetJenisSampels']);
    #GET JENIS SAMPEL

    #GET AKSES LEVEL
    Route::get('getakseslevels', [ApiController::class, 'GetAksesLevels']);
    #GET AKSES LEVEL

#AKTIVITAS
    #GET DATA AKTIVITAS 
    Route::get('getaktivitas', [ApiController::class, 'GetAktivitas']);
    #GET DATA AKTIVITAS 
#AKTIVITAS


#DETAIL TRACKING
    #9. GET DETAIL TRACKING
    Route::get('getdetailtrackings/{data_sampels_id?}', [ApiController::class, 'GetDetailTrackings']);
    #9. GET DETAIL TRACKING

    #UPDATE PROSES
    # LINK : https://slab.srs-ssms.com/api/admin/insertdetailtrackings/{aktivitas_waktu?}/{data_sampels_id?}/{aktivitas_id?}/{lab_akuns_id?}
    Route::post('insertdetailtrackings/{aktivitas_waktu?}/{data_sampels_id?}/{aktivitas_id?}/{lab_akuns_id?}', [ApiController::class, 'InsertDetailTrackings']);
    #UPDATE PROSES
#DETAIL TRACKING


    #GET PARAMETER
        # LINK : https://slab.srs-ssms.com/api/admin/getparameter 
        # FUNGSI UNTUK MENDAPATKAN DAFTAR PARAMETER YANG TERDAPAT DALAM DATABASE
        # RESPON
            # DATA = 0      : ~ success = 0, ~ message
            # DATA != 0     : ~ success = 1, ~ id_parameter, ~ parameter, ~ harga, ~ id_jenis_sampel, ~ jenis_sampel, ~ lambang
    #GET PARAMETER


    #GET HASIL ANALISISA
    # LINK : https://slab.srs-ssms.com/api/admin/gethasilanalisa/{data_sampels_id}
    Route::get('gethasilanalisas/{data_sampels_id?}', [ApiController::class, 'GetHasilAnalisas']);
    #GET HASIL ANALISISA
    
    #POST HASIL ANALISISA
    Route::match(['get', 'post'], 'posthasilanalisa/{id?}/{v_parameter?}', [ApiController::class, 'PostHasilAnalisa']);
    #POST HASIL ANALISISA

#METODES    
    #GET METODES
    Route::post('getmetodes', [ApiController::class, 'GetMetodes']);
    #GET METODES
#METODES

#PAKETS
    #SELECT PAKETS
    Route::post('getpakets', [ApiController::class, 'GetPakets']);
    #SELECT PAKETS
    
    #INSERT PAKETS
    Route::post('insertpakets/{jenis_sampels_id?}/{paket?}/{parameters_id_s?}/{harga?}', [ApiController::class, 'InsertPakets']);
    #INSERT PAKETS

    #UPDATE PAKETS
    Route::post('updatepakets/{id?}/{jenis_sampels_id?}/{paket?}/{parameters_id_s?}/{harga?}', [ApiController::class, 'UpdatePakets']);
    #UPDATE PAKETS

    #DELETE PAKETS
    Route::get('deletepakets/{id?}', [ApiController::class, 'DeletePakets']);
    #DELETE PAKETS
#PAKETS
});

