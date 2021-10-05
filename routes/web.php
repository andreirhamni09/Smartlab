<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;


Route::get('/', function () {
    return view('login');
})->name('login');
Route::post('/login_p', [MasterController::class, 'LoginPelanggan']);
Route::get('/tracking', [MasterController::class, 'TrackingPelanggan'])
->name('tracking');

Route::get('/logout', [MasterController::class, 'Logout']);

Route::post('/cekresi', [MasterController::class, 'CekResi']);


Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect('admin/login');
    });

#1 - 4 PARAMETER
    Route::get('/parameters', [MasterController::class, 'Parameters']);
    Route::post('/insertparameters', [MasterController::class, 'InsertParameter']);
    Route::post('/updateparameters', [MasterController::class, 'UpdateParameters']);
    Route::get('/deleteparameters/{id?}', [MasterController::class, 'DeleteParameters']);
#1 - 4 PARAMETER

#5 AKSES_LEVELS
    Route::get('/akseslevels', [MasterController::class, 'AksesLevels']);
    Route::post('/insertakseslevels', [MasterController::class, 'InsertAksesLevels']);
    Route::post('/updateakseslevels', [MasterController::class, 'UpdateAksesLevels']);
    Route::get('/deleteakseslevels/{id?}', [MasterController::class, 'DeleteAksesLevels']);
#5 AKSES_LEVELS

#6 JENIS SAMPELS
    Route::get('/jenissampels', [MasterController::class, 'JenisSampels']);
    Route::post('/insertjenissampels', [MasterController::class, 'InsertJenisSampels']);
    Route::post('/updatejenissampels', [MasterController::class, 'UpdateJenisSampels']);
    Route::get('/deletejenissampels/{id?}', [MasterController::class, 'DeleteJenisSampels']);
#6 JENIS SAMPELS

#7 METODE
    Route::get('/metodes', [MasterController::class, 'Metodes']);
    Route::post('/insertmetodes', [MasterController::class, 'InsertMetodes']);
    Route::post('/updatemetodes', [MasterController::class, 'UpdateMetodes']);
    Route::get('/deletemetodes/{id?}', [MasterController::class, 'DeleteMetodes']);
#7 METODE

#8 HALAMANS
    Route::get('/halamans', [MasterController::class, 'Halamans']);
    Route::post('/inserthalamans', [MasterController::class, 'InsertHalamans']);
    Route::post('/updatehalamans', [MasterController::class, 'UpdateHalamans']);
    Route::get('/deletehalamans/{id?}', [MasterController::class, 'DeleteHalamans']);
#8 HALAMANS

#11 - 14 DATA SAMPEL
    Route::get('/datasampels', [MasterController::class, 'DataSampels']);
    Route::post('/insertdatasampels', [MasterController::class, 'InsertDataSampels']);
#11 - 14 DATA SAMPEL


#17 - 21 PELANGGAN
    Route::get('/pelanggans', [MasterController::class, 'GetPelanggans']);
    Route::post('/insertpelanggans', [MasterController::class, 'InsertPelanggans']);
    Route::post('/updatepelanggans', [MasterController::class, 'UpdatePelanggans']);
    Route::get('/deletepelanggans/{id?}', [MasterController::class, 'DeletePelanggans']);
#17 - 21 PELANGGAN

#22 AKTIVITAS
    Route::get('/aktivitas', [MasterController::class, 'GetAktivitas']);
    Route::post('/insertaktivitas', [MasterController::class, 'InsertAktivitas']);
    Route::post('/updateaktivitas', [MasterController::class, 'UpdateAktivitas']);
    Route::get('/deleteaktivitas/{id?}', [MasterController::class, 'DeleteAktivitas']);
#22 AKTIVITAS

#23 - 27 LAB AKUNS    
    Route::get('/labakuns', [MasterController::class, 'GetLabAkuns']);
    Route::post('/insertlabakuns', [MasterController::class, 'InsertLabAkuns']);
    Route::post('/updatelabakuns', [MasterController::class, 'UpdateLabAkuns']);
    Route::get('/deletelabakuns/{id?}', [MasterController::class, 'DeleteLabAkuns']);
    Route::post('/loginlabakuns', [MasterController::class, 'LoginLabAkuns']);
#23 - 27 LAB AKUNS

#28 - 31 PAKETS
    Route::get('/pakets', [MasterController::class, 'Pakets']);
    Route::post('/insertpakets', [MasterController::class, 'InsertPakets']);
    Route::post('/updatepakets', [MasterController::class, 'UpdatePakets']);
    Route::get('/deletepakets/{id?}', [MasterController::class, 'DeletePakets']);
#28 - 31 PAKETS

#32 - 35 GRUP AKTIVITAS
    #GET GRUP AKTIVITAS
    Route::get('groupaktivitas', [MasterController::class, 'GetGroupAktivitas']);
    
    #GET GRUP AKTIVITAS
    Route::post('insertgroupaktivitas', [MasterController::class, 'InsertGroupAktivitas']);
    
    #GET GRUP AKTIVITAS
    Route::post('updategroupaktivitas', [MasterController::class, 'UpdateGroupAktivitas']);
    
    #GET GRUP AKTIVITAS
    Route::get('deletegroupaktivitas/{id?}', [MasterController::class, 'DeleteGroupAktivitas']);

    Route::get('ajaxtest', [MasterController::class, 'AjaxTest']);
#32 - 35 GRUP AKTIVITAS

    Route::get('/login', [MasterController::class, 'Login']);
    Route::get('/register', [MasterController::class, 'Register']);

    #INPUTSAMPEL
    Route::get('/inputsampel', [MasterController::class, 'DataSampels']);   
    Route::match(['get', 'post'], '/crud_inputsampel', [MasterController::class, 'CrudInputSampel']);
    #INPUTSAMPEL

    #HASILANALISIS
    Route::get('/hasilanalisis/{id_kupa?}', [MasterController::class, 'HasilAnalisis']); 

    
    Route::match(['get', 'post'], '/crud_hasilanalisis', [MasterController::class, 'CrudHasilAnalisis']);
    #HASILANALISIS

    #TRACKING
    Route::get('/tracking/{id_kupa?}', [MasterController::class, 'Tracking']);
    #TRACKING

    #DEKRIP TES
    Route::get('/dekrip', [MasterController::class, 'Dekrip']);
    #DEKRIP

    Route::get('/latihantabel', [MasterController::class, 'LatihanTabel']);
});



Route::get('/dekrip', [MasterController::class, 'Dekrip']);