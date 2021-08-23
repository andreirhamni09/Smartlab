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

    #PELANGGAN
    Route::get('/pelanggans', [MasterController::class, 'Pelanggans']);
    Route::match(['get', 'post'], '/crud_pelanggans', [MasterController::class, 'CrudPelanggans']);
    #PELANGGAN

    Route::get('/login', [MasterController::class, 'Login']);
    Route::get('/register', [MasterController::class, 'Register']);

    # AKSESLEVEL
    Route::get('/akseslevel', [MasterController::class, 'AksesLevel']);
    Route::match(['get', 'post'], '/crud_akseslevel', [MasterController::class, 'CrudAksesLevel']);
    # AKSESLEVEL

    # USERLAB    
    Route::get('/userlab', [MasterController::class, 'UserLab']);
    Route::match(['get', 'post'], '/crud_akunlab', [MasterController::class, 'CrudUserLab']);
    # USERLAB

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