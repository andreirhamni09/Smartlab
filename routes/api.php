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

    #PARAMETERS
        #1. GET PARAMETERS
        Route::get('getparameters', [ApiController::class, 'GetParameters']);
        #1. GET PARAMETERS
        
        #2. INSERT PARAMETERS
        Route::post('insertparameters/{simbol?}/{nama_unsur?}', [ApiController::class, 'InsertParameters']);
        #2. INSERT PARAMETERS
        
        #2. UPDATE PARAMETERS
        Route::post('updateparameters/{id?}/{simbol?}/{nama_unsur?}', [ApiController::class, 'UpdateParameters']);
        #2. UPDATE PARAMETERS

        #3. DELETE PARAMETERS
        Route::post('deleteparameters/{id?}', [ApiController::class, 'DeleteParameters']);
        #3. DELETE PARAMETERS
    #PARAMETERS

    #AKSES LEVELS
        #5. AKSES LEVELS
        Route::get('getakseslevels', [ApiController::class, 'GetAksesLevels']);
    #AKSES LEVELS

    #JENIS SAMPELS
        #6. JENIS SAMPELS
        Route::get('getjenissampel', [ApiController::class, 'GetJenisSampels']);
    #JENIS SAMPELS

    #METODES    
        #7. METODES
        Route::post('getmetodes', [ApiController::class, 'GetMetodes']);
        #7. METODES
    #METODES

    #DETAIL TRACKING
        #9. GET DETAIL TRACKING
        Route::get('getdetailtrackings/{data_sampels_id?}', [ApiController::class, 'GetDetailTrackings']);
        #9. GET DETAIL TRACKING

        #10. INSERT DETAIL TRACKING
        # LINK : https://slab.srs-ssms.com/api/admin/insertdetailtrackings/{aktivitas_waktu?}/{data_sampels_id?}/{aktivitas_id?}/{lab_akuns_id?}
        Route::post('insertdetailtrackings/{aktivitas_waktu?}/{data_sampels_id?}/{aktivitas_id?}/{lab_akuns_id?}', [ApiController::class, 'InsertDetailTrackings']);
        #10. INSERT DETAIL TRACKING
    #DETAIL TRACKING

    #DATA SAMPELS
        #11. GET DATA SAMPELS ALL
        Route::get('getdatasampelsall', [ApiController::class, 'GetDataSampelsAll']);

        #12. GET DATA SAMPELS BY ID
        Route::get('getdatasampelsbyid/{id?}', [ApiController::class, 'GetDataSampelsById']);

        #12. INSERT DATA SAMPELS
        Route::post('insertdatasampels/{jenis_sampels_id?}/{pelanggans_id?}/{pakets_id_s?}/{tanggal_masuk?}/{tanggal_selesai?}/{nomor_surat?}/{jumlah_sampel?}', [ApiController::class, 'InsertDataSampels']);
    #DATA SAMPELS

    #AKTIVITAS
        #GET DATA AKTIVITAS 
        Route::get('getaktivitas', [ApiController::class, 'GetAktivitas']);
        #GET DATA AKTIVITAS 
    #AKTIVITAS

    #GET HASIL ANALISISA
        # LINK : https://slab.srs-ssms.com/api/admin/gethasilanalisa/{data_sampels_id}
        Route::get('gethasilanalisas/{data_sampels_id?}', [ApiController::class, 'GetHasilAnalisas']);
    #GET HASIL ANALISISA
    
    #POST HASIL ANALISISA
        Route::match(['get', 'post'], 'posthasilanalisa/{id?}/{v_parameter?}', [ApiController::class, 'PostHasilAnalisa']);
    #POST HASIL ANALISISA

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

