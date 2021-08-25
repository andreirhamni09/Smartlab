<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;


Route::get('/', function () {
    return view('welcome');
});

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



    Route::get('/login', [MasterController::class, 'Login']);
    Route::get('/register', [MasterController::class, 'Register']);

    # AKSESLEVEL
    Route::get('/akseslevel', [MasterController::class, 'AksesLevel']);
    Route::match(['get', 'post'], '/crud_akseslevel', [MasterController::class, 'CrudAksesLevel']);
    # AKSESLEVEL

    #INPUTSAMPEL
    Route::get('/inputsampel', [MasterController::class, 'InputSampel']);   
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
});