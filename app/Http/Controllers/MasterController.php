<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AksesLevel;

use App\Controllers\ApiController;
use App\Models\HasilAnalisa;

class MasterController extends Controller
{
#GENERAL FUNCTION
    #HALAMAN
    function GetHal(){
        $gethalamans           = app('App\Http\Controllers\ApiController')->GetHalamans(); 
        $gethalamans           = json_decode($gethalamans, true);
        $halamans              = '';
        if($gethalamans['success'] == '1')
        {
            $halamans = [
                'id'          => explode('-', $gethalamans['id']),
                'halaman'     => explode('-', $gethalamans['halaman']),
                'url'         => explode('-', $gethalamans['url']),
                'simbol'      => explode(';', $gethalamans['simbol'])
            ];
        }
        else{
            $halamans = array();
        }
        return $halamans;
    }
    #HALAMAN

    #PARAMETER
    function GetPar(){
        $getparameters      = app('App\Http\Controllers\ApiController')->GetParameters(); 
        $getparameters      = json_decode($getparameters, true); 
        $parameters         = '';
        if($getparameters['success'] == '1')
        {
            $parameters = [
                'id'            => explode('-', $getparameters['id']),
                'simbol'        => explode('-', $getparameters['simbol']),
                'nama_unsur'    => explode('-', $getparameters['nama_unsur'])
            ];
        }else{
            $parameters = array();
        }
        return $parameters;
    }
    #PARAMETER
#GENERAL FUNCTION

#1 - 4PARAMETERS -> PAGES
    public function Parameters()
    {
        $parameters     = app('App\Http\Controllers\MasterController')->GetPar();
        $halamans       = app('App\Http\Controllers\MasterController')->GetHal();
        return view('admin.parameters.parameters', ['parameters' => $parameters, 'halamans' => $halamans]);
    }
    public function InsertParameter(Request $request)
    {
        $insert_parameters      = app('App\Http\Controllers\ApiController')->InsertParameters($request, $request->simbol, $request->nama_unsur);
        $insert_parameters      = json_decode($insert_parameters, true);
        return redirect()->back()->with('insert', $insert_parameters['message']);   
    }
    public function UpdateParameters(Request $request)
    {
        $update_parameters      = app('App\Http\Controllers\ApiController')->UpdateParameters($request, $request->id, $request->simbol, $request->nama_unsur);
        $update_parameters      = json_decode($update_parameters, true);
        return redirect()->back()->with('update', $update_parameters['message']);   
    }
    public function DeleteParameters($id = null)
    {
        $d_id                   = '';
        if(!isset($id)){
            return redirect()->back()->with('delete', 'ID UNTUK DELETE DATA TIDAK ADA');   
        }
        else{
            $d_id               = $id;
        }
        $delete_parameters      = app('App\Http\Controllers\ApiController')->DeleteParameters($d_id);
        $delete_parameters      = json_decode($delete_parameters, true);
        return redirect()->back()->with('delete', $delete_parameters['message']);  
    }
#1 - 4PARAMATERS -> PAGES

#5 AKSES_LEVELS -> PAGES
    #GET AKSES LEVELS
    public static function AksesLevels()
    {
        $getakseslevels = app('App\Http\Controllers\ApiController')->GetAksesLevels();        
        $getakseslevels = json_decode($getakseslevels, true);
        $akseslevels    = '';
        if($getakseslevels['success'] == '1')
        {
            $akseslevels = [
                'id'            => explode('-', $getakseslevels['id']),
                'jabatan'       => explode('-', $getakseslevels['jabatan']),
                'halamans_id_s' => explode(';', $getakseslevels['halamans_id_s'])
            ];
        }
        else
        {
            $akseslevels = array();
        }

        $halamans              = app('App\Http\Controllers\MasterController')->GetHal();
        return view('admin.akseslevels.akseslevels', ['akseslevels' => $akseslevels, 
                                                      'halamans' => $halamans]);
    }

    #INSERT AKSES LEVELS
    public static function InsertAksesLevels(Request $request)
    {
        $insertakseslevels = app('App\Http\Controllers\ApiController')->InsertAksesLevels($request);      
        $insertakseslevels = json_decode($insertakseslevels, true);
        return redirect()->back()->with('insert', $insertakseslevels['message']);  
    }
    #UPDATE AKSES LEVELS
    public static function UpdateAksesLevels(Request $request)
    {
        $updateakseslevels = app('App\Http\Controllers\ApiController')->UpdateAksesLevels($request);      
        $updateakseslevels = json_decode($updateakseslevels, true);
        return redirect()->back()->with('update', $updateakseslevels['message']);  
    }
    #DELETE AKSES LEVELS
    public static function DeleteAksesLevels($id = null)
    { 
        if(isset($id)){
            $deleteakseslevels = app('App\Http\Controllers\ApiController')->DeleteAksesLevels($id);      
            $deleteakseslevels = json_decode($deleteakseslevels, true);
            return redirect()->back()->with('delete', $deleteakseslevels['message']); 
        }
        else{
            return redirect()->back()->with('delete', 'ID KOSONG'); 
        }
    }
#5 AKSES_LEVELS -> PAGES

#6 JENIS_SAMPELS -> PAGES
    #GET JENI SAMPELS
    public static function JenisSampels()
    {
        $getjenissampels    = app('App\Http\Controllers\ApiController')->GetJenisSampels(); 
        $getjenissampels    = json_decode($getjenissampels, true);
        $jenissampels       = '';
        if($getjenissampels['success'] == '1')
        {
            $jenissampels = [
                'id'                => explode('-', $getjenissampels['id']),
                'jenis_sampel'      => explode('-', $getjenissampels['jenis_sampel']),
                'lambang_sampel'    => explode('-', $getjenissampels['lambang_sampel'])
            ];
        }
        else
        {
            $jenissampels = array();
        }

        $halamans           = app('App\Http\Controllers\MasterController')->GetHal();
        return view('admin.jenissampels.jenissampels', ['jenissampels' => $jenissampels, 
                                                        'halamans' => $halamans]);
    }
    public static function InsertJenisSampels(Request $request)
    {
        $insertjenissampels     = app('App\Http\Controllers\ApiController')->InsertJenisSampels($request);
        $insertjenissampels     = json_decode($insertjenissampels, true);
        return redirect()->back()->with('insert', $insertjenissampels['message']); 
    }
    public static function UpdateJenisSampels(Request $request)
    {
        $updatejenissampels     = app('App\Http\Controllers\ApiController')->UpdateJenisSampels($request);
        $updatejenissampels     = json_decode($updatejenissampels, true);
        return redirect()->back()->with('update', $updatejenissampels['message']); 
    }
    public static function DeleteJenisSampels($id = null)
    {
        $deletejenissampels     = app('App\Http\Controllers\ApiController')->DeleteJenisSampels($id);
        $deletejenissampels     = json_decode($deletejenissampels, true);
        return redirect()->back()->with('delete', $deletejenissampels['message']); 
    }
#6 JENIS_SAMPELS -> PAGES

#7 METODES -> PAGES
    public static function Metodes()
    {
        $getmetodes        = app('App\Http\Controllers\ApiController')->GetMetodes();    
        $getmetodes        = json_decode($getmetodes, true);
        $metodes           = '';
        if($getmetodes['success'] == '1')
        {
            $metodes = [
                'id'                => explode('-', $getmetodes['id']),
                'metode'            => explode('-', $getmetodes['metode']),
                'parameters_id_s'   => explode(';', $getmetodes['parameters_id_s'])
            ];
        }
        else
        {
            $metodes = array();
        }

        $halamans       = app('App\Http\Controllers\MasterController')->GetHal(); 
        $parameters     = app('App\Http\Controllers\MasterController')->GetPar();

        return view('admin.metodes.metodes', ['metodes' => $metodes, 
                                              'halamans' => $halamans, 
                                              'parameters' => $parameters]);
    }
    public static function InsertMetodes(Request $request)
    {
        $insertmetodes = app('App\Http\Controllers\ApiController')->InsertMetodes($request);    
        $insertmetodes = json_decode($insertmetodes, true);
        return redirect()->back()->with('insert', $insertmetodes['message']); 
    }
    public static function UpdateMetodes(Request $request)
    {
        $updatemetodes = app('App\Http\Controllers\ApiController')->UpdateMetodes($request);    
        $updatemetodes = json_decode($updatemetodes, true);
        return redirect()->back()->with('update', $updatemetodes['message']); 
    }
    public static function DeleteMetodes($id = null)
    {
        if(isset($id)){
            $deletemetodes = app('App\Http\Controllers\ApiController')->DeleteMetodes($id);    
            $deletemetodes = json_decode($deletemetodes, true);

            return redirect()->back()->with('delete', $deletemetodes['message']); 
        }
        else{
            return redirect()->back()->with('delete', 'ID KOSONG'); 
        }
    }
#7 METODES -> PAGES

#8 HALAMANS -> PAGES
    #HALAMAN PAGES
    public static function Halamans(){
        $halamans = app('App\Http\Controllers\MasterController')->GetHal();
        return view('halamans.halamans', ['halamans' => $halamans]);
    }

    #INSERT HALAMAN
    public static function InsertHalamans(Request $request){
        $inserthalamans           = app('App\Http\Controllers\ApiController')->InsertHalamans($request); 
        $inserthalamans           = json_decode($inserthalamans, true);
        return redirect()->back()->with('insert', $inserthalamans['message']); 
    }

    #UPDATE HALAMAN
    public static function UpdateHalamans(Request $request){
        $updatehalamans           = app('App\Http\Controllers\ApiController')->UpdateHalamans($request); 
        $updatehalamans           = json_decode($updatehalamans, true);
        return redirect()->back()->with('update', $updatehalamans['message']); 
    }

    #DELETE HALAMAN
    public static function DeleteHalamans($id = null){
        $Deletehalamans           = app('App\Http\Controllers\ApiController')->DeleteHalamans($id); 
        $Deletehalamans           = json_decode($Deletehalamans, true);
        return redirect()->back()->with('delete', $Deletehalamans['message']); 
    }
#8 HALAMANS -> PAGES

#9 DETAIL TRACKING -> PAGES
#9 DETAIL TRACKING -> PAGES

#11 14 DATA SAMPELS -> PAGES
    #PAGES DATA SAMPELS
    public static function DataSampels(){        
        #JENIS SAMPELS
        $getjenissampels   = app('App\Http\Controllers\ApiController')->GetJenisSampels(); 
        $getjenissampels   = json_decode($getjenissampels, true);
        $jenissampels      = '';
        if($getjenissampels['success'] == '1'){
            $jenissampels      = [
                'id'                => explode('-', $getjenissampels['id']),
                'jenis_sampel'      => explode('-', $getjenissampels['jenis_sampel']),
                'lambang_sampel'    => explode('-', $getjenissampels['lambang_sampel'])
            ];
        }
        else{
            $jenissampels = array();
        }

        #PELANGGANS
        $getpelanggans      = app('App\Http\Controllers\ApiController')->GetPelanggans(); 
        $getpelanggans      = json_decode($getpelanggans, true);
        $pelanggans         = '';
        if($getpelanggans['success'] == '1'){
            $pelanggans         = [
                'id'            => explode('-', $getpelanggans['id']),
                'nama'          => explode('-', $getpelanggans['nama']),
                'perusahaan'    => explode('-', $getpelanggans['perusahaan'])
            ]; 
        }
        else{
            $pelanggans     = array();
        }

        $getpakets          = app('App\Http\Controllers\ApiController')->GetPakets(); 
        $getpakets          = json_decode($getpakets, true);
        $pakets             = '';
        if($getpakets['success'] == '1'){
            $pakets = [
                'id'                => explode('-', $getpakets['id']),
                'jenis_sampels_id'  => explode('-', $getpakets['jenis_sampels_id']),
                'jenis_sampel'      => explode('-', $getpakets['jenis_sampel']),
                'paket'             => explode('-', $getpakets['paket']),
                'parameters_id_s'   => explode(';', $getpakets['parameters_id_s']),
                'metodes_id_s'      => explode(';', $getpakets['metodes_id_s']),
                'harga'             => explode('-', $getpakets['harga'])
            ];
        }
        else{
            $pakets = array();
        }

        #HALAMANS
        $halamans           = app('App\Http\Controllers\MasterController')->GetHal(); 

        
        $getdatasampels     = app('App\Http\Controllers\ApiController')->GetDataSampelsAll();
        $getdatasampels     = json_decode($getdatasampels, true);
        $datasampels        = '';
        if($getdatasampels['success'] == '1')
        {
            $datasampels    = [
                'id'                    => explode('-', $getdatasampels['id']),
                'pakets_id_s'           => explode(';', $getdatasampels['pakets_id_s']),
                'tanggal_masuk'         => explode('-', $getdatasampels['tanggal_masuk']),
                'tanggal_selesai'       => explode('-', $getdatasampels['tanggal_selesai']),
                'nomor_surat'           => explode('-', $getdatasampels['nomor_surat']),
                'jumlah_sampel'         => explode('-', $getdatasampels['jumlah_sampel']),
                'catatan_userlabs'      => explode('-', $getdatasampels['catatan_userlabs']),
                'status'                => explode('-', $getdatasampels['status']),
                'pelanggans_id'         => explode('-', $getdatasampels['pelanggans_id']),
                'pelanggans'            => explode('-', $getdatasampels['pelanggans']),
                'jenis_sampels_id'      => explode('-', $getdatasampels['jenis_sampels_id']),
                'jenis_sampel'          => explode('-', $getdatasampels['jenis_sampel']),
                'ketersediaan_alat'     => explode('-', $getdatasampels['ketersediaan_alat'])
            ];
        }
        else{
            $datasampels    = array();
        }
        return view('admin.sampel.data_sampel', ['datasampels'=> $datasampels,
                                                 'jenissampels'=> $jenissampels,
                                                 'pelanggans'=> $pelanggans,
                                                 'pakets'=> $pakets,
                                                 'halamans'=> $halamans,]);
    }

    #INSERT DATA SAMPELS
    public static function InsertDataSampels(Request $request){
        $batch = $request->batch_size;
        if(substr($batch, 0, -1) == ',')
        {   
            $batch = substr($batch, 0, -1);
        } 
        $paket =  implode('-', $request->pakets_id_s);

        $insertdatasampels = app('App\Http\Controllers\ApiController')->InsertDataSampels($request, 
                                                                                          $request->jenis_sampels_id, 
                                                                                          $request->pelanggans_id, 
                                                                                          $paket, 
                                                                                          $request->tanggal_masuk, 
                                                                                          $request->tanggal_selesai, 
                                                                                          $request->nomor_surat, 
                                                                                          $request->jumlah_sampel, 
                                                                                          $batch, 
                                                                                          $request->ketersediaan_alat, 
                                                                                          $request->catatan_userlabs);
        
        
        $insertdatasampels = json_decode($insertdatasampels, true);   
        return redirect()->back()->with('insert', $insertdatasampels['message']); 
        
    }

#11 14 DATA SAMPELS -> PAGES

#15 16 HASIL ANALISAS -> PAGES
    public static function HasilAnalisis(Request $request, $id = null)
    {  
        #JENIS SAMPELS
        $getjenissampels   = app('App\Http\Controllers\ApiController')->GetJenisSampels(); 
        $getjenissampels   = json_decode($getjenissampels, true);
        $jenissampels      = '';
        if($getjenissampels['success'] == '1'){
            $jenissampels      = [
                'id'                => explode('-', $getjenissampels['id']),
                'jenis_sampel'      => explode('-', $getjenissampels['jenis_sampel']),
                'lambang_sampel'    => explode('-', $getjenissampels['lambang_sampel'])
            ];
        }
        else{
            $jenissampels = array();
        }

        #PELANGGANS
        $getpelanggans      = app('App\Http\Controllers\ApiController')->GetPelanggans(); 
        $getpelanggans      = json_decode($getpelanggans, true);
        $pelanggans         = '';
        if($getpelanggans['success'] == '1'){
            $pelanggans         = [
                'id'            => explode('-', $getpelanggans['id']),
                'nama'          => explode('-', $getpelanggans['nama']),
                'perusahaan'    => explode('-', $getpelanggans['perusahaan'])
            ]; 
        }
        else{
            $pelanggans     = array();
        }

        $getpakets          = app('App\Http\Controllers\ApiController')->GetPakets(); 
        $getpakets          = json_decode($getpakets, true);
        $pakets             = '';
        if($getpakets['success'] == '1'){
            $pakets = [
                'id'                => explode('-', $getpakets['id']),
                'jenis_sampels_id'  => explode('-', $getpakets['jenis_sampels_id']),
                'jenis_sampel'      => explode('-', $getpakets['jenis_sampel']),
                'paket'             => explode('-', $getpakets['paket']),
                'parameters_id_s'   => explode(';', $getpakets['parameters_id_s']),
                'metodes_id_s'      => explode(';', $getpakets['metodes_id_s']),
                'harga'             => explode('-', $getpakets['harga'])
            ];
        }
        else{
            $pakets = array();
        }

        #HALAMANS
        $halamans           = app('App\Http\Controllers\MasterController')->GetHal(); 

        
        $getdatasampels     = app('App\Http\Controllers\ApiController')->GetDataSampelsById($request, $id);
        $getdatasampels     = json_decode($getdatasampels, true);
        $datasampels        = '';
        if($getdatasampels['success'] == '1')
        {
            $datasampels    = [
                'id'                    => explode('-', $getdatasampels['id']),
                'pakets_id_s'           => explode(';', $getdatasampels['pakets_id_s']),
                'tanggal_masuk'         => explode('-', $getdatasampels['tanggal_masuk']),
                'tanggal_selesai'       => explode('-', $getdatasampels['tanggal_selesai']),
                'nomor_surat'           => explode('-', $getdatasampels['nomor_surat']),
                'jumlah_sampel'         => explode('-', $getdatasampels['jumlah_sampel']),
                'catatan_userlabs'      => explode('-', $getdatasampels['catatan_userlabs']),
                'status'                => explode('-', $getdatasampels['status']),
                'pelanggans_id'         => explode('-', $getdatasampels['pelanggans_id']),
                'pelanggans'            => explode('-', $getdatasampels['pelanggans']),
                'jenis_sampels_id'      => explode('-', $getdatasampels['jenis_sampels_id']),
                'jenis_sampel'          => explode('-', $getdatasampels['jenis_sampel']),
                'simbol'                => explode('-', $getdatasampels['simbol']),
                'ketersediaan_alat'     => explode('-', $getdatasampels['ketersediaan_alat'])
            ];
        }
        else{
            $datasampels    = array();
        }
        return view('admin.sampel.hasil_analisis',  [
                'datasampels'   => $datasampels,
                'jenissampels'  => $jenissampels,
                'pelanggans'    => $pelanggans,
                'pakets'        => $pakets,
                'halamans'      => $halamans
        ]);
    }
#15 16 HASIL ANALISAS -> PAGES

#17 21 PELANGGANS -> PAGES
    #GET PELANGGANS
    public static function GetPelanggans(){
        $getpelanggans  = app('App\Http\Controllers\ApiController')->GetPelanggans();
        $getpelanggans  = json_decode($getpelanggans, true);   
        $pelanggans     = '';
        if($getpelanggans['success'] == '1'){
            $pelanggans = [
                'id'                    => explode('-', $getpelanggans['id']),
                'email'                 => explode('-', $getpelanggans['email']),
                'password'              => explode('-', $getpelanggans['password']),
                'nama'                  => explode('-', $getpelanggans['nama']),
                'perusahaan'            => explode('-', $getpelanggans['perusahaan']),
                'nomor_telepon'         => explode('-', $getpelanggans['nomor_telepon']),
                'npwp'                  => explode(';', $getpelanggans['npwp']),
                'alamat'                => explode('-', $getpelanggans['alamat']),
                'tanggal_registrasi'    => explode('-', $getpelanggans['tanggal_registrasi'])
            ];
        }
        else{
            $pelanggans = array();
        }

        $halamans = app('App\Http\Controllers\MasterController')->GetHal();
        return view('admin.pelanggans.pelanggans', ['pelanggans'    => $pelanggans, 
                                                    'halamans'      => $halamans]);
    }

    #INSERT PELANGGANS
    public static function InsertPelanggans(Request $request){
        $insertpelanggans = app('App\Http\Controllers\ApiController')->InsertPelanggans($request, $request->email, $request->password, $request->nama, $request->perusahaan, $request->nomor_telepon, $request->npwp, $request->alamat);
        $insertpelanggans = json_decode($insertpelanggans, true);        
        return redirect()->back()->with('insert', $insertpelanggans['message']); 
        
        
        // return app('App\Http\Controllers\ApiController')->InsertPelanggans($request, $request->email, $request->password, $request->nama, $request->perusahaan, $request->nomor_telepon, $request->npwp, $request->alamat);
    
    }

    #UPDATE PELANGGANS
    public static function UpdatePelanggans(Request $request){
        $updatepelanggans = app('App\Http\Controllers\ApiController')->UpdatePelanggans($request, $request->id, $request->email, $request->password, $request->nama, $request->perusahaan ,$request->nomor_telepon , $request->npwp, $request->alamat);
        $updatepelanggans = json_decode($updatepelanggans, true);        
        return redirect()->back()->with('update', $updatepelanggans['message']); 

        //return app('App\Http\Controllers\ApiController')->UpdatePelanggans($request, $request->id, $request->email, $request->password, $request->nama, $request->perusahaan, $request->nomor_telepon, $request->npwp, $request->alamat);
        
    }

    #DELETE PELANGGANS
    public static function DeletePelanggans($id = null){
        if(isset($id)){
            $deletepelanggans = app('App\Http\Controllers\ApiController')->DeletePelanggans($id);
            $deletepelanggans = json_decode($deletepelanggans, true);        
            return redirect()->back()->with('delete', $deletepelanggans['message']); 
        }
        else{
            return redirect()->back()->with('delete', 'ID PELANGGAN YANG INGIN DIHAPUS TIDAK DITEMUKAN'); 
        }
    }
#17 21 PELANGGANS -> PAGES

#22 AKTIVITAS
    #GET AKTIVITAS
    public static function GetAktivitas(){
        $getaktivitas = app('App\Http\Controllers\ApiController')->GetAktivitas();
        $getaktivitas = json_decode($getaktivitas, true);      
        $aktivitas    = array();
        if($getaktivitas['success'] == 1){
            $aktivitas = [
                'id'            => explode('-', $getaktivitas['id']),
                'aktivitas'     => explode('-', $getaktivitas['aktivitas']),
                'groups_id'     => explode('-', $getaktivitas['groups_id'])
            ];
        }
        else{
            $aktivitas = array();
        }

        $getgroupaktivitas  = app('App\Http\Controllers\ApiController')->GetGroupAktivitas();
        $getgroupaktivitas  = json_decode($getgroupaktivitas, true);  
        $groupaktivitas     = array();
        if($getgroupaktivitas['success'] == 1){
            $groupaktivitas = [
                'id'        => explode('-', $getgroupaktivitas['id']),
                'group'     => explode('-', $getgroupaktivitas['group'])
            ];
        }
        else{
            $groupaktivitas     = array();
        }
        
        $halamans = app('App\Http\Controllers\MasterController')->GetHal();
        return view('admin.aktivitas.aktivitas', ['aktivitas'       => $aktivitas, 
                                                  'groupaktivitas'  => $groupaktivitas,
                                                  'halamans'        => $halamans]);
    }

    #INSERT AKTIVITAS
    public static function InsertAktivitas(Request $request){        
        $insertaktivitas = app('App\Http\Controllers\ApiController')->InsertAktivitas($request);
        $insertaktivitas = json_decode($insertaktivitas, true);     
        return redirect()->back()->with('insert', $insertaktivitas['message']);   
    }
    
    #UPDATE AKTIVITAS
    public static function UpdateAktivitas(Request $request){        
        $updateaktivitas = app('App\Http\Controllers\ApiController')->UpdateAktivitas($request);
        $updateaktivitas = json_decode($updateaktivitas, true);       
        return redirect()->back()->with('update', $updateaktivitas['message']);   
    }

    #DELETE AKTIVITAS
    public static function DeleteAktivitas($id = null){    
        if(isset($id))
        {
            $deleteaktivitas = app('App\Http\Controllers\ApiController')->DeleteAktivitas($id);
            $deleteaktivitas = json_decode($deleteaktivitas, true);       
            return redirect()->back()->with('delete', $deleteaktivitas['message']);  
        }    
        else{
            return redirect()->back()->with('delete', 'ID AKTIVITAS YANG INGIN DIHAPUS TIDAK ADA');  
        }
    }
#22 AKTIVITAS

#23 - 27 LAB AKUNS
    #GET LAB AKUNS
    public static function GetLabAkuns(){
        $getlabakuns        = app('App\Http\Controllers\ApiController')->GetAkunLabs();
        $getlabakuns        = json_decode($getlabakuns, true);
        $labakuns           = '';
        if($getlabakuns['success'] == 1){
            $labakuns       = [
                'id'                => explode('-', $getlabakuns['id']),
                'metodes_id_s'      => explode(';', $getlabakuns['metodes_id_s']),
                'akses_levels_id'   => explode('-', $getlabakuns['akses_levels_id']),
                'akses_level'       => explode('-', $getlabakuns['akses_level']),
                'nama'              => explode('-', $getlabakuns['nama']),
                'email'             => explode('-', $getlabakuns['email']),
                'password'          => explode('-', $getlabakuns['password']),
                'jabatan'           => explode('-', $getlabakuns['jabatan']),
                'status_akun'       => explode('-', $getlabakuns['status_akun'])
            ];
        }
        else{
            $labakuns           = array();
        }

        $getmetodes         = app('App\Http\Controllers\ApiController')->GetMetodes();
        $getmetodes         = json_decode($getmetodes, true);
        $metodes            = '';
        if($getmetodes['success'] == '1'){
            $metodes        = [
                'id'        => explode('-', $getmetodes['id']),
                'metode'    => explode('-', $getmetodes['metode'])
            ];
        }
        else{
            $metodes        = array();
        }

        $getakseslevels     = app('App\Http\Controllers\ApiController')->GetAksesLevels();
        $getakseslevels     = json_decode($getakseslevels, true);
        $akseslevels        = '';
        if($getakseslevels['success'] == '1'){
            $akseslevels    = [
                'id'        => explode('-', $getakseslevels['id']),
                'jabatan'   => explode('-', $getakseslevels['jabatan'])
            ];
        }
        else{
            $akseslevels = array();
        }
        $halamans           = app('App\Http\Controllers\MasterController')->GetHal(); 
        
        return view('admin.labakuns.labakuns', ['labakuns'      => $labakuns, 
                                                'metodes'       => $metodes,
                                                'akseslevels'   => $akseslevels, 
                                                'halamans'      => $halamans]);
    }

    #INSERT LAB AKUNS
    public static function InsertLabAkuns(Request $request){
        $insertlabakuns = app('App\Http\Controllers\ApiController')->InsertLabAkuns($request, $request->metodes_id_s,$request->akses_levels_id,$request->nama,$request->email,$request->password,$request->jabatan,$request->status_akun);
        $insertlabakuns = json_decode($insertlabakuns, true);        
        return redirect()->back()->with(['insert' => $insertlabakuns['message']]);   
    }
    
    #UPDATE LAB AKUNS
    public static function UpdateLabAkuns(Request $request){
        $updatelabakuns = app('App\Http\Controllers\ApiController')->UpdateLabAkuns($request, 
                                                                                    $request->id, 
                                                                                    $request->metodes_id_s, 
                                                                                    $request->akses_levels_id, 
                                                                                    $request->nama, 
                                                                                    $request->email, 
                                                                                    $request->password, 
                                                                                    $request->jabatan, 
                                                                                    $request->status_akun);
        $updatelabakuns = json_decode($updatelabakuns, true);        
        return redirect()->back()->with(['update' => $updatelabakuns['message']]);   
    }
    
    #DELETE LAB AKUNS
    public static function DeleteLabAkuns(Request $request, $id = null){
        $deletelabakuns = app('App\Http\Controllers\ApiController')->DeleteLabAkuns($request, $request->id);
        $deletelabakuns = json_decode($deletelabakuns, true);        
        return redirect()->back()->with(['delete' => $deletelabakuns['message']]); 
    }

    #LOGIN LAB AKUNS
    public static function LoginLabAkuns(){
        
    }
#23 - 27 LAB AKUNS

#28 31 PAKETS
    #GET AKSES LEVELS
    public static function Pakets()
    {
        $getpakets  = app('App\Http\Controllers\ApiController')->GetPakets();        
        $getpakets  = json_decode($getpakets, true);
        $pakets     = '';
        if($getpakets['success'] == '1')
        {
            $pakets = [
                'id'                => explode('-', $getpakets['id']),                   
                'jenis_sampels_id'  => explode('-', $getpakets['jenis_sampels_id']), 
                'jenis_sampel'      => explode('-', $getpakets['jenis_sampel']), 
                'paket'             => explode('-', $getpakets['paket']), 
                'parameters_id_s'   => explode(';', $getpakets['parameters_id_s']), 
                'metodes_id_s'      => explode(';', $getpakets['metodes_id_s']), 
                'harga'             => explode('-', $getpakets['harga'])     
            ];
        }
        else
        {   
            $pakets = array();
        }
        
        #JENIS SAMPELS
        $getjenissampels                    = app('App\Http\Controllers\ApiController')->GetJenisSampels();
        $getjenissampels                    = json_decode($getjenissampels, true);
        $jenissampels                       = '';
        if($getjenissampels['success'] == '1')
        {
            $jenissampels   = [
                'id'                => explode('-', $getjenissampels['id']),
                'jenis_sampel'      => explode('-', $getjenissampels['jenis_sampel']),
                'lambang_sampel'    => explode('-', $getjenissampels['lambang_sampel']),
            ];
        }
        else
        {
            $jenissampels = array();
        }
        #JENIS SAMPELS

        #PARAMETERS
        $parameters                 = app('App\Http\Controllers\MasterController')->GetPar();

        $getmetodes            = app('App\Http\Controllers\ApiController')->GetMetodes(); 
        $getmetodes            = json_decode($getmetodes, true);
        $metodes               = '';
        if($getmetodes['success'] == '1')
        {
            $metodes    = [
                'id'                => explode('-', $getmetodes['id']),
                'metode'            => explode('-', $getmetodes['metode']),
                'parameters_id_s'   => explode(';', $getmetodes['parameters_id_s'])
            ];
        }
        else
        {
            $metodes    = array();
        }

        $halamans           = app('App\Http\Controllers\MasterController')->GetHal(); 
        
        return view('admin.pakets.pakets', ['pakets'        => $pakets, 
                                            'parameters'    => $parameters, 
                                            'halamans'      => $halamans,
                                            'metodes'       => $metodes,
                                            'jenissampels'  => $jenissampels]);
    
    
    }
    #INSERT AKSES LEVELS
    public static function InsertPakets(Request $request)
    {
        $str_jenis_sampels_id       = $request->jenis_sampels_id;
        $str_paket            = $request->paket;
        $str_parameters_id_s  = '';
        foreach($request->parameters_id_s as $par){
            $str_parameters_id_s .= $par.'-';
        }
        $str_parameters_id_s  = substr($str_parameters_id_s, 0, -1);
        $str_metodes_id_s     = '';
        if(empty($request->metodes_id_s))
        {
            $str_metodes_id_s     = '';
        }
        else{
            foreach ($request->metodes_id_s as $met) {
                $str_metodes_id_s .= $met.'-';
            }
            $str_metodes_id_s = substr($str_metodes_id_s, 0, -1);
        }
        $str_harga            = str_replace('.', '',$request->harga);

        $arr_pakets     = [
            'jenis_sampels_id'      => $str_jenis_sampels_id,
            'paket'                 => $str_paket,
            'parameters_id_s'       => $str_parameters_id_s,
            'metodes_id_s'          => $str_metodes_id_s,
            'harga'                 => $str_harga
        ];

        $insertpakets = app('App\Http\Controllers\ApiController')->InsertPakets($request, $arr_pakets['metodes_id_s'], $arr_pakets['jenis_sampels_id'], $arr_pakets['paket'], $arr_pakets['parameters_id_s'], $arr_pakets['harga']);      
        $insertpakets = json_decode($insertpakets, true);
        return redirect()->back()->with('insert', $insertpakets['message']);  
    }
    #UPDATE AKSES LEVELS
    public static function UpdatePakets(Request $request)
    {
        $str_id                     = $request->id;
        $str_jenis_sampels_id       = $request->jenis_sampels_id;
        $str_paket                  = $request->paket;
        $str_parameters_id_s        = '';
        foreach($request->parameters_id_s as $par){
            $str_parameters_id_s .= $par.'-';
        }
        $str_metodes_id_s     = '';
        if(empty($request->metodes_id_s))
        {
            $str_metodes_id_s     = '';
        }
        else{
            foreach ($request->metodes_id_s as $met) {
                $str_metodes_id_s .= $met.'-';
            }
            $str_metodes_id_s = substr($str_metodes_id_s, 0, -1);
        }
        $str_parameters_id_s  = substr($str_parameters_id_s, 0, -1);
        $str_harga            = str_replace('.', '',$request->harga);

        $arr_pakets     = [
            'id'                    => $str_id,
            'jenis_sampels_id'      => $str_jenis_sampels_id,
            'paket'                 => $str_paket,
            'parameters_id_s'       => $str_parameters_id_s,
            'metodes_id_s'          => $str_metodes_id_s,
            'harga'                 => $str_harga
        ];

        $updatepakets = app('App\Http\Controllers\ApiController')->UpdatePakets($request, $arr_pakets['metodes_id_s'], $arr_pakets['id'], $arr_pakets['jenis_sampels_id'], $arr_pakets['paket'], $arr_pakets['parameters_id_s'], $arr_pakets['harga']);      
        $updatepakets = json_decode($updatepakets, true);
        return redirect()->back()->with('update', $updatepakets['message']);  
    }
    #DELETE AKSES LEVELS
    public static function DeletePakets($id = null)
    { 
        if(isset($id)){
            $deletepakets = app('App\Http\Controllers\ApiController')->DeletePakets($id);      
            $deletepakets = json_decode($deletepakets, true);
            return redirect()->back()->with('delete', $deletepakets['message']); 
        }
        else{
            return redirect()->back()->with('delete', 'ID KOSONG'); 
        }
    }
#28 31 PAKETS

#32 -35 GRUP AKTIVITAS
    public static function GetGroupAktivitas(){
        $groupaktivitas = app('App\Http\Controllers\ApiController')->GetGroupAktivitas();        
        $groupaktivitas = json_decode($groupaktivitas, true);
        

        $halamans           = app('App\Http\Controllers\MasterController')->GetHal(); 

        $arr_groupaktivitas = '';
        if($groupaktivitas['success'] == 0)
        {
            $arr_groupaktivitas     = [];
        }
        else if($groupaktivitas['success'] == 1){
            $arr_groupaktivitas  = [
                'id'    => explode('-', $groupaktivitas['id']),
                'group' => explode('-', $groupaktivitas['group'])
            ];
        }
        return view('admin.groupaktivitas.groupaktivitas', ['arrgroupaktivitas' => $arr_groupaktivitas, 
                                                            'groupaktivitas' => $groupaktivitas, 
                                                            'halamans' => $halamans]);
    }

    public static function AjaxTest(){
        $groupaktivitas = app('App\Http\Controllers\ApiController')->GetGroupAktivitas();        
        $groupaktivitas = json_decode($groupaktivitas, true);
        

        $halamans           = app('App\Http\Controllers\ApiController')->GetHalamans(); 
        $halamans           = json_decode($halamans, true);

        $arr_groupaktivitas = '';
        if($groupaktivitas['success'] == 0)
        {
            $arr_groupaktivitas     = [];
        }
        else if($groupaktivitas['success'] == 1){
            $arr_groupaktivitas  = [
                'id'    => explode('-', $groupaktivitas['id']),
                'group' => explode('-', $groupaktivitas['group'])
            ];
        }
        return view('admin.groupaktivitas.groupaktivitasajax', ['arrgroupaktivitas' => $arr_groupaktivitas, 'groupaktivitas' => $groupaktivitas, 'halamans' => $halamans]);
    }

    
    public static function InsertGroupAktivitas(Request $request){
        $insertgroupaktivitas = app('App\Http\Controllers\ApiController')->InsertGroupAktivitas($request, $request->group);        
        $insertgroupaktivitas = json_decode($insertgroupaktivitas, true);

        return redirect()->back()->with('insert' ,$insertgroupaktivitas['message']);
    }
    
    public static function UpdateGroupAktivitas(Request $request){
        $updategroupaktivitas = app('App\Http\Controllers\ApiController')->UpdateGroupAktivitas($request, $request->id, $request->group);        
        $updategroupaktivitas = json_decode($updategroupaktivitas, true);

        return redirect()->back()->with('update', $updategroupaktivitas['message']);
    }

    
    public static function DeleteGroupAktivitas($id = null){
        if(isset($id)){
            $deletegroupaktivitas = app('App\Http\Controllers\ApiController')->DeleteGroupAktivitas($id);        
            $deletegroupaktivitas = json_decode($deletegroupaktivitas, true);

            return redirect()->back()->with('delete' , $deletegroupaktivitas['message']);
        }
        else{
            return redirect()->back()->with('delete' , 'ID KOSONG');
        }
    }
#32 -35 GRUP AKTIVITAS


    public static function LatihanTabel(){

        $l_hasil_analisis   = DB::table('hasil_analisas')
            ->where('jenis_sampels_id', '=', 1)
            ->orderByDesc('no_lab')->take(1)->get();

        $l_hasil_analisis   = json_decode(json_encode($l_hasil_analisis), true);
        
        /* if (isset($l_hasil_analisis['no_lab'])) {
            $n = $l_hasil_analisis['no_lab'];
        }               
        else{
            $n = 0;
        }   */ 
    }



#PELANGGAN
    public static function LoginPelanggan(Request $request)
    {
        $email      = $request->email;
        $password   = $request->password;
        
        $loginpelanggan = app('App\Http\Controllers\ApiController')->LoginPelanggans($request, $email, $password);        
        $loginpelanggan = json_decode($loginpelanggan, true);

        if($loginpelanggan['success'] == 1)
        {
            $pelanggans = [
                'id'    => $loginpelanggan['id'],
                'email'    => $loginpelanggan['email'],
                'nama'    => $loginpelanggan['nama'],
                'perusahaan'    => $loginpelanggan['perusahaan'],
                'nomor_telepon'    => $loginpelanggan['nomor_telepon']
            ];
            return redirect()->route('tracking', ['pelanggan' => $pelanggans]);
        }
        else
        {
            return redirect()->route('login', ['status' => $loginpelanggan['message']]);  
        }
    }

    public static function TrackingPelanggan()
    {
        return view('tracking');
    }

    public static function CekResi(Request $request){
        $pelanggans     = [
            'id'    => $request->id,
            'email'    => $request->email,
            'nama'    => $request->nama,
            'perusahaan'    => $request->perusahaan
        ];
        $data           = $request->resi;
        $cipher         = "aes-128-cbc"; 
        $encryption_key = '1234567890123456'; 

        $decrypted_data = openssl_decrypt($data, 
                                          $cipher, 
                                          $encryption_key, 
                                          0, 
                                          ''); 
        $gettrackings   = app('App\Http\Controllers\ApiController')->GetDetailTrackings($decrypted_data);        
        $gettrackings   = json_decode($gettrackings, true);
        $trackings      = array();
        if($gettrackings['success'] == 1)
        {
            $trackings = [
                'aktivitas_waktu'    => explode('-', $gettrackings['aktivitas_waktu']),
                'lab_akuns_nama'     => explode('-', $gettrackings['lab_akuns_nama']),
                'group'              => explode('-', $gettrackings['group'])
            ];
        }
        else
        {
            $trackings = array();
        }

        return redirect()->route('tracking', [
            'pelanggan' => $pelanggans,
            'tracking'  => $trackings
        ]);
    }
    public static function Dekrip(){
        error_reporting(0);
        $cipher = "aes-128-cbc"; 

        //Generate a 256-bit encryption key 
        $encryption_key = '1234567890123456'; 

        //Data to encrypt 
        $data = "12"; 
        $encrypted_data = openssl_encrypt($data, $cipher, $encryption_key, 0, ''); 

        echo "Encrypted Text: " . $encrypted_data.'<br>'; 

        #DEKRIP DATA
        $decrypted_data = openssl_decrypt($encrypted_data, 
                                          $cipher, 
                                          $encryption_key, 
                                          0, 
                                          ''); 

        echo "Decrypted Text: " . $decrypted_data.'<br>';
    }
#PELANGGAN
}
