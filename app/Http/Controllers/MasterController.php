<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AksesLevel;

use App\Controllers\ApiController;

class MasterController extends Controller
{
#1 - 4PARAMETERS -> PAGES
    public function Parameters()
    {
        $parameters         = app('App\Http\Controllers\ApiController')->GetParameters();

        $parameters         = json_decode($parameters, true);
        
        return view('admin.parameters.parameters', ['parameters' => $parameters]);
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
        $akseslevels = app('App\Http\Controllers\ApiController')->GetAksesLevels();        
        $akseslevels = json_decode($akseslevels, true);
        return view('admin.akseslevels.akseslevels', ['akseslevels' => $akseslevels]);
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
        
        return view('admin.jenissampels.jenissampels', ['jenissampels' => $getjenissampels]);
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
        $metodes = app('App\Http\Controllers\ApiController')->GetMetodes();    
        $metodes = json_decode($metodes, true);
        return view('admin.metodes.metodes', ['metodes' => $metodes]);
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

#17 21 PELANGGANS -> PAGES
    #GET PELANGGANS
    public static function GetPelanggans(){
        $getpelanggans = app('App\Http\Controllers\ApiController')->GetPelanggans();
        $getpelanggans = json_decode($getpelanggans, true);       
        return view('admin.pelanggans.pelanggans', ['pelanggans' => $getpelanggans]);
    }

    #INSERT PELANGGANS
    public static function InsertPelanggans(Request $request){
        $insertpelanggans = app('App\Http\Controllers\ApiController')->InsertPelanggans($request, $request->email, $request->password, $request->nama, $request->perusahaan ,$request->nomor_telepon , $request->alamat , $request->tanggal_registrasi);
        $insertpelanggans = json_decode($insertpelanggans, true);        
        return redirect()->back()->with('insert', $insertpelanggans['message']); 
    }

    #UPDATE PELANGGANS
    public static function UpdatePelanggans(Request $request){
        $updatepelanggans = app('App\Http\Controllers\ApiController')->UpdatePelanggans($request, $request->id, $request->email, $request->password, $request->nama, $request->perusahaan ,$request->nomor_telepon , $request->alamat , $request->tanggal_registrasi);
        $updatepelanggans = json_decode($updatepelanggans, true);        
        return redirect()->back()->with('update', $updatepelanggans['message']); 
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
        return view('admin.aktivitas.aktivitas', ['aktivitas' => $getaktivitas]);
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
        $getlabakuns = app('App\Http\Controllers\ApiController')->GetAkunLabs();
        $getlabakuns = json_decode($getlabakuns, true);   
        $getakseslevels = app('App\Http\Controllers\ApiController')->GetAksesLevels();
        $getakseslevels = json_decode($getakseslevels, true);        
        return view('admin.labakuns.labakuns', ['labakuns' => $getlabakuns, 'akseslevels' => $getakseslevels]);
    }

    #INSERT LAB AKUNS
    public static function InsertLabAkuns(Request $request){
        $insertlabakuns = app('App\Http\Controllers\ApiController')->InsertLabAkuns($request, $request->metodes_id_s,$request->akses_levels_id,$request->nama,$request->email,$request->password,$request->jabatan,$request->status_akun);
        $insertlabakuns = json_decode($insertlabakuns, true);        
        return redirect()->back()->with(['insert' => $insertlabakuns['message']]);   
    }
    
    #UPDATE LAB AKUNS
    public static function UpdateLabAkuns(Request $request){
        $updatelabakuns = app('App\Http\Controllers\ApiController')->UpdateLabAkuns($request, $request->id, $request->metodes_id_s, $request->akses_levels_id, $request->nama, $request->email, $request->password, $request->jabatan, $request->status_akun);
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
        $pakets         = app('App\Http\Controllers\ApiController')->GetPakets();        
        $pakets         = json_decode($pakets, true);

        #JENIS SAMPELS
        $jenissampels                    = app('App\Http\Controllers\ApiController')->GetJenisSampels();
        $jenissampels                    = json_decode($jenissampels, true);
        $arr_jenissampels_id             = explode('-',$jenissampels['id']);
        $arr_jenissampels_jenis_sampel   = explode('-',$jenissampels['jenis_sampel']);
        $arr_jenissampels_lambang_sampel = explode('-',$jenissampels['lambang_sampel']);
        
        $arr_jenissampels_all            = array();
        for ($i = 0; $i < count($arr_jenissampels_id) ; $i++) { 
            $data = [
                'id'                => $arr_jenissampels_id[$i],
                'jenis_sampel'      => $arr_jenissampels_jenis_sampel[$i],        
                'lambang_sampel'    => $arr_jenissampels_lambang_sampel[$i]            
            ];
            array_push($arr_jenissampels_all, $data);
        }
        #JENIS SAMPELS

        #PARAMETERS
        $parameters                 = app('App\Http\Controllers\ApiController')->GetParameters();        
        $parameters                 = json_decode($parameters, true);
        $arr_parameters_id          = explode('-', $parameters['id']);
        $arr_parameters_simbol      = explode('-', $parameters['simbol']);
        $arr_parameters_nama_unsur  = explode('-', $parameters['nama_unsur']);

        $arr_parameters_all         = array();
        for ($i = 0; $i < count($arr_parameters_id) ; $i++) { 
            $data = [
                'id'            => $arr_parameters_id[$i],
                'simbol'        => $arr_parameters_simbol[$i],        
                'nama_unsur'    => $arr_parameters_nama_unsur[$i]            
            ];
            array_push($arr_parameters_all, $data);
        }
        $arr_pkt_pars_id_s          = explode(';', $pakets['parameters_id_s']);
        $arr_parameters_id_s        = array();
        for ($i = 0; $i < count($arr_pkt_pars_id_s) ; $i++) { 
            $data = explode('-', $arr_pkt_pars_id_s[$i]);
            array_push($arr_parameters_id_s, $data);
        }

        $arr_paket_par = array();
        for ($i = 0; $i < count($arr_parameters_id_s) ; $i++) { 
            $str_paket_par_id   = '';
            $str_paket_par      = '';

            for ($j = 0; $j < count($arr_parameters_id_s[$i]); $j++) { 
                for ($k = 0; $k < count($arr_parameters_all); $k++) { 
                    if($arr_parameters_id_s[$i][$j] == $arr_parameters_all[$k]['id']){
                        $str_paket_par_id   .= $arr_parameters_all[$k]['id'].'-';
                        $str_paket_par      .= $arr_parameters_all[$k]['nama_unsur'].'-';
                    }
                }
            }
            $str_paket_par_id   = substr($str_paket_par_id, 0, -1);
            $str_paket_par      = substr($str_paket_par, 0, -1);

            $arr_ = [
                'id'            => explode('-', $str_paket_par_id),
                'nama_unsur'    => explode('-', $str_paket_par)
            ];

            array_push($arr_paket_par, $arr_);
            
        }
        #PARAMETERS

        return view('admin.pakets.pakets', ['pakets' => $pakets, 'jenissampels' => $arr_jenissampels_all, 'parameters' => $arr_parameters_all, 'arr_paket_par' => $arr_paket_par]);
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
        $str_harga            = str_replace('.', '',$request->harga);

        $arr_pakets     = [
            'jenis_sampels_id'      => $str_jenis_sampels_id,
            'paket'                 => $str_paket,
            'parameters_id_s'       => $str_parameters_id_s,
            'harga'                 => $str_harga
        ];

        $insertpakets = app('App\Http\Controllers\ApiController')->InsertPakets($request, $arr_pakets['jenis_sampels_id'], $arr_pakets['paket'], $arr_pakets['parameters_id_s'], $arr_pakets['harga']);      
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
        $str_parameters_id_s  = substr($str_parameters_id_s, 0, -1);
        $str_harga            = str_replace('.', '',$request->harga);

        $arr_pakets     = [
            'id'                    => $str_id,
            'jenis_sampels_id'      => $str_jenis_sampels_id,
            'paket'                 => $str_paket,
            'parameters_id_s'       => $str_parameters_id_s,
            'harga'                 => $str_harga
        ];

        $updatepakets = app('App\Http\Controllers\ApiController')->UpdatePakets($request, $arr_pakets['id'], $arr_pakets['jenis_sampels_id'], $arr_pakets['paket'], $arr_pakets['parameters_id_s'], $arr_pakets['harga']);      
        $updatepakets = json_decode($updatepakets, true);
        return redirect()->back()->with('update', $updatepakets['message']);  
    }
    #DELETE AKSES LEVELS
    public static function DeletePakets(Request $request, $id = null)
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
}
