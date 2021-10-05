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

#1 - 4 PARAMETERS
    #1. GET PARAMETERS
    Route::get('getparameters', [ApiController::class, 'GetParameters']);
    #1. GET PARAMETERS
    
    #2. INSERT PARAMETERS
    Route::post('insertparameters/{simbol?}/{nama_unsur?}', [ApiController::class, 'InsertParameters']);
    #2. INSERT PARAMETERS
    
    #3. UPDATE PARAMETERS
    Route::post('updateparameters/{id?}/{simbol?}/{nama_unsur?}', [ApiController::class, 'UpdateParameters']);
    #3. UPDATE PARAMETERS

    #4. DELETE PARAMETERS
    Route::get('deleteparameters/{id?}', [ApiController::class, 'DeleteParameters']);
    #4. DELETE PARAMETERS
#1 - 4 PARAMETERS

#5 AKSES LEVEL
    #5. GET AKSES LEVELS
    Route::get('getakseslevels', [ApiController::class, 'GetAksesLevels']);
#5 AKSES LEVEL

#6 JENIS SAMPEL
    #6. GET JENIS SAMPELS
    Route::get('getjenissampel', [ApiController::class, 'GetJenisSampels']);
#6 JENIS SAMPEL

#7 METODES    
    #7. GET METODES
    Route::get('getmetodes', [ApiController::class, 'GetMetodes']);
    #7. GET METODES
#7 METODES

#8 HALAMANS
    #8. GET HALAMANS
    Route::get('gethalamans', [ApiController::class, 'GetHalamans']);
    #8. GET HALAMANS
#8 HALAMANS

#9 - 10 DETAIL TRACKING
    #9. GET DETAIL TRACKING
    Route::get('getdetailtrackings/{data_sampels_id?}', [ApiController::class, 'GetDetailTrackings']);
    #9. GET DETAIL TRACKING

    #10. INSERT DETAIL TRACKING
    # LINK : https://slab.srs-ssms.com/api/admin/insertdetailtrackings/{aktivitas_waktu?}/{data_sampels_id?}/{aktivitas_id?}/{lab_akuns_id?}
    Route::post('insertdetailtrackings/{aktivitas_waktu?}/{data_sampels_id?}/{aktivitas_id?}/{lab_akuns_id?}', [ApiController::class, 'InsertDetailTrackings']);
    #10. INSERT DETAIL TRACKING
#9 - 10 DETAIL TRACKING

#11 - 14 DATA SAMPELS
    #11. GET DATA SAMPELS ALL
    Route::get('getdatasampelsall', [ApiController::class, 'GetDataSampelsAll']);

    #12. GET DATA SAMPELS BY ID
    Route::get('getdatasampelsbyid/{id?}', [ApiController::class, 'GetDataSampelsById']);

    #13. INSERT DATA SAMPELS
    Route::post('insertdatasampels/{jenis_sampels_id?}/{pelanggans_id?}/{pakets_id_s?}/{tanggal_masuk?}/{tanggal_selesai?}/{nomor_surat?}/{jumlah_sampel?}/{status?}', [ApiController::class, 'InsertDataSampels']);

    #14. DELETE DATA SAMPELS 
    Route::get('deletedatasampels/{id?}', [ApiController::class, 'DeleteDataSampels']);    
#11 - 14 DATA SAMPELS

#16 - 17 HASIL ANALISA
    #15. GET HASIL ANALISA
    Route::get('gethasilanalisas/{data_sampels_id?}', [ApiController::class, 'GetHasilAnalisas']);
    #15. GET HASIL ANALISA

    #16. UPDATE HASIL ANALISA
    Route::post('updatehasilanalisas/{id?}/{hasil?}', [ApiController::class, 'UpdateHasilAnalisas']);
    #16. UPDATE HASIL ANALISA        
#16 - 17 HASIL ANALISA

#17 - 21 PELANGGANS
    #17. GET PELANGGANS
    Route::get('getpelanggans', [ApiController::class, 'GetPelanggans']);

    #18. INSERT PELANGGANS
    Route::post('insertpelanggans/{email?}/{password?}/{nama?}/{perusahaan?}/{nomor_telepon?}/{alamat?}/{tanggal_registrasi?}', [ApiController::class, 'InsertPelanggans']);

    #19. UPDATE PELANGGANS
    Route::post('updatepelanggans/{id?}/{email?}/{password?}/{nama?}/{perusahaan?}/{nomor_telepon?}/{alamat?}/{tanggal_registrasi?}', [ApiController::class, 'UpdatePelanggans']);
    
    #20. DELETE PELANGGANS
    Route::post('deletepelanggans/{id?}', [ApiController::class, 'DeletePelanggans']);

    #21. LOGIN PELANGGANS
    Route::post('loginpelanggans/{email?}/{password?}', [ApiController::class, 'LoginPelanggans']);
#17 - 21 PELANGGANS

#22 AKTIVITAS
    #22. GET DATA AKTIVITAS 
    Route::get('getaktivitas', [ApiController::class, 'GetAktivitas']);
    #22. GET DATA AKTIVITAS 
#22 AKTIVITAS

#23 - 27 LAB AKUN
    #23. UPDATE LAB AKUNS
    Route::get('/getakunlabs', [ApiController::class, 'GetAkunLabs']);

    #24. LOGIN USERLAB 
    Route::post('loginuserlab/{email?}/{password?}', [ApiController::class, 'LoginUserLab']);
    
    #25. UPDATE LAB AKUNS
    Route::post('/updatelabakuns/{id?}/{metodes_id_s?}/{akses_levels_id?}/{nama?}/{email?}/{password?}/{jabatan?}/{status_akun?}', [ApiController::class, 'UpdateLabAkuns']);

    #26. INSERT LAB AKUNS
    Route::post('/insertlabakuns/{metodes_id_s?}/{akses_levels_id?}/{nama?}/{email?}/{password?}/{jabatan?}/{status_akun?}', [ApiController::class, 'InsertLabAkuns']);

    #27. DELETE LAB AKUNS
    Route::post('/deletelabakuns/{id?}', [ApiController::class, 'DeleteLabAkuns']);
    
#23 - 27 LAB AKUN

#28 - 31 PAKETS
    #28. GET PAKETS
    Route::get('getpakets', [ApiController::class, 'GetPakets']);
    #28. GET PAKETS
    
    #29 . INSERT PAKETS
    Route::post('insertpakets/{jenis_sampels_id?}/{paket?}/{parameters_id_s?}/{harga?}', [ApiController::class, 'InsertPakets']);
    #29 . INSERT PAKETS

    #30. UPDATE PAKETS
    Route::post('updatepakets/{id?}/{jenis_sampels_id?}/{paket?}/{parameters_id_s?}/{harga?}', [ApiController::class, 'UpdatePakets']);
    #30. UPDATE PAKETS

    #31. DELETE PAKETS
    Route::get('deletepakets/{id?}', [ApiController::class, 'DeletePakets']);
    #31. DELETE PAKETS
#28 - 31 PAKETS

#32 - 35 GROUP AKTIVITAS
    Route::get('getgroupaktivitas', [ApiController::class, 'GetGroupAktivitas']);

    
    Route::post('insertgroupaktivitas/{group?}', [ApiController::class, 'InsertGroupAktivitas']);

    
    Route::post('updategroupaktivitas/{id?}/{group?}', [ApiController::class, 'UpdateGroupAktivitas']);

    
    Route::get('deletegroupaktivitas/{id?}', [ApiController::class, 'DeleteGroupAktivitas']);
#32 - 35 GROUP AKTIVITAS
});

