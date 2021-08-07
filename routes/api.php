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
        # LINK : https://slab.srs-ssms.com/api/admin/loginuserlab 
        # FUNGSI UNTUK LOGIN APLIKASI SMARTLAB ANDROID
        # PARAMETER PARSING DARI APLIKASI SMARTLAB ANDROID
            # ~ email, ~ password
        # RESPON
            # BEHASIL   : ~ success = 1, ~ id, ~ nama, ~ id_akses, ~ jabatan, ~ email, ~ password
            # GAGAL     : ~ success = 0, ~ message
    Route::match(['get', 'post'], 'loginuserlab/{email?}/{password?}', [ApiController::class, 'LoginUserLab']);
    # LOGIN USERLAB

    #GET DATA AKTIVITAS 
        # LINK : https://slab.srs-ssms.com/api/admin/getaktivitas 
        # FUNGSI UNTUK MENDAPATKAN DAFTAR AKTIVITAS YANG TERDAPAT DALAM DATABASE
        # RESPON
            # DATA = 0      : ~ success = 0, ~ message
            # DATA != 0     : ~ success = 1, ~ aktivitas_id, ~ aktivitas
    Route::match(['get', 'post'], 'getaktivitas', [ApiController::class, 'GetAktivitas']);
    #GET DATA AKTIVITAS 

    #UPDATE PROSES
        # LINK : https://slab.srs-ssms.com/api/admin/updateproses 
        # FUNGSI UNTUK MELAKUKAN UPDATE DATA TRACKING BERDASARKAN AKTIVITAS YANG DILAKUKAN PEKERJA LAB
        #        TERHADAP PARAMETER
        # PARAMETER PARSING DARI APLIKASI SMARTLAB ANDROID
            # ~ aktivitas_waktu, ~ tracking_id, ~ aktivitas_id, ~ petugas_id
        # RESPON
            # PARAMETER YANG DIKIRIM NILAINYA
            #       KOSONG /QUERY INSERT BERMASALAH    : ~ success = 0, ~ message
            # DATA BERHASIL DIINPUTKAN                 : ~ success = 1, ~ message
    Route::match(['get', 'post'], 'updateproses/{aktivitas_waktu?}/{tracking_id?}/{aktivitas_id?}/{petugas_id?}', [ApiController::class, 'UpdateProses']);
    #UPDATE PROSES

    #GET JENIS SAMPEL
        # LINK : https://slab.srs-ssms.com/api/admin/getjenissampel 
        # FUNGSI UNTUK MENDAPATKAN DAFTAR JENIS SAMPEL YANG TERDAPAT DALAM DATABASE
        # RESPON
            # DATA = 0      : ~ success = 0, ~ message
            # DATA != 0     : ~ success = 1, ~ id, ~ jenis_sampel, ~ lambang_sampel
    Route::match(['get', 'post'], 'getjenissampel', [ApiController::class, 'GetJenisSampel']);
    #GET JENIS SAMPEL

    #GET PARAMETER
        # LINK : https://slab.srs-ssms.com/api/admin/getparameter 
        # FUNGSI UNTUK MENDAPATKAN DAFTAR PARAMETER YANG TERDAPAT DALAM DATABASE
        # RESPON
            # DATA = 0      : ~ success = 0, ~ message
            # DATA != 0     : ~ success = 1, ~ id_parameter, ~ parameter, ~ harga, ~ id_jenis_sampel, ~ jenis_sampel, ~ lambang
    Route::match(['get', 'post'], 'getparameter', [ApiController::class, 'GetParameter']);
    #GET PARAMETER


    #GET HASIL ANALISISA
        # LINK : https://slab.srs-ssms.com/api/admin/gethasilanalisa
    Route::match(['get', 'post'], 'gethasilanalisa/{kupa_id?}', [ApiController::class, 'GetHasilAnalisa']);
    #GET HASIL ANALISISA
    
    #POST HASIL ANALISISA
        # LINK : https://slab.srs-ssms.com/api/admin/posthasilanalisa
        Route::match(['get', 'post'], 'posthasilanalisa/{id?}/{v_parameter?}', [ApiController::class, 'PostHasilAnalisa']);
    #POST HASIL ANALISISA
});

