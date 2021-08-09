<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AksesLevel;

class MasterController extends Controller
{
#PARAMETERS -> PAGES
    public function Parameters()
    {
        $parameters     = DB::table('parameters')
        ->get();
        $jenissampels   = DB::table('jenis_sampels');
        
        return view('admin.parameters.parameters', ['parameters' => $parameters]);
        $akseslevels = new AksesLevel;
    }
#PARAMATERS -> PAGES
}
