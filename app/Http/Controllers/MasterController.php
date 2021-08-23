<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AksesLevel;

use App\Controllers\ApiController;

class MasterController extends Controller
{
#PARAMETERS -> PAGES
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
#PARAMATERS -> PAGES


#AKSES_LEVELS -> PAGES
    #GET AKSES LEVELS
    public static function GetAksesLevels()
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
#AKSES_LEVELS -> PAGES
}
