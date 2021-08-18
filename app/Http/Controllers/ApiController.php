<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Exception;
use PHPUnit\Framework\Constraint\Count;

use function PHPUnit\Framework\isEmpty;

use Illuminate\Support\Facades\Validator;

use App\Models\DataSampel;
use App\Models\HasilAnalisa;
use App\Models\LabAkun;

class usr
{
}
class ApiController extends Controller
{

#PARAMETERS
    #1. GET PARAMETERS
    /**
     * @OA\Get(
     *      path="/getparameter",
     *      operationId="getProjectsList",
     *      tags={"1. Get Parameter"},
     *      summary="Mendapatkan List data Parameter",
     *      description="Mendapatkan List data Parameter",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    function GetParameters()
    {
        $response                   = new usr();
        try {

            $parameter                  = DB::table('parameters')
                ->get();
            $parameter                  = json_decode(json_encode($parameter), true);
            if (count($parameter) < 1) {
                $response->success          = 0;
                $response->messages         = 'DATA PARAMETER TIDAK DITEMUKAN';
            } elseif (count($parameter) > 0) {
                $str_id                     = '';
                $str_simbol                 = '';
                $str_nama_unsur             = '';

                foreach ($parameter as $value) {
                    $str_id                 .= $value['id'] . '-';
                    $str_simbol             .= $value['simbol'] . '-';
                    $str_nama_unsur         .= $value['nama_unsur'] . '-';
                }

                $str_id                     = substr($str_id, 0, -1);
                $str_simbol                 = substr($str_simbol, 0, -1);
                $str_nama_unsur             = substr($str_nama_unsur, 0, -1);

                $response->id               = $str_id;
                $response->simbol           = $str_simbol;
                $response->nama_unsur       = $str_nama_unsur;
                $response->success          = 1;
            }
            die(json_encode($response));
        } catch (Exception $e) {
            $response->success      = 0;
            $response->message      = $e->getMessage();
            die(json_encode($response));
        }
    }
    #1. GET PARAMETERS

    #2. INSERT PARAMETERS
    /**
     * @OA\post(
     *      path="/insertparameters/{simbol}/{nama_unsur}",
     *      operationId="getProjectsList",
     *      tags={"2. Insert Parameters"},
     *      summary="Menambahkan Data Baru ke Tabel Parameters",
     *      description="Menambahkan Data Baru ke Tabel Parameters",
     *      @OA\Parameter(
     *          name="simbol",
     *          description="Simbol",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="nama_unsur",
     *          description="Nama Unsur",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function InsertParameters(Request $request, $simbol = null, $nama_unsur = null)
    {
        $response           = new usr();
        $insertparameters   = ''; 
        
        $s_simbol             = ''; $s_nama_unsur = '';
        if(
            (!isset($request->simbol) OR !isset($request->nama_unsur)) AND
            (empty($simbol) OR empty($nama_unsur))
        )
        {
            $response->success = 0;
            $response->message = 'DATA WAJIB DIISI';
        }
        elseif (
            (isset($request->simbol) OR isset($request->nama_unsur))
        ) 
        {
            $s_simbol       = $request->simbol; 
            $s_nama_unsur   = $request->nama_unsur;
        }
        elseif (
            (empty($simbol) OR empty($nama_unsur))
        ) 
        {
            $s_simbol       = $simbol; 
            $s_nama_unsur   = $nama_unsur;
        }

        try {
            DB::table('parameters')
            ->insert([
                'simbol'        => $s_simbol,
                'nama_unsur'    => $s_nama_unsur
            ]);

            $response->success  = 1;
            $response->message  = 'BERHASIL MENAMBAHKAN DATA KE TABEL PARAMETERS';
        } catch (Exception $e) {
            $response->success  = 0;
            $response->message  = 'GAGAL MENAMBAHKAN DATA BARU :'. $e->getMessage();
        }

        die(json_encode($response));
    }
    #2. INSERT PARAMETERS

    #3. UPDATE PARAMETERS
    /**
     * @OA\post(
     *      path="/updateparameters/{id}/{simbol}/{nama_unsur}",
     *      operationId="getProjectsList",
     *      tags={"3. Update Parameters"},
     *      summary="Melakukan Perubahan Data Parameter Berdasarkan Parameter Yang Dikirimkan",
     *      description="Melakukan Perubahan Data Parameter Berdasarkan Parameter Yang Dikirimkan",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="simbol",
     *          description="Simbol",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="nama_unsur",
     *          description="Nama Unsur",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function UpdateParameters(Request $request, $id = null, $simbol = null, $nama_unsur = null)
    {
        $response           = new usr();
        $updateparameters   = ''; 
        
        $s_id = ''; $s_simbol = ''; $s_nama_unsur = '';
        if(
            (!isset($request->id) OR !isset($request->simbol) OR !isset($request->nama_unsur)) OR
            (!isset($id) OR !isset($simbol) OR !isset($nama_unsur))
        )
        {
            $response->success = 0;
            $response->message = 'DATA WAJIB DIISI';
        }
        elseif (
            (isset($request->id) OR isset($request->simbol) OR isset($request->nama_unsur))
        ) 
        {
            $s_id           = $request->id; 
            $s_simbol       = $request->simbol; 
            $s_nama_unsur   = $request->nama_unsur;
        }
        elseif (
            (isset($id) OR isset($simbol) OR isset($nama_unsur))
        ) 
        {
            $s_id           = $id; 
            $s_simbol       = $simbol; 
            $s_nama_unsur   = $nama_unsur;
        }

        $updateparameters       = DB::table('parameters')
        ->where('id', '=', $s_id)
        ->first();

        if(empty($updateparameters))
        {
            $response->success  = 0;
            $response->message  = 'DATA DENGAN ID :'.$s_id.' TIDAK DITEMUKAN';
        }
        else{
            try {
                $updateparameters   = DB::table('parameters')
                ->where('id', '=', $s_id)
                ->update([
                    'simbol'        => $s_simbol,
                    'nama_unsur'    => $s_nama_unsur
                ]);
    
                $response->success  = 1;
                $response->message  = 'BERHASIL MENAMBAHKAN DATA KE TABEL PARAMETERS';
            } catch (Exception $e) {
                $response->success  = 0;
                $response->message  = 'GAGAL MELAKUKAN UPDATE DATA :'. $e->getMessage();
            }    
        }
        die(json_encode($response));
    }
    #3. UPDATE PARAMETERS

    #4. DELETE PARAMETERS
    /**
     * @OA\post(
     *      path="/deleteparameters/{id}",
     *      operationId="getProjectsList",
     *      tags={"4. Delete Parameters"},
     *      summary="Hapus Data Parameter Berdasarakan ID Parameters",
     *      description="Hapus Data Parameter Berdasarakan ID Parameters",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function DeleteParameters(Request $request, $id = null)
    {
        $response           = new usr();
        $deleteparameter    = '';
        $s_id               = '';
        if(!isset($request->id) AND !isset($id))
        {
            $response->success = 0;
            $response->message = 'DATA WAJIB DIISI';
        }
        elseif (isset($request->id))
        {
            $s_id           = $request->id; 
        }
        elseif (isset($id)) 
        {
            $s_id           = $id; 
        }

        $deleteparameter    = DB::table('parameters')
        ->where('id', '=', $s_id)
        ->first();
        if(empty($deleteparameter))
        {
            $response->success = 0;
            $response->success = 'DATA DENGAN ID: '.$s_id.' DITEMUKAN';
        }
        else{
            try {
                DB::table('parameters')
                ->where('id', '=', $s_id)
                ->delete();

                $response->success = 1;
                $response->success = 'DATA DENGAN ID :'.$s_id.' BERHASIL DIHAPUS';
            } catch (Exception $e) {
                $response->success = 0;
                $response->success = 'GAGAL HAPUS DATA :'.$e->getMessage();
            }
        }
        die(json_encode($response));
    }
    #4. DELETE PARAMETERS

#PARAMETERS

#AKSES LEVEL
    #5. GET AKSES LEVEL
    /**
     * @OA\Get(
     *      path="/getakseslevels",
     *      operationId="getProjectsList",
     *      tags={"5. Akses Level"},
     *      summary="Mendapatkan List Akses Level",
     *      description="Mendapatkan List Akses Level",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    function GetAksesLevels()
    {
        $response                   = new usr();
        try {
            $aksesLevels                = DB::table('akses_levels')
                ->get();
            $aksesLevels                = json_decode(json_encode($aksesLevels), true);

            if (count($aksesLevels) < 1) {
                $response->success          = 0;
                $response->messages         = 'DATA JENIS SAMPEL TIDAK DITEMUKAN';
            } else if (count($aksesLevels) > 0) {
                $str_id                     = '';
                $str_jabatan                = '';
                $str_halamans_id_s          = '';

                foreach ($aksesLevels as $value) {
                    $str_id                 .= $value['id'] . '-';
                    $str_jabatan            .= $value['jabatan'] . '-';
                    $str_halamans_id_s      .= $value['halamans_id_s'] . '-';
                }

                $str_id                     = substr($str_id, 0, -1);
                $str_jabatan                = substr($str_jabatan, 0, -1);
                $str_halamans_id_s          = substr($str_halamans_id_s, 0, -1);

                $response->id               = $str_id;
                $response->jabatan          = $str_jabatan;
                $response->halamans_id_s    = $str_halamans_id_s;
                $response->success          = 1;
            }
            die(json_encode($response));
        } catch (Exception $e) {
            $response->success      = 0;
            $response->message      = $e->getMessage();
            die(json_encode($response));
        }
    }
    #5. GET AKSES LEVEL
#AKSES LEVEL

#JENIS SAMPEL
    #6. GET JENIS SAMPELS
    /**
     * @OA\Get(
     *      path="/getjenissampel",
     *      operationId="getProjectsList",
     *      tags={"6. Get Jenis Sampels"},
     *      summary="Mendapatkan List Jenis Sampel",
     *      description="Mendapatkan List Jenis Sampel",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    function GetJenisSampels()
    {
        $response                   = new usr();
        try {
            $jenisSampel                = DB::table('jenis_sampels')
                ->get();
            $jenisSampel                = json_decode(json_encode($jenisSampel), true);

            if (count($jenisSampel) < 1) {
                $response->success          = 0;
                $response->messages         = 'DATA JENIS SAMPEL TIDAK DITEMUKAN';
            } else if (count($jenisSampel) > 0) {
                $str_id                     = '';
                $str_jenisSampel            = '';
                $str_lambangSampel          = '';

                foreach ($jenisSampel as $value) {
                    $str_id                 .= $value['id'] . '-';
                    $str_jenisSampel        .= $value['jenis_sampel'] . '-';
                    $str_lambangSampel      .= $value['lambang_sampel'] . '-';
                }

                $str_id                     = substr($str_id, 0, -1);
                $str_jenisSampel            = substr($str_jenisSampel, 0, -1);
                $str_lambangSampel          = substr($str_lambangSampel, 0, -1);

                $response->id               = $str_id;
                $response->jenis_sampel     = $str_jenisSampel;
                $response->lambang_sampel   = $str_lambangSampel;
                $response->success          = 1;
            }
            die(json_encode($response));
        } catch (Exception $e) {
            $response->success      = 0;
            $response->message      = $e->getMessage();
            die(json_encode($response));
        }
    }
    #6. GET JENIS SAMPELS
#JENIS SAMPEL

#METODES
    #7. GET METODES
    /**
     * @OA\Get(
     *      path="/getmetodes",
     *      operationId="getProjectsList",
     *      tags={"7. Get Metode"},
     *      summary="Mendapatkan List Metode",
     *      description="Mendapatkan List Metode",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    function GetMetodes()
    {
        $response               = new usr();
        try {
            $metodes          = DB::table('metodes')
                ->get();
            $metodes          = json_decode(json_encode($metodes), true);

            $str_id                     = '';
            $str_metode                 = '';
            $str_parameters_id_s        = '';

            if (count($metodes) < 1) {
                $response->success          = 0;
                $response->messages         = 'DATA METODE TIDAK DITEMUKAN';
            } else if (count($metodes) > 0) {
                $str_id                     = '';
                $str_metode                 = '';
                $str_parameters_id_s        = '';

                foreach ($metodes as $value) {
                    $str_id                 .= $value['id'] . '-';
                    $str_metode             .= $value['metode'] . '-';
                    $str_parameters_id_s    .= $value['parameters_id_s'] . '-';
                }

                $str_id                     = substr($str_id, 0, -1);
                $str_metode                 = substr($str_metode, 0, -1);
                $str_parameters_id_s        = substr($str_parameters_id_s, 0, -1);

                $response->id                 = $str_id;
                $response->metode             = $str_metode;
                $response->parameters_id_s    = $str_parameters_id_s;
                $response->success            = 1;
            }
            die(json_encode($response));
        } catch (Exception $e) {
            $response->success      = 0;
            $response->message      = $e->getMessage();
            die(json_encode($response));
        }
    }
    #7. GET METODES
#METODES

#HALAMANS
    #8. GET HALAMANS
    #8. GET HALAMANS
#HALAMANS

#DETAIL TRACKING
    #9. GET DETAIL TRACKING
    /**
     * @OA\Get(
     *      path="/getdetailtrackings/{data_sampels_id}",
     *      operationId="getProjectsList",
     *      tags={"9. Get Detail Trackings"},
     *      summary="Mendapatkan List Data Trackings",
     *      description="Mendapatkan List Data Trackings",
     *      @OA\Parameter(
     *          name="data_sampels_id",
     *          description="data_sampels_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function GetDetailTrackings($data_sampels_id = null){
        $response = new usr();
        $getdetailtrackings = '';

        if(!isset($data_sampels_id))
        {
            $response->success = 0;
            $response->message = 'DATA SAMPELS ID TIDAK ADA';
        }
        $s_aktivitas_waktu  = ''; $s_aktivitas_id     = ''; $s_aktivitas        = '';
        $s_lab_akuns_id     = ''; $s_lab_akuns_nama   = ''; 

        $getdetailtrackings = DB::table('detail_trackings')
        ->join('aktivitas', 'detail_trackings.aktivitas_id', '=', 'aktivitas.id')
        ->join('lab_akuns', 'detail_trackings.lab_akuns_id', '=', 'lab_akuns.id')
        ->select('detail_trackings.*', 'aktivitas.aktivitas as aktivitas', 'lab_akuns.nama as nama')
        ->where('detail_trackings.data_sampels_id', '=', $data_sampels_id)
        ->get();

        $getdetailtrackings = json_decode(json_encode($getdetailtrackings), true);

        try {
            if(empty($getdetailtrackings)){
                $response->success = 0;
                $response->message = 'DATA TIDAK DITEMUKAN';
            }
            else {
                foreach ($getdetailtrackings as $value) {
                    
                    $s_aktivitas_waktu  .= str_replace('-', '/', $value['aktivitas_waktu']).'-'; 
                    $s_aktivitas_id     .= $value['aktivitas_id'].'-'; 
                    $s_aktivitas        .= $value['aktivitas'].'-';
                    $s_lab_akuns_id     .= $value['lab_akuns_id'].'-'; 
                    $s_lab_akuns_nama   .= $value['nama'].'-'; 
                }
                

                $waktu      = explode('-', substr($s_aktivitas_waktu, 0, -1));
                $j_waktu    = count($waktu) - 1;
                $date       = date_create($waktu[$j_waktu]);
                $waktu      = date_format($date, 'H:i:s d-m-Y');

                $response->aktivitas_waktu  = substr($s_aktivitas_waktu, 0, -1); 
                $response->aktivitas_id     = substr($s_aktivitas_id, 0, -1); 
                $response->aktivitas        = substr($s_aktivitas, 0, -1);
                $response->lab_akuns_id     = substr($s_lab_akuns_id, 0, -1); 
                $response->lab_akuns_nama   = substr($s_lab_akuns_nama, 0, -1); 
                $response->success = 1;
                $response->message = 'TERAKHIR UPDATE '.$waktu;
            }
        } catch (Exception $e) {
            $response->success = 1;
            $response->message = $e->getMessage();
        }
        die(json_encode($response));
    }
    #9. GET DETAIL TRACKING

    #10. INSERT DETAIL TRACKING
    /**
     * @OA\Post(
     *      path="/insertdetailtrackings/{aktivitas_waktu}/{data_sampels_id}/{aktivitas_id}/{lab_akuns_id}",
     *      operationId="getProjectById",
     *      tags={"10. Insert Detail Trackings"},
     *      summary="Memasukan Proses Tracking Baru",
     *      description="Memasukan Proses Tracking Baru",
     *      @OA\Parameter(
     *          name="aktivitas_waktu",
     *          description="Waktu",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="data_sampels_id",
     *          description="ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="aktivitas_id",
     *          description="aktivitas_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="lab_akuns_id",
     *          description="lab_akuns_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:projects", "read:projects"}
     *         }
     *     },
     * )
     */
    public static function InsertDetailTrackings(Request $request, $aktivitas_waktu = null, $data_sampels_id = null, $aktivitas_id = null, $lab_akuns_id = null)
    {
        $response                       = new usr();
        $str_aktivitas_waktu              = '';
        $str_data_sampels_id              = '';
        $str_aktivitas_id                 = '';
        $str_lab_akuns_id                 = '';

        if(
            (!isset($request->aktivitas_waktu) OR !isset($request->data_sampels_id) OR !isset($request->aktivitas_id) OR !isset($request->lab_akuns_id)) AND
            (!isset($aktivitas_waktu) OR !isset($data_sampels_id) OR !isset($aktivitas_id) OR !isset($lab_akuns_id))
        )
        {
            $response->success     = 0;
            $response->message     = 'ADA DATA YANG KOSONG';
        }
        elseif (
            isset($request->aktivitas_waktu) OR isset($request->data_sampels_id) OR isset($request->aktivitas_id) OR isset($request->lab_akuns_id)
        ) {
            $str_aktivitas_waktu              = $request->aktivitas_waktu;
            $str_data_sampels_id              = $request->data_sampels_id;
            $str_aktivitas_id                 = $request->aktivitas_id;
            $str_lab_akuns_id                 = $request->lab_akuns_id;
        } elseif (isset($aktivitas_waktu) OR isset($data_sampels_id) OR isset($aktivitas_id) OR isset($lab_akuns_id)) {
            $str_aktivitas_waktu              = $aktivitas_waktu;
            $str_data_sampels_id              = $data_sampels_id;
            $str_aktivitas_id                 = $aktivitas_id;
            $str_lab_akuns_id                 = $lab_akuns_id;
        }

        try {
            DB::table('detail_trackings')->insert([
                'aktivitas_waktu'           => $str_aktivitas_waktu,
                'data_sampels_id'           => $str_data_sampels_id,
                'aktivitas_id'              => $str_aktivitas_id,   
                'lab_akuns_id'              => $str_lab_akuns_id   
            ]);
            $response->success     = 1;
            $response->message     = 'BERHASIL MANAMBAHKAN AKTIVITAS TRACKING BARU';
        } catch (Exception $e) {
            $response->success     = 0;
            $response->message     = $e->getMessage();
        }
        die(json_encode($response));
    }
    #10. INSERT DETAIL TRACKING
#DETAIL TRACKING

#DATA SAMPELS
    #11. GET DATA SAMPELS ALL
    /**
     * @OA\Get(
     *      path="/getdatasampelsall",
     *      operationId="getProjectsList",
     *      tags={"11. Get Data Sampels All"},
     *      summary="Mendapatkan List Data Sampels (Data Kupa)",
     *      description="Mendapatkan List Data Sampels (Data Kupa)",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function GetDataSampelsAll()
    {
        $response           = new usr();
        $getdatasampelsall  = DB::table('data_sampels')
        ->join('pelanggans', 'data_sampels.pelanggans_id', '=', 'pelanggans.id')
        ->join('jenis_sampels', 'data_sampels.jenis_sampels_id', '=', 'jenis_sampels.id')
        ->select('data_sampels.*', 'pelanggans.nama as pelanggan', 'jenis_sampels.jenis_sampel as jenis_sampel')
        ->get();

        
        $getdatasampelsall      = json_decode(json_encode($getdatasampelsall), true);

        #DATA SAMPELS
        $s_id                   = ''; $s_pakets_id_s        = ''; $s_tanggal_masuk  = ''; $s_tanggal_selesai  = ''; 
        $s_nomor_surat          = ''; $s_jumlah_sampel      = ''; $s_status         = '';

        #PELANGGANS
        $s_pelanggans_id        = ''; $s_pelanggans_nama    = '';

        #JENIS SAMPELS
        $s_jenis_sampels_id     = ''; $s_jenis_sampel       = '';
        if(empty($getdatasampelsall))
        {
            $response->success = 0;
            $response->message = 'DATA SAMPEL MASIH KOSONG';
        }
        else{
            try {
                foreach ($getdatasampelsall as $value) {
                    #DATA SAMPELS
                    $s_id               .= $value['id'].'-';
                    $s_pakets_id_s      .= $value['jenis_sampels_id'].'-'; 

                    $date       = date_create($value['tanggal_masuk']);
                    $waktu      = date_format($date, 'H:i:s d-m-Y');

                    $s_tanggal_masuk    .= str_replace('-', '/', $waktu).'-'; 
                    $s_tanggal_selesai  .= $value['tanggal_selesai'].'-'; 
                    $s_nomor_surat      .= $value['nomor_surat'].'-'; 
                    $s_jumlah_sampel    .= $value['jumlah_sampel'].'-'; 
                    $s_status           .= $value['status'].'-';

                    #PELANGGANS
                    $s_pelanggans_id    .= $value['pelanggans_id'].'-'; 
                    $s_pelanggans_nama  .= $value['pelanggan'].'-';

                    #JENIS SAMPELS
                    $s_jenis_sampels_id .= $value['jenis_sampels_id'].'-'; 
                    $s_jenis_sampel     .= $value['jenis_sampel'].'-';
                }

                #DATA SAMPELS
                $response->id               = substr($s_id, 0, -1);
                $response->pakets_id_s      = substr($s_pakets_id_s, 0, -1); 
                $response->tanggal_masuk    = substr($s_tanggal_masuk, 0, -1); 
                $response->tanggal_selesai  = substr($s_tanggal_selesai, 0, -1); 
                $response->nomor_surat      = substr($s_nomor_surat, 0, -1); 
                $response->jumlah_sampel    = substr($s_jumlah_sampel, 0, -1); 
                $response->status           = substr($s_status, 0, -1);

                #PELANGGANS
                $response->pelanggans_id    = substr($s_pelanggans_id, 0, -1); 
                $response->pelanggans_nama  = substr($s_pelanggans_nama, 0, -1);

                #JENIS SAMPELS
                $response->jenis_sampels_id = substr($s_jenis_sampels_id, 0, -1); 
                $response->jenis_sampel     = substr($s_jenis_sampel, 0, -1);

            } catch (Exception $e) {
                $response->success = 0;
                $response->message = $e->getMessage();
            }
        }
        die(json_encode($response));
    }

    #12. GET DATA SAMPELS BY ID
    /**
     * @OA\get(
     *      path="/getdatasampelsbyid/{id}",
     *      operationId="getProjectsList",
     *      tags={"12. Get Data Sampels By Id"},
     *      summary="Mendapatkan List Data Sampels (Data Kupa) By ID",
     *      description="Mendapatkan List Data Sampels (Data Kupa) By ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID DATA SAMPELS",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function GetDataSampelsById(Request $request, $id = null)
    {
        $response           = new usr();
        $id_s               = '';

        if(!isset($request->id) AND !isset($id))
        {
            $response->success = 0;
            $response->message = 'ID KOSONG';
        }
        elseif(isset($request->id)){
            $id_s       = $request->id;
        }
        elseif(isset($id)){
            $id_s       = $id;
        }

        $getdatasampelsbyid  = DB::table('data_sampels')
        ->join('pelanggans', 'data_sampels.pelanggans_id', '=', 'pelanggans.id')
        ->join('jenis_sampels', 'data_sampels.jenis_sampels_id', '=', 'jenis_sampels.id')
        ->select('data_sampels.*', 'pelanggans.nama as pelanggan', 'jenis_sampels.jenis_sampel as jenis_sampel')
        ->where('data_sampels.id', '=', $id_s)
        ->get();

        
        $getdatasampelsbyid      = json_decode(json_encode($getdatasampelsbyid), true);

        #DATA SAMPELS
        $s_id                   = ''; $s_pakets_id_s        = ''; $s_tanggal_masuk  = ''; $s_tanggal_selesai  = ''; 
        $s_nomor_surat          = ''; $s_jumlah_sampel      = ''; $s_status         = '';

        #PELANGGANS
        $s_pelanggans_id        = ''; $s_pelanggans_nama    = '';

        #JENIS SAMPELS
        $s_jenis_sampels_id     = ''; $s_jenis_sampel       = '';

        if(empty($getdatasampelsbyid))
        {
            $response->success = 0;
            $response->message = 'DATA SAMPEL DENGAN :'.$id_s.' TIDAK DITEMUKAN';
        }
        else{
            try {
                foreach ($getdatasampelsbyid as $value) {
                    #DATA SAMPELS
                    $s_id               .= $value['id'].'-';
                    $s_pakets_id_s      .= $value['jenis_sampels_id'].'-'; 

                    $date       = date_create($value['tanggal_masuk']);
                    $waktu      = date_format($date, 'H:i:s d-m-Y');

                    $s_tanggal_masuk    .= str_replace('-', '/', $waktu).'-'; 
                    $s_tanggal_selesai  .= $value['tanggal_selesai'].'-'; 
                    $s_nomor_surat      .= $value['nomor_surat'].'-'; 
                    $s_jumlah_sampel    .= $value['jumlah_sampel'].'-'; 
                    $s_status           .= $value['status'].'-';

                    #PELANGGANS
                    $s_pelanggans_id    .= $value['pelanggans_id'].'-'; 
                    $s_pelanggans_nama  .= $value['pelanggan'].'-';

                    #JENIS SAMPELS
                    $s_jenis_sampels_id .= $value['jenis_sampels_id'].'-'; 
                    $s_jenis_sampel     .= $value['jenis_sampel'].'-';
                }

                #DATA SAMPELS
                $response->id               = substr($s_id, 0, -1);
                $response->pakets_id_s      = substr($s_pakets_id_s, 0, -1); 
                $response->tanggal_masuk    = substr($s_tanggal_masuk, 0, -1); 
                $response->tanggal_selesai  = substr($s_tanggal_selesai, 0, -1); 
                $response->nomor_surat      = substr($s_nomor_surat, 0, -1); 
                $response->jumlah_sampel    = substr($s_jumlah_sampel, 0, -1); 
                $response->status           = substr($s_status, 0, -1);

                #PELANGGANS
                $response->pelanggans_id    = substr($s_pelanggans_id, 0, -1); 
                $response->pelanggans_nama  = substr($s_pelanggans_nama, 0, -1);

                #JENIS SAMPELS
                $response->jenis_sampels_id = substr($s_jenis_sampels_id, 0, -1); 
                $response->jenis_sampel     = substr($s_jenis_sampel, 0, -1);

            } catch (Exception $e) {
                $response->success = 0;
                $response->message = $e->getMessage();
            }
        }
        die(json_encode($response));
    }
    #12. GET DATA SAMPELS BY ID

    #13. INSERT DATA SAMPELS
    /**
     * @OA\post(
     *      path="/insertdatasampels/{jenis_sampels_id}/{pelanggans_id}/{pakets_id_s}/{tanggal_masuk}/{tanggal_selesai}/{nomor_surat}/{jumlah_sampel}/{status}",
     *      operationId="getProjectsList",
     *      tags={"13. Insert Data Sampel"},
     *      summary="Menginputkan Data Kupa Baru",
     *      description="Menginputkan Data Kupa Baru",
     *      @OA\Parameter(
     *          name="jenis_sampels_id",
     *          description="JENIS SAMPELS ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="pelanggans_id",
     *          description="PELANGGANS ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="pakets_id_s",
     *          description="PAKET ID S",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="tanggal_masuk",
     *          description="TANGGAL MASUK",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="tanggal_selesai",
     *          description="TANGGAL SELESAI",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="nomor_surat",
     *          description="NOMOR SURAT",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="tanggal_selesai",
     *          description="TANGGAL SELESAI",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="jumlah_sampel",
     *          description="JUMLAH SAMPEL",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="status",
     *          description="STATUS",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function InsertDataSampels(Request $request, $jenis_sampels_id = null, $pelanggans_id = null, 
    $pakets_id_s = null, $tanggal_masuk = null, $tanggal_selesai = null, $nomor_surat = null, $jumlah_sampel = null,
    $status = null)
    {
        $m_data_sampels = new DataSampel();
        $response = new usr();

        $s_jenis_sampels_id     = ''; $s_pelanggans_id      = ''; $s_pakets_id_s    = ''; $s_tanggal_masuk = '';
        $s_tanggal_selesai      = ''; $s_nomor_surat        = ''; $s_jumlah_sampel  = ''; $s_status        = '';

        if(
            (!isset($request->jenis_sampels_id) OR !isset($request->pelanggans_id) OR !isset($request->pakets_id_s) OR 
            !isset($request->tanggal_masuk) OR !isset($request->tanggal_selesai) OR !isset($request->nomor_surat) OR 
            !isset($request->jumlah_sampel) OR !isset($request->status)) AND
            (!isset($jenis_sampels_id) OR !isset($pelanggans_id) OR !isset($pakets_id_s) OR 
            !isset($tanggal_masuk) OR !isset($tanggal_selesai) OR !isset($nomor_surat) OR 
            !isset($jumlah_sampel) OR !isset($status))
        )
        {
            $response->success = 0;
            $response->message = 'DATA WAJIB DIISI';
        }
        elseif(
            isset($request->jenis_sampels_id) OR isset($request->pelanggans_id) OR isset($request->pakets_id_s) OR 
            isset($request->tanggal_masuk) OR isset($request->tanggal_selesai) OR isset($request->nomor_surat) OR 
            isset($request->jumlah_sampel) OR isset($request->status)
        ){
            $s_jenis_sampels_id     = $request->jenis_sampels_id; 
            $s_pelanggans_id        = $request->pelanggans_id; 
            $s_pakets_id_s          = $request->pakets_id_s; 
            $s_tanggal_masuk        = $request->tanggal_masuk;
            $s_tanggal_selesai      = $request->tanggal_selesai; 
            $s_nomor_surat          = $request->nomor_surat; 
            $s_jumlah_sampel        = $request->jumlah_sampel;
            $s_status               = $request->status;
        }
        elseif(
            isset($jenis_sampels_id) OR isset($pelanggans_id) OR isset($pakets_id_s) OR 
            isset($tanggal_masuk) OR isset($tanggal_selesai) OR isset($nomor_surat) OR 
            isset($jumlah_sampel) OR isset($status)
        ){
            $s_jenis_sampels_id     = $jenis_sampels_id; 
            $s_pelanggans_id        = $pelanggans_id; 
            $s_pakets_id_s          = $pakets_id_s; 
            $s_tanggal_masuk        = $tanggal_masuk; 
            $s_tanggal_selesai      = $tanggal_selesai; 
            $s_nomor_surat          = $nomor_surat; 
            $s_jumlah_sampel        = $jumlah_sampel;
            $s_status               = $status;
        }

        $arr_data_sampels   = array(
            'jenis_sampels_id'  => $s_jenis_sampels_id,
            'pelanggans_id'     => $s_pelanggans_id,
            'pakets_id_s'       => $s_pakets_id_s,
            'tanggal_masuk'     => $s_tanggal_masuk,
            'tanggal_selesai'   => $s_tanggal_selesai,
            'nomor_surat'       => $s_nomor_surat,
            'jumlah_sampel'     => $s_jumlah_sampel,
            'status'            => $s_status
        );

        $rules = [
            'jenis_sampels_id'  => 'required|exists:jenis_sampels,id',
            'pelanggans_id'     => 'required|exists:pelanggans,id',
            'pakets_id_s'       => 'required|string|min:1',
            'tanggal_masuk'     => 'required|date|after:today',
            'tanggal_selesai'   => 'required|numeric|min:1',
            'nomor_surat'       => 'required|string|min:1',
            'jumlah_sampel'     => 'required|numeric|min:1',
            'status'            => 'required'
        ];

        $messages = [
            'jenis_sampels_id.required'     => 'ID JENIS SAMPEL WAJIB DIISI',
            'jenis_sampels_id.exists'       => 'ID JENIS SAMPEL TIDAK DITEMUKAN',
            'pelanggans_id.required'        => 'ID PELANGGAN SAMPEL WAJIB',
            'pelanggans_id.exists'          => 'ID PELANGGAN TIDAK DITEMUKAN',
            'pakets_id_s.required'          => 'PAKET ID WAJIB DIISI',
            'pakets_id_s.min'               => 'PAKET ID MINIMAL DIISI DENGAN 1 HURUF',
            'tanggal_masuk.required'        => 'PAKET ID MINIMAL DIISI DENGAN 1 HURUF',
            'tanggal_masuk.after'           => 'MINIMAL PENGISIAN TANGGAL ADALAH HARI INI',
            'tanggal_selesai.required'      => 'TANGGAL SELESAI WAJIB DIISI',
            'tanggal_selesai.min'           => 'MINIMAL PENGISIAN ADALAH 1 HARI',
            'nomor_surat.required'          => 'NOMOR SURAT WAJIB DIISI',
            'nomor_surat.min'               => 'MINIMAL PENGISIAN UNTUK NOMOR SURAT ADALAH 1 HURUF',
            'jumlah_sampel.required'        => 'JUMLAH SAMPEL WAJIB DIISI',
            'jumlah_sampel.min'             => 'MINIMAL PENGISIAN UNTUK JUMLAH SAMPEL ADALAH 1 BUAH',
            'status.required'               => 'STATUS WAJIB DIISI'
        ];

        $validator = Validator::make($arr_data_sampels, $rules, $messages);

        $status_save = 0;
        if($validator->fails())
        {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        }
        else
        {
            $m_data_sampels->jenis_sampels_id   = $s_jenis_sampels_id;
            $m_data_sampels->pelanggans_id      = $s_pelanggans_id;
            $m_data_sampels->pakets_id_s        = $s_pakets_id_s;
            $m_data_sampels->tanggal_masuk      = $s_tanggal_masuk;
            $m_data_sampels->tanggal_selesai    = $s_tanggal_selesai;
            $m_data_sampels->nomor_surat        = $s_nomor_surat;
            $m_data_sampels->jumlah_sampel      = $s_jumlah_sampel;
            $m_data_sampels->status             = $s_status;
            try {
                $m_data_sampels->save();

                $l_hasil_analisis   = DB::table('hasil_analisas')
                ->where('jenis_sampels_id', '=', $m_data_sampels->jenis_sampels_id) 
                ->orderByDesc('no_lab')->take(1)->get();
                
                $l_hasil_analisis   = json_decode(json_encode($l_hasil_analisis), true);
                $n                  = 0;
                $t                  = date('y', strtotime($m_data_sampels->tanggal_masuk));                
                $index  = 0; 
                if(empty($l_hasil_analisis))
                {
                    $n = $m_data_sampels->jumlah_sampel;
                    for ($i=1; $i <= $n ; $i++) { 
                        try {
                            DB::table('hasil_analisas')
                            ->insert([
                                'jenis_sampels_id'  => $m_data_sampels->jenis_sampels_id,
                                'data_sampels_id'   => $m_data_sampels->id,
                                'tahun'             => $t,
                                'no_lab'            => $i,
                                'kode_contoh'       => '',
                                'parameters_id_s'   => $m_data_sampels->pakets_id_s,
                                'hasil'             => '-;-;-',
                                'status'            => '0',
                                'retry'             => 0
                            ]);
                            $status_save = 1;
                        } catch (Exception $e) {
                            $response->success = 0;
                            $response->message = 'GAGAL MEMASUKAN DATA : '.$e->getMessage();
                        }
                    }
                    
                    if($status_save == 1)
                    {
                        $response->success = 1;
                        $response->message = 'BERHASIL MEMASUKAN DATA KUPA BARU';
                    }
                }
                else{
                    foreach ($l_hasil_analisis as $value) {
                        $n  = $m_data_sampels->jumlah_sampel + (int)$value['no_lab'];
                        $index  = (int)$value['no_lab'] + 1;
                    }
                    for ($i = $index; $i <= $n ; $i++) { 
                        try {
                            DB::table('hasil_analisas')
                            ->insert([
                                'jenis_sampels_id'  => $m_data_sampels->jenis_sampels_id,
                                'data_sampels_id'   => $m_data_sampels->id,
                                'tahun'             => $t,
                                'no_lab'            => $i,
                                'kode_contoh'       => '',
                                'parameters_id_s'   => $m_data_sampels->pakets_id_s,
                                'hasil'             => '-;-;-',
                                'status'            => '0',
                                'retry'             => 0
                            ]);
                            $status_save = 1;
                        } catch (Exception $e) {
                            $response->success = 0;
                            $response->message = 'GAGAL MEMASUKAN DATA : '.$e->getMessage();
                        }
                    }
                    if($status_save == 1)
                    {
                        $response->success = 1;
                        $response->message = 'BERHASIL MEMASUKAN DATA KUPA BARU';
                    }
                }

            } catch (Exception $e) {
                $response->success = 0;
                $response->message = $e->getMessage();
            }
        }
        die(json_encode($response));
    }
    #13. INSERT DATA SAMPELS

    #14. DELETE DATA SAMPELS
    /**
     * @OA\get(
     *      path="/deletedatasampels/{id}",
     *      operationId="getProjectsList",
     *      tags={"14. Delete Data Sampels"},
     *      summary="Menghapus Data Kupa",
     *      description="Menghapus Data Kupa",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID KUPA",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function DeleteDataSampels(Request $request, $id = null)
    {
        $id_s       = '';
        $response   = new usr();
        if(!isset($request->id) AND !isset($id))
        {
            $response->success = 0;
            $response->message = 'ID KUPA YANG INGIN DIHAPUS KOSONG';
        }
        elseif (isset($request->id)) {
            $id_s   = $request->id;
        }
        elseif (isset($id)){
            $id_s   = $id;
        }
        $status_hasil_analisa = 0;
        try {
            DB::table('hasil_analisas')
            ->where('data_sampels_id', '=', (int)$id_s)
            ->delete();
            $status_hasil_analisa = 1;
        } catch (Exception $e) {
            $response->success = 0;
            $response->message = 'GAGAL HAPUS DATA TABEL HASIL ANALIS DENGAN ID KUPA : '.$id_s.', PESAN KESALAHAN : '.$e->getMessage(); 
        }

        $status_detail_trackings = 0;
        if($status_hasil_analisa == 1)
        {
            try {
                DB::table('detail_trackings')
                ->where('data_sampels_id', '=', (int)$id_s)
                ->delete();
                $status_detail_trackings = 1;
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL HAPUS DATA TABEL DETAIL TRACKINGS DENGAN ID KUPA : '.$id_s.', PESAN KESALAHAN : '.$e->getMessage(); 
            }
        }

        if($status_detail_trackings == 1)
        {
            try {
                DB::table('data_sampels')
                ->where('id', '=', (int)$id_s)
                ->delete();
    
                $response->success = 1;
                $response->message = 'BERHASIL MENGHAPUS KUPA DENGAN ID: '.$id_s; 
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'HAPUS DATA DENGAN ID : '.$id_s.', PESAN KESALAHAN : '.$e->getMessage(); 
            }
        }
        die(json_encode($response));
        
    }
    #14. DELETE DATA SAMPELS

#DATA SAMPELS

#HASIL ANALISA
    #15. GET HASIL ANALISA
    /**
     * @OA\Get(
     *      path="/gethasilanalisas/{data_sampels_id}",
     *      operationId="getProjectsList",
     *      tags={"15. Get Hasil Analisa"},
     *      summary="Mendapatkan List Hasil Analisa dari ID",
     *      description="Mendapatkan List Hasil Analisa dari ID",
     *      @OA\Parameter(
     *          name="data_sampels_id",
     *          description="data_sampels_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function GetHasilAnalisas($data_sampels_id = null)
    {
        $response   = new usr();
        if (isset($data_sampels_id)) {
            $hasilanalisa    = DB::table('hasil_analisas')
                ->where('data_sampels_id', '=', $data_sampels_id)
                ->get();

            $hasilanalisa           = json_decode(json_encode($hasilanalisa), true);
            if ($hasilanalisa == []) {
                $response->success  = 0;
                $response->message  = "DATA TIDAK DITEMUKAN";
                die(json_encode($response));
            } else {
                $str_id                 = '';
                $str_tahun              = '';
                $str_jenis_samples_id   = '';
                $str_parameters_id_s    = '';
                $str_no_lab             = '';
                $str_hasil              = '';
                $str_status             = '';

                foreach ($hasilanalisa as $keys => $value) {

                    $str_id                 .= $value['id'] . '-';
                    $str_tahun              .= $value['tahun'] . '-';
                    $str_jenis_samples_id   .= $value['jenis_sampels_id'] . '-';
                    $str_parameters_id_s    .= $value['parameters_id_s'] . '-';
                    $str_no_lab             .= $value['no_lab'] . '-';
                    $str_hasil              .= $value['hasil'] . '-';
                    $str_status             .= $value['status'] . '-';
                }

                $str_id                 = substr($str_id, 0, -1);
                $str_tahun              = substr($str_id, 0, -1);
                $str_jenis_samples_id   = substr($str_jenis_samples_id, 0, -1);
                $str_parameters_id_s    = substr($str_parameters_id_s, 0, -1);
                $str_no_lab             = substr($str_no_lab, 0, -1);
                $str_hasil              = substr($str_hasil, 0, -1);
                $str_status             = substr($str_status, 0, -1);

                $response->id               = $str_id;
                $response->tahun            = $str_tahun;
                $response->jenis_samples_id = $str_jenis_samples_id;
                $response->parameters_id_s  = $str_parameters_id_s;
                $response->no_lab           = $str_no_lab;
                $response->hasil            = $str_hasil;
                $response->status           = $str_status;
                $response->success          = 1;
                $response->message          = 'DATA DITEMUKAN';
            }
        } else {
            $response->success = 0;
            $response->message = "KUPA TIDAK BOLEH KOSONG";
        }
        die(json_encode($response));
    }
    #15. GET HASIL ANALISA

    #16. UPDATE HASIL ANALISA
    /**
     * @OA\Post(
     *      path="/updatehasilanalisas/{id}/{hasil}",
     *      operationId="getProjectsList",
     *      tags={"16. Update Hasil Analisa"},
     *      summary="Melakukan Update Untuk Kolom Hasil Pada Tabel Hasil Analisa Berdasarkan Id Hasil Analisas",
     *      description="Melakukan Update Untuk Kolom Hasil Pada Tabel Hasil Analisa Berdasarkan Id Hasil Analisas",
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="hasil",
     *          description="hasil",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function UpdateHasilAnalisas(Request $request, $id = null, $hasil = null)
    {
        return 'mantap';
    }
    #16. UPDATE HASIL ANALISA
#HASIL ANALISA

#PELANGGANS
    #17. GET PELANGGANS
    /**
     * @OA\Get(
     *      path="/getpelanggans",
     *      operationId="getProjectsList",
     *      tags={"17. Get Pelanggan"},
     *      summary="Mendapatkan List Pelanggan Yang Sudah Terdaftar Ke Database",
     *      description="Mendapatkan List Pelanggan Yang Sudah Terdaftar Ke Database",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function GetPelanggans(){

    }
    #17. GET PELANGGANS
    
    #18. INSERT PELANGGANS
    /**
     * @OA\Post(
     *      path="/insertpelanggans",
     *      operationId="getProjectsList",
     *      tags={"18. Insert Pelanggan"},
     *      summary="Mendaftarkan Data Pelanggan Baru Ke Database Pelanggan",
     *      description="Mendaftarkan Data Pelanggan Baru Ke Database Pelanggan",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function InsertPelanggans(){

    }
    #18. INSERT PELANGGANS
    
    #19. UPDATE PELANGGANS  
    /**
     * @OA\Post(
     *      path="/updatepelanggans",
     *      operationId="getProjectsList",
     *      tags={"19. Update Pelanggan"},
     *      summary="Melakukan Update Data Pelanggan Berdasarkan Parameter Yang Dikirimkan",
     *      description="Melakukan Update Data Pelanggan Berdasarkan Parameter Yang Dikirimkan",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */  
    public static function UpdatePelanggans(){

    }
    #19. UPDATE PELANGGANS
    
    #20. DELETE PELANGGANS  
    /**
     * @OA\Get(
     *      path="/deletepelanggans",
     *      operationId="getProjectsList",
     *      tags={"20. Delete Pelanggan"},
     *      summary="Hapus Data Pelanggan Berdasarkan ID Pelanggan Yang Dikirimkan",
     *      description="Hapus Data Pelanggan Berdasarkan ID Pelanggan Yang Dikirimkan",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function DeletePelanggans(){

    }
    #20. DELETE PELANGGANS

    #21. LOGIN PELANGGANS
    /**
     * @OA\Post(
     *      path="/loginpelanggans",
     *      operationId="getProjectsList",
     *      tags={"21. Login Pelanggan"},
     *      summary="Login User Dengan Status Pelangan",
     *      description="Login User Dengan Status Pelangan",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function LoginPelanggans()
    {

    }
    #21. LOGIN PELANGGANS
#PELANGGANS

#AKTIVITAS
    #22. GET AKTIVITAS
    /**
     * @OA\Get(
     *      path="/getaktivitas",
     *      operationId="getProjectsList",
     *      tags={"22. Get Aktivitas"},
     *      summary="Mendapatkan List Aktivitas",
     *      description="Mendapatkan List Aktivitas",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    function GetAktivitas()
    {
        $response               = new usr();
        try {
            $aktivitas          = DB::table('aktivitas')
                ->get();
            $aktivitas          = json_decode(json_encode($aktivitas), true);

            $str_aktivitas_id   = '';
            $str_aktivitas      = '';

            if (count($aktivitas) < 1) {
                $response->success          = 0;
                $response->messages         = 'DATA JENIS SAMPEL TIDAK DITEMUKAN';
            } else if (count($aktivitas) > 0) {
                $str_aktivitas_id           = '';
                $str_aktivitas              = '';

                foreach ($aktivitas as $value) {
                    $str_aktivitas_id         .= $value['id'] . '-';
                    $str_aktivitas            .= $value['aktivitas'] . '-';
                }

                $str_aktivitas_id             = substr($str_aktivitas_id, 0, -1);
                $str_aktivitas                = substr($str_aktivitas, 0, -1);

                $response->id                 = $str_aktivitas_id;
                $response->aktivitas          = $str_aktivitas;
                $response->success            = 1;
            }
            die(json_encode($response));
        } catch (Exception $e) {
            $response->success      = 0;
            $response->message      = $e->getMessage();
            die(json_encode($response));
        }
    }
    #22. GET AKTIVITAS
#AKTIVITAS

#LAB AKUN
    #23. GET LAB AKUNS
    /**
     * @OA\get(
     *      path="/getakunlabs",
     *      operationId="getProjectsList",
     *      tags={"23. Get Data Akun Lab"},
     *      summary="Mendapatan List Data Akun Labs",
     *      description="Mendapatan List Data Akun Labs",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function GetAkunLabs()
    {
        $response   = new usr();
        $akun_labs  = DB::table('lab_akuns')
        ->join('akses_levels', 'lab_akuns.akses_levels_id', '=', 'akses_levels.id')
        ->select('lab_akuns.*', 'akses_levels.jabatan as akses_level')
        ->get();        
        $akun_labs  = json_decode(json_encode($akun_labs), true);
        
        $s_id               = ''; $s_metodes_id_s   = '';
        $s_akses_levels_id  = ''; $s_akses_level    = '';
        $s_nama             = ''; $s_email          = '';
        $s_password         = ''; $s_jabatan        = '';
        $s_status_akun      = '';

        if(empty($akun_labs))
        {
            $response->success = 0;
            $response->message = 'AKUN LAB MASIH KOSONG';
        }
        else{
            try {
                foreach ($akun_labs as $value) {
                    $s_id               .= $value['id'].'-'; 
                    $s_metodes_id_s     .= $value['metodes_id_s'].'-';
                    $s_akses_levels_id  .= $value['akses_levels_id'].'-'; 
                    $s_akses_level      .= $value['akses_level'].'-';
                    $s_nama             .= $value['nama'].'-'; 
                    $s_email            .= $value['email'].'-';
                    $s_password         .= $value['password'].'-'; 
                    $s_jabatan          .= $value['jabatan'].'-';
                    $s_status_akun      .= $value['status_akun'].'-';
                }
                $response->id               = substr($s_id, 0, -1);
                $response->metodes_id_s     = substr($s_metodes_id_s, 0, -1);
                $response->akses_levels_id  = substr($s_akses_levels_id, 0, -1);
                $response->akses_level      = substr($s_akses_level, 0, -1);
                $response->nama             = substr($s_nama, 0, -1);
                $response->email            = substr($s_email, 0, -1);
                $response->password         = substr($s_password, 0, -1);
                $response->jabatan          = substr($s_jabatan, 0, -1);
                $response->status_akun      = substr($s_status_akun, 0, -1);
                $response->success          = 1;
                $response->message          = 'LIST DATA AKUN LAB';
            } catch (Exception $e) {
                $response->success          = 0;
                $response->message          = 'GAGAL GET DATA AKUN LAB, PESAN KESALAHAN: '.$e->getMessage();
            }
        }
        die(json_encode($response));
    }
    #23. GET LAB AKUNS
    
    #24. POST LOGIN
    /**
     * @OA\Post(
     *      path="/loginuserlab/{email}/{password}",
     *      operationId="getProjectById",
     *      tags={"24. Loginlab"},
     *      summary="Get project information",
     *      description="Returns project data",
     *      @OA\Parameter(
     *          name="email",
     *          description="email user",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="password user",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:projects", "read:projects"}
     *         }
     *     },
     * )
     */
    function LoginUserLab(Request $request, $email = null, $password = null)
    {
        $response       = new usr();
        $str_email      = '';
        $str_password   = '';

        if (isset($email) and isset($password)) {
            $str_email      = $email;
            $str_password   = $password;
        } elseif (!empty($request->email) and !empty($request->password)) {
            $str_email      = $request->email;
            $str_password   = $request->password;
        } elseif (!isset($email) || !isset($password) || empty($request->email) || empty($request->password)) {
            $response->success = 0;
            $response->message = "Kolom tidak boleh kosong";
            die(json_encode($response));
        }

        $userLabLogin   = DB::table('lab_akuns')
            ->where('email', '=', $str_email)
            ->first();
        $userLabLogin   = json_decode(json_encode($userLabLogin), true);

        try {
            if ($userLabLogin == []) {
                $response->success      = 0;
                $response->message      = "USER TIDAK DITEMUKAN";
                die(json_encode($response));
            } elseif ($userLabLogin['password'] != $str_password) {
                $response->success      = 0;
                $response->message      = "INVALID PASSWORD";
                die(json_encode($response));
            } else {
                $response->id                       = $userLabLogin['id'];
                $response->nama                     = $userLabLogin['nama'];
                $response->akses_levels_id          = $userLabLogin['akses_levels_id'];
                $response->jabatan                  = $userLabLogin['jabatan'];
                $response->email                    = $userLabLogin['email'];
                $response->password                 = $userLabLogin['password'];
                $response->metode_id_s              = $userLabLogin['metodes_id_s'];
                $response->success                  = 1;
                die(json_encode($response));
            }
        } catch (Exception $e) {
            $response->success      = 0;
            $response->message      = $e->getMessage();
            die(json_encode($response));
        }
    }
    #24. POST LOGIN

    #25. UPDATE LAB AKUNS
    /**
     * @OA\post(
     *      path="/updatelabakuns/{id}/{metodes_id_s}/{akses_levels_id}/{nama}/{email}/{password}/{jabatan}/{status_akun}",
     *      operationId="getProjectsList",
     *      tags={"25. Update Akun Lab"},
     *      summary="Mengubah Data Lab Akun Baru",
     *      description="Mengubah Data Lab Akun Baru",
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="metodes_id_s",
     *          description="metodes_id_s",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="akses_levels_id",
     *          description="akses_levels_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="nama",
     *          description="nama",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          description="email",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="password",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="jabatan",
     *          description="jabatan",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="status_akun",
     *          description="status_akun",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function UpdateLabAkuns(Request $request, $id = null , $metodes_id_s = null, $akses_levels_id = null, 
    $nama = null, $email = null, $password = null, $jabatan = null, $status_akun = null)
    {
        $response = new usr();
        $s_id               = ''; $s_metodes_id_s   = ''; 
        $s_akses_levels_id  = ''; $s_nama           = ''; 
        $s_email            = ''; $s_password       = ''; 
        $s_jabatan          = ''; $s_status_akun    = '';
        if(
            (!isset($request->id) OR !isset($request->metodes_id_s) OR 
            !isset($request->akses_levels_id) OR !isset($request->nama) OR 
            !isset($request->email) OR !isset($request->password) OR 
            !isset($request->jabatan) OR !isset($request->status_akun)) AND
            (!isset($id) OR !isset($metodes_id_s) OR 
            !isset($akses_levels_id) OR !isset($nama) OR 
            !isset($email) OR !isset($password) OR 
            !isset($jabatan) OR !isset($status_akun))
        )
        {
            $response->success = 0;
            $response->message = 'DATA KOSONG';
        }
        elseif( isset($request->metodes_id_s) OR isset($request->akses_levels_id) OR 
                isset($request->nama) OR isset($request->email) OR 
                isset($request->password) OR isset($request->jabatan) OR 
                isset($request->status_akun))
        {
            $s_id               = $request->id;  
            $s_metodes_id_s     = $request->metodes_id_s;  
            $s_akses_levels_id  = $request->akses_levels_id; 
            $s_nama             = $request->nama; 
            $s_email            = $request->email; 
            $s_password         = $request->password; 
            $s_jabatan          = $request->jabatan; 
            $s_status_akun      = $request->status_akun;
        }
        elseif( isset($metodes_id_s) OR isset($akses_levels_id) OR 
                isset($nama) OR isset($email) OR 
                isset($password) OR  isset($jabatan) OR 
                isset($status_akun))
        {
            $s_id               = $id;  
            $s_metodes_id_s     = $metodes_id_s;  
            $s_akses_levels_id  = $akses_levels_id; 
            $s_nama             = $nama; 
            $s_email            = $email; 
            $s_password         = $password; 
            $s_jabatan          = $jabatan; 
            $s_status_akun      = $status_akun;
        }
        $d_lab_akuns    = array('id'                => $s_id,
                                'metodes_id_s'      => $s_metodes_id_s,
                                'akses_levels_id'   => $s_akses_levels_id,
                                'nama'              => $s_nama,
                                'email'             => $s_email, 
                                'password'          => $s_password,
                                'jabatan'           => $s_jabatan,
                                'status_akun'       => $s_status_akun);    
        $rules          = [
            'id'                => 'required|exists:lab_akuns,id',
            'metodes_id_s'      => 'required|string|min:1',
            'akses_levels_id'   => 'required|exists:akses_levels,id',
            'nama'              => 'required|string|min:3|max:50',
            'email'             => 'required|email',
            'password'          => 'required|string|min:8',
            'jabatan'           => 'required|string|min:2',
            'status_akun'       => 'required|numeric|min:0|max:1'
        ];
        $messages       = [
            'id.required'               => 'ID WAJIB DIISI',
            'id.exists'                 => 'ID LAB AKUN TIDAK DITEMUKAN',
            'metodes_id_s.required'     => 'METODE ID HARUS DIISI',
            'metodes_id_s.min'          => 'METODE ID HARUS DIISI DENGAN MINIMAL KARAKTER 1 HURUF',
            'akses_levels_id.required'  => 'AKSES LEVEL WAJIB DIISI',
            'akses_levels_id.exists'    => 'ID AKSES LEVEL TIDAK DITEMUKAN',
            'nama.required'             => 'NAMA WAJIB DIISI',
            'nama.min'                  => 'NAMA HARUS DIISI DENGAN MINIMAL KARAKTER 3 HURUF',
            'nama.max'                  => 'BATAS KARAKTER UNTUK PENGISIAN NAMA ADALAH 50 KARAKTER',
            'email.required'            => 'EMAIL WAJIB DIISI',
            'email.email'               => 'FORMAT PENGISIAN HARUS DIISI DENGAN EMAIL',
            'password.required'         => 'PASSWORD WAJIB DIISI',
            'password.min'              => 'PASSWORD HARUS DIISI DENGAN MINIMAL KARAKTER 8 HURUF',
            'jabatan.required'          => 'JABATAN WAJIB DIISI',
            'jabatan.min'               => 'JABATAN HARUS DIISI DENGAN MINIMAL KARAKTER 2 HURUF',
            'status_akun.required'      => 'STATUS AKUN WAJIB DIISI',
            'status_akun.min'           => 'STATUS AKUN NONAKTIF ADALAH 0',
            'status_akun.max'           => 'STATUS AKUN YANG AKTIF ADALAH 1'
        ];

        $validator = Validator::make($d_lab_akuns, $rules, $messages);

        if($validator->fails()){
            $response->success = 0;
            $response->message = $validator->errors()->first();
        }
        else{
            try {
                DB::table('lab_akuns')
                ->where('id', '=', $s_id)
                ->update([
                    'metodes_id_s'      => $d_lab_akuns['metodes_id_s'],
                    'akses_levels_id'   => $d_lab_akuns['akses_levels_id'],
                    'nama'              => $d_lab_akuns['nama'],
                    'email'             => $d_lab_akuns['email'],
                    'password'          => $d_lab_akuns['password'],
                    'jabatan'           => $d_lab_akuns['jabatan'],
                    'status_akun'       => $d_lab_akuns['status_akun']
                ]);
                $response->success = 1;
                $response->message = 'AKUN LAB BERHASIL DIUPDATE';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = $e->getMessage();
            }
        }
        die(json_encode($response));
    }
    #25. INSERT LAB AKUNS

    #26. INSERT LAB AKUNS
    /**
     * @OA\post(
     *      path="/insertlabakuns/{metodes_id_s}/{akses_levels_id}/{nama}/{email}/{password}/{jabatan}/{status_akun}",
     *      operationId="getProjectsList",
     *      tags={"26. Insert Akun Lab"},
     *      summary="Menambahkan Data Lab Akun Baru",
     *      description="Menambahkan Data Lab Akun Baru",
     *      @OA\Parameter(
     *          name="metodes_id_s",
     *          description="metodes_id_s",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="akses_levels_id",
     *          description="akses_levels_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="nama",
     *          description="nama",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          description="email",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="password",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="jabatan",
     *          description="jabatan",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="status_akun",
     *          description="status_akun",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function InsertLabAkuns(Request $request, $metodes_id_s = null, $akses_levels_id = null, 
    $nama = null, $email = null, $password = null, $jabatan = null, $status_akun = null)
    {
        $response = new usr();
        $s_metodes_id_s = ''; $s_akses_levels_id    = ''; 
        $s_nama         = ''; $s_email              = ''; 
        $s_password     = ''; $s_jabatan            = ''; 
        $s_status_akun  = '';
        if(
            (!isset($request->metodes_id_s) OR !isset($request->akses_levels_id) OR 
            !isset($request->nama) OR !isset($request->email) OR 
            !isset($request->password) OR !isset($request->jabatan) OR 
            !isset($request->status_akun)) AND
            (!isset($metodes_id_s) OR !isset($akses_levels_id) OR 
            !isset($nama) OR !isset($email) OR 
            !isset($password) OR  !isset($jabatan) OR 
            !isset($status_akun))
        )
        {
            $response->success = 0;
            $response->message = 'DATA KOSONG';
        }
        elseif( isset($request->metodes_id_s) OR isset($request->akses_levels_id) OR 
                isset($request->nama) OR isset($request->email) OR 
                isset($request->password) OR isset($request->jabatan) OR 
                isset($request->status_akun))
        {
            $s_metodes_id_s     = $request->metodes_id_s;  
            $s_akses_levels_id  = $request->akses_levels_id; 
            $s_nama             = $request->nama; 
            $s_email            = $request->email; 
            $s_password         = $request->password; 
            $s_jabatan          = $request->jabatan; 
            $s_status_akun      = $request->status_akun;
        }
        elseif( isset($metodes_id_s) OR isset($akses_levels_id) OR 
                isset($nama) OR isset($email) OR 
                isset($password) OR  isset($jabatan) OR 
                isset($status_akun))
        {
            $s_metodes_id_s     = $metodes_id_s;  
            $s_akses_levels_id  = $akses_levels_id; 
            $s_nama             = $nama; 
            $s_email            = $email; 
            $s_password         = $password; 
            $s_jabatan          = $jabatan; 
            $s_status_akun      = $status_akun;
        }
        $d_lab_akuns    = array('metodes_id_s'      => $s_metodes_id_s,
                                'akses_levels_id'   => $s_akses_levels_id,
                                'nama'              => $s_nama,
                                'email'             => $s_email, 
                                'password'          => $s_password,
                                'jabatan'           => $s_jabatan,
                                'status_akun'       => $s_status_akun);    
        $rules          = [
            'metodes_id_s'      => 'required|string|min:1',
            'akses_levels_id'   => 'required|exists:akses_levels,id',
            'nama'              => 'required|string|min:3|max:50',
            'email'             => 'required|email',
            'password'          => 'required|string|min:8',
            'jabatan'           => 'required|string|min:2',
            'status_akun'       => 'required|numeric|min:0|max:1'
        ];
        $messages       = [
            'metodes_id_s.required'     => 'METODE ID HARUS DIISI',
            'metodes_id_s.min'          => 'METODE ID HARUS DIISI DENGAN MINIMAL KARAKTER 1 HURUF',
            'akses_levels_id.required'  => 'AKSES LEVEL WAJIB DIISI',
            'akses_levels_id.exists'    => 'ID AKSES LEVEL TIDAK DITEMUKAN',
            'nama.required'             => 'NAMA WAJIB DIISI',
            'nama.min'                  => 'NAMA HARUS DIISI DENGAN MINIMAL KARAKTER 3 HURUF',
            'nama.max'                  => 'BATAS KARAKTER UNTUK PENGISIAN NAMA ADALAH 50 KARAKTER',
            'email.required'            => 'EMAIL WAJIB DIISI',
            'email.email'               => 'FORMAT PENGISIAN HARUS DIISI DENGAN EMAIL',
            'password.required'         => 'PASSWORD WAJIB DIISI',
            'password.min'              => 'PASSWORD HARUS DIISI DENGAN MINIMAL KARAKTER 8 HURUF',
            'jabatan.required'          => 'JABATAN WAJIB DIISI',
            'jabatan.min'               => 'JABATAN HARUS DIISI DENGAN MINIMAL KARAKTER 2 HURUF',
            'status_akun.required'      => 'STATUS AKUN WAJIB DIISI',
            'status_akun.min'           => 'STATUS AKUN NONAKTIF ADALAH 0',
            'status_akun.max'           => 'STATUS AKUN YANG AKTIF ADALAH 1'
        ];

        $validator = Validator::make($d_lab_akuns, $rules, $messages);
        $m_lab_akuns    = new LabAkun();   

        if($validator->fails()){
            $response->success = 0;
            $response->message = $validator->errors()->first();
        }
        else{
            $m_lab_akuns->metodes_id_s      = $d_lab_akuns['metodes_id_s'];
            $m_lab_akuns->akses_levels_id   = $d_lab_akuns['akses_levels_id'];
            $m_lab_akuns->nama              = $d_lab_akuns['nama'];
            $m_lab_akuns->email             = $d_lab_akuns['email'];
            $m_lab_akuns->password          = $d_lab_akuns['password'];
            $m_lab_akuns->jabatan           = $d_lab_akuns['jabatan'];
            $m_lab_akuns->status_akun       = $d_lab_akuns['status_akun'];
            try {
                $m_lab_akuns->save();
                $response->success = 0;
                $response->message = 'AKUN LAB BARU DITAMBAHKAN';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = $e->getMessage();
            }
        }
        die(json_encode($response));
    }
    #26. INSERT LAB AKUNS
    
    #27. DELETE LAB AKUNS
    /**
     * @OA\post(
     *      path="/deletelabakuns/{id}",
     *      operationId="getProjectsList",
     *      tags={"27. Delete Akun Lab"},
     *      summary="Hapus Data Lab Akun",
     *      description="Hapus Data Lab Akun",
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function DeleteLabAkuns(Request $request, $id = null)
    {
        $response       = new usr();
        $s_id           = '';
        if(!isset($request->id) AND !isset($id)){
            $response->succces = 0;
            $response->message = 'ID HARUS DIISI';
        }   
        elseif(isset($request->id)){
            $s_id       = $request->id;
        }
        elseif(isset($id)){
            $s_id       = $id;
        }

        $lab_akuns_by_id  = DB::table('lab_akuns')
        ->where('id', '=', $s_id)
        ->first();
        
        $lab_akuns_by_id   = json_decode(json_encode($lab_akuns_by_id), true);

        if(!empty($lab_akuns_by_id)){

            try {
                $del_lab_akuns = LabAkun::find($s_id);
                $del_lab_akuns->delete();
    
                $response->success = 1;
                $response->message = 'DATA LAB AKUNS DENGAN ID: '.$s_id.' BERHASIL DIHAPUS';
            } catch (Exception $e) {
                $response->success = 1;
                $response->message = 'GAGAL HAPUS LAB AKUNS PESAN KESALAHAN: '.$e->getMessage();
            }
        }
        else{
            $response->success = 0;
            $response->message = 'DATA TIDAK DITEMUKAN';
        }

        die(json_encode($response));
    }
    #27. DELETE LAB AKUNS
#LAB AKUN

#PAKETS
    #28. GET PAKET
    /**
     * @OA\Get(
     *      path="/getpakets",
     *      operationId="getProjectsList",
     *      tags={"28. Get Pakets"},
     *      summary="Mendapatkan List Data Pakets",
     *      description="Mendapatkan List Data Pakets",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function GetPakets()
    {
        $response       = new usr();
        $s_id       = ''; $s_jenis_sampels_id   = ''; $s_jenis_sampel = ''; 
        $s_paket    = ''; $s_parameters_id_s    = ''; $s_harga   = '';

        $get_pakets     = DB::table('pakets')
        ->join('jenis_sampels', 'pakets.jenis_sampels_id', '=', 'jenis_sampels.id')
        ->select('pakets.*', 'jenis_sampels.jenis_sampel as jenis_sampel')
        ->get();
        $get_pakets   = json_decode(json_encode($get_pakets), true);

        if(empty($get_pakets))
        {
            $response->success = 0;
            $response->message = 'BELUM ADA DATA UNTUK TABEL PAKET';
        }
        else{
            try {
                foreach ($get_pakets as $value) {
                    $s_id                   .= $value['id'].'-'; 
                    $s_jenis_sampels_id     .= $value['jenis_sampels_id'].'-'; 
                    $s_jenis_sampel         .= $value['jenis_sampel'].'-'; 
                    $s_paket                .= $value['paket'].'-'; 
                    $s_parameters_id_s      .= $value['parameters_id_s'].'-'; 
                    $s_harga                .= $value['harga'].'-';
                }
                $response->id               = substr($s_id, 0, -1);    
                $response->jenis_sampels_id = substr($s_jenis_sampels_id, 0, -1);
                $response->jenis_sampel     = substr($s_jenis_sampel, 0, -1);
                $response->paket            = substr($s_paket, 0, -1);
                $response->parameters_id_s  = substr($s_parameters_id_s, 0, -1);
                $response->harga            = substr($s_harga, 0, -1);
                $response->success          = 1;
                $response->message          = 'BERIKUT LIST DATA PAKET';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL GET DATA PAKET, PESAN KESALAHAN :'. $e->getMessage();
            }
        }

        die(json_encode($response));
    }
    #28. GET PAKET

    #29. INSERT PAKETS
    /**
     * @OA\Post(
     *      path="/insertpakets/{jenis_sampels_id}/{paket}/{parameters_id_s}/{harga}",
     *      operationId="getProjectsList",
     *      tags={"29. Insert Pakets"},
     *      summary="Mendapatkan List Jenis Sampel",
     *      description="Mendapatkan List Jenis Sampel",
     *      @OA\Parameter(
     *          name="jenis_sampels_id",
     *          description="JENIS SAMPELS ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="paket",
     *          description="PAKETS",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="parameters_id_s",
     *          description="PARAMETERS ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="harga",
     *          description="HARGA PAKETS",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function InsertPakets(Request $request, $jenis_sampels_id = null, $paket = null, $parameters_id_s = null, $harga = null)
    {
        $insert = '';
        $response = new usr();

        $s_jenis_sampels_id = ''; $s_paket = ''; $s_parameters_id_s = ''; $s_harga = 0;
        if  ((isset($jenis_sampels_id) or !isset($paket) or !isset($parameters_id_s) or !isset($harga)) AND
             (!isset($request->jenis_sampels_id) or !isset($request->paket) or !isset($request->parameters_id_s) or !isset($request->harga)))   
        {
            $response->success      = 0;
            $response->message      = 'DATA SWAGGER ATAU REQUEST KOSONG';
        }
        if(isset($jenis_sampels_id) or isset($paket) or isset($parameters_id_s) or isset($harga))
        {
            $s_jenis_sampels_id     = $jenis_sampels_id;
            $s_paket                = $paket;
            $s_parameters_id_s      = $parameters_id_s;
            $s_harga                = $harga;
        }
        elseif(isset($request->jenis_sampels_id)  or isset($request->paket)  or isset($request->parameters_id_s)  or isset($request->harga))   
        {
            $s_jenis_sampels_id     = $request->jenis_sampels_id;
            $s_paket                = $request->paket;
            $s_parameters_id_s      = $request->parameters_id_s;
            $s_harga                = $request->harga;
        }

        $rules = [
            'jenis_sampels_id'  => 'required|numeric|min:1',
            'paket'             => 'required|string|min:1',
            'parameters_id_s'   => 'required|string|min:1',
            'harga'             => 'required|numeric|min:10000'
        ];

        $messages   = [
            'jenis_sampels_id.required'     => 'Jenis Sampel Wajib Diisi',
            'jenis_sampels_id.numeric'      => 'Jenis Sampel Harus Angka',
            'jenis_sampels_id.min'          => 'Jenis Sampel Minimal 1',
            'paket.required'                => 'Paket Wajib Diisi',
            'paket.min'                     => 'Paket Wajib Diisi Minimal 1 Huruf',
            'parameters_id_s.required'      => 'Parameters ID Wajib Diisi',
            'parameters_id_s.min'           => 'Parameters ID Wajib Diisi Minimal 1 Huruf',
            'harga.required'                => 'Harga Wajib Diisi',
            'harga.numeric'                 => 'Harga Wajib Diisi Dengan Angka',
            'harga.min'                     => 'Harga Minimal Adalah 10000'
        ];
        
        $reqAll = [
            'jenis_sampels_id'  => $s_jenis_sampels_id,
            'paket'             => $s_paket,
            'parameters_id_s'   => $s_parameters_id_s,
            'harga'             => str_replace('.', '',$s_harga)
        ];

        $validator = Validator::make($reqAll, $rules, $messages);

        if($validator->fails()){
            $response->success = 0;
            $response->message = $validator->errors()->first();
        }
        else{
            $response->success = 1;
            $response->message = 'MANTAP';
        }
        
        try {
        } catch (Exception $e) {
            //throw $th;
        }

        die(json_encode($response));
    }
    #29. INSERT PAKETS

    #30. UPDATE PAKETS
    /**
     * @OA\Post(
     *      path="/updatepakets/{id}/{jenis_sampels_id}/{paket}/{parameters_id_s}/{harga}",
     *      operationId="getProjectsList",
     *      tags={"30. Update Pakets"},
     *      summary="Melakukan Perubahan Data Paket Berdasarkan Parameter Yang Ada",
     *      description="Melakukan Perubahan Data Paket Berdasarkan Parameter Yang Ada",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID PAKETS",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="jenis_sampels_id",
     *          description="JENIS SAMPELS ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="paket",
     *          description="PAKETS",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="parameters_id_s",
     *          description="HARGA PAKETS",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="harga",
     *          description="HARGA PAKETS",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function UpdatePakets(Request $request, $id = null, $jenis_sampels_id = null, $paket = null, $parameters_id_s = null, $harga = null)
    {
        $update = '';
        $response = new usr();

        $s_id = 0; $s_jenis_sampels_id = ''; $s_paket = ''; $s_parameters_id_s = ''; $s_harga = 0;
        if  (
                (!isset($id) or !isset($jenis_sampels_id) or !isset($paket) or !isset($parameters_id_s) or !isset($harga)) AND
                (!isset($request->id) or !isset($request->jenis_sampels_id) or !isset($request->paket) or !isset($request->parameters_id_s) or !isset($request->harga))
            )   
        {
            $response->message      = 'DATA SWAGGER ATAU REQUEST KOSONG';
        }
        if(isset($id) or isset($jenis_sampels_id) or isset($paket) or isset($parameters_id_s) or isset($harga))
        {
            $s_id                   = $id;
            $s_jenis_sampels_id     = $jenis_sampels_id;
            $s_paket                = $paket;
            $s_parameters_id_s      = $parameters_id_s;
            $s_harga                = $harga;
        }
        elseif  (isset($request->id)  or isset($request->jenis_sampels_id)  or isset($request->paket)  or isset($request->parameters_id_s)  or isset($request->harga))   
        {
            $s_id                   = $request->id;
            $s_jenis_sampels_id     = $request->jenis_sampels_id;
            $s_paket                = $request->paket;
            $s_parameters_id_s      = $request->parameters_id_s;
            $s_harga                = $request->harga;
        }

        try {
            $update     = DB::table('pakets')
            ->where('id', '=', $s_id)
            ->first();
            
            $update = json_decode(json_encode($update), true);
        } catch (Exception $e) {
            $response->success = 0;
            $response->message = 'QUERY SELECT BERMASALAH : '.$e->getMessage();
        } 

        if(empty($update))
        {
            $response->success = 0;
            $response->message = 'DATA TIDAK DITEMUKAN';
        }
        else{
            try {
                DB::table('pakets')
                ->where('id', '=', $s_id)
                ->update([
                    'jenis_sampels_id'  => $s_jenis_sampels_id,
                    'paket'             => $s_paket,
                    'parameters_id_s'   => $s_parameters_id_s,
                    'harga'             => $s_harga
                ]);

                $response->success = 1;
                $response->message = 'BERHASIL MELAKUKAN UPDATE DATA';
            } catch (\Throwable $th) {
                $response->success = 0;
                $response->message = 'GAGAL MELAKUKAN UPDATE : '.$e->getMessage();
            }
        }

        die(json_encode($response));
    }
    #30. UPDATE PAKETS

    #31. DELETE PAKETS
    /**
     * @OA\Get(
     *      path="/deletepakets/{id}",
     *      operationId="getProjectsList",
     *      tags={"31. Delete Paket"},
     *      summary="Hapus Data Paket Berdasarkan ID Paket",
     *      description="Hapus Data Paket Berdasarkan ID Paket",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID PAKETS",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public static function DeletePakets($id = null)
    {
        $delete = '';
        $response = new usr();
        if(!isset($id))
        {
            $response->success = 0;
            $response->message = 'PARAMETER ID TIDAK DITEMUKAN';
        }
        else{
            try {
                $delete = DB::table('pakets')
                ->where('id', '=', $id)
                ->first();
    
                $delete = json_decode(json_encode($delete), true);
    
                if(empty($delete)){
                    $response->success = 0;
                    $response->message = 'DATA TIDAK DITEMUKAN';
                }
                else{
                    try {
                        $delete = DB::table('pakets')
                        ->where('id', '=', $id)
                        ->delete();

                        $response->success = 1;
                        $response->message = 'BERHASIL MENGHAPUS DATA';
                    } catch (Exception $e) {
                        $response->success = 0;
                        $response->message = $e->getMessage();
                    }
                }
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = $e->getMessage();
            }
        }
        die(json_encode($response));
    }
    #31. DELETE PAKETS
#PAKETS
}
