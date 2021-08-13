<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Exception;
use PHPUnit\Framework\Constraint\Count;

use function PHPUnit\Framework\isEmpty;

use Illuminate\Support\Facades\Validator;

class usr
{
}
class ApiController extends Controller
{
    #POST LOGIN
    /**
     * @OA\Post(
     *      path="/loginuserlab/{email}/{password}",
     *      operationId="getProjectById",
     *      tags={"Login"},
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
    #POST LOGIN

    #GET PARAMETER
    /**
     * @OA\Get(
     *      path="/getparameter",
     *      operationId="getProjectsList",
     *      tags={"Parameter"},
     *      summary="Mendapatkan List Aktivitas",
     *      description="Mendapatkan List Parameter",
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
    #GET PARAMETER

    #GET JENIS SAMPEL
    /**
     * @OA\Get(
     *      path="/getjenissampel",
     *      operationId="getProjectsList",
     *      tags={"Jenis Sampels"},
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
    #GET JENIS SAMPEL

    #GET AKSES LEVEL
    /**
     * @OA\Get(
     *      path="/getakseslevels",
     *      operationId="getProjectsList",
     *      tags={"Akses Level"},
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
    #GET AKSES LEVEL

#AKTIVITAS
    #GET AKTIVITAS
    /**
     * @OA\Get(
     *      path="/getaktivitas",
     *      operationId="getProjectsList",
     *      tags={"Aktivitas"},
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
    #GET AKTIVITAS
#AKTIVITAS

#METODES
    #GET METODES
    /**
     * @OA\Get(
     *      path="/getmetodes",
     *      operationId="getProjectsList",
     *      tags={"Metode"},
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
    #GET METODES
#METODES

#DETAIL TRACKING
    #9. GET DETAIL TRACKING
    /**
     * @OA\Get(
     *      path="/getdetailtrackings/{data_sampels_id}",
     *      operationId="getProjectsList",
     *      tags={"Get Detail Trackings"},
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
     *      path="/insertdetailtracking/{aktivitas_waktu?}/{data_sampels_id?}/{aktivitas_id?}/{lab_akuns_id?}",
     *      operationId="getProjectById",
     *      tags={"Update Proses"},
     *      summary="Get project information",
     *      description="Returns project data",
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
     *          description="data_sampels_id ID",
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

        if (!empty($request->aktivitas_waktu) and !empty($request->data_sampels_id) and !empty($request->aktivitas_id) and !empty($request->lab_akuns_id)) {
            $str_aktivitas_waktu              = $request->aktivitas_waktu;
            $str_data_sampels_id              = $request->data_sampels_id;
            $str_aktivitas_id                 = $request->aktivitas_id;
            $str_lab_akuns_id                 = $request->lab_akuns_id;
        } elseif (isset($aktivitas_waktu) and isset($data_sampels_id) and isset($aktivitas_id) and isset($lab_akuns_id)) {
            $str_aktivitas_waktu              = $aktivitas_waktu;
            $str_data_sampels_id              = $data_sampels_id;
            $str_aktivitas_id                 = $aktivitas_id;
            $str_lab_akuns_id                 = $lab_akuns_id;
        } elseif (
            !isset($aktivitas_waktu) or !isset($data_sampels_id) or !isset($aktivitas_id) or !isset($lab_akuns_id)
            or empty($request->aktivitas_waktu) and empty($request->data_sampels_id) and empty($request->aktivitas_id) and empty($request->lab_akuns_id)
        ) {
            $response->success     = 0;
            $response->message     = 'ADA DATA YANG KOSONG';
            die(json_encode($response));
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

#HASIL ANALISA
    #GET HASILANALISA
    /**
     * @OA\Get(
     *      path="/gethasilanalisas/{data_sampels_id}",
     *      operationId="getProjectsList",
     *      tags={"Get Hasil Analisa"},
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
    #GET HASILANALISA
#HASIL ANALISA


#PAKETS
    #29. INSERT PAKETS
    /**
     * @OA\Post(
     *      path="/insertpakets/{jenis_sampels_id}/{paket}/{parameters_id_s}/{harga}",
     *      operationId="getProjectsList",
     *      tags={"Insert Pakets"},
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
     *      tags={"Update Pakets"},
     *      summary="Mendapatkan List Jenis Sampel",
     *      description="Mendapatkan List Jenis Sampel",
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
     *      tags={"DELETE PAKETS"},
     *      summary="Mendapatkan List Jenis Sampel",
     *      description="Mendapatkan List Jenis Sampel",
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

#CONTOH MENAMPILKAN RESPONSE DI WEB
    public static function ContohMenampilkanRespon($data_sampels_id = null){
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

        return view('admin.tes.tes', ['response' => $response]);
    }
#CONTOH MENAMPILKAN RESPONSE DI WEB
}
