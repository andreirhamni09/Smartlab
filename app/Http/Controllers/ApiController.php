<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Exception;
use PHPUnit\Framework\Constraint\Count;

use function PHPUnit\Framework\isEmpty;

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
        $response           = new usr();
        $getaktivitas       = DB::table('aktivitas')
            ->get();
        $getaktivitas       = json_decode(json_encode($getaktivitas), true);
        $str_aktivitas_id   = '';
        $str_aktivitas      = '';
        if (count($getaktivitas) == 0) {
            $response->success = 0;
            $response->message = 'DATA AKTIVITAS TIDAK DITEMUKAN';
        } else {
            $str_id   = '';
            $str_aktivitas      = '';

            foreach ($getaktivitas as $key => $value) {
                $str_id             .= $value['id'] . '-';
                $str_aktivitas      .= $value['aktivitas'] . '-';
            }
            $str_id             = substr($str_aktivitas_id, 0, -1);
            $str_aktivitas      = substr($str_aktivitas, 0, -1);

            $response->id           = $str_id;
            $response->aktivitas    = $str_aktivitas;
            $response->success      = 1;
        }
        die(json_encode($response));
    }
    #GET AKTIVITAS

    #POST TRACKING
    /**
     * @OA\Post(
     *      path="/updateproses/{aktivitas_waktu}/{data_sampels_id}/{aktivitas_id}/{lab_akuns_id}",
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
    function UpdateProses(Request $request, $aktivitas_waktu = null, $data_sampels_id = null, $aktivitas_id = null, $lab_akuns_id = null)
    {
        $response                       = new usr();
        $s_aktivitas_waktu              = '';
        $s_data_sampels_id              = '';
        $s_aktivitas_id                 = '';
        $s_lab_akuns_id                 = '';

        if (!empty($request->aktivitas_waktu) and !empty($request->data_sampels_id) and !empty($request->aktivitas_id) and !empty($request->lab_akuns_id)) {
            $s_aktivitas_waktu              = $request->aktivitas_waktu;
            $s_data_sampels_id              = $request->data_sampels_id;
            $s_aktivitas_id                 = $request->aktivitas_id;
            $s_lab_akuns_id                 = $request->lab_akuns_id;
        } elseif (isset($aktivitas_waktu) and isset($data_sampels_id) and isset($aktivitas_id) and isset($lab_akuns_id)) {
            $s_aktivitas_waktu              = $aktivitas_waktu;
            $s_data_sampels_id              = $data_sampels_id;
            $s_aktivitas_id                 = $aktivitas_id;
            $s_lab_akuns_id                 = $lab_akuns_id;
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
                'aktivitas_waktu'           => $s_aktivitas_waktu,
                'data_sampels_id'           => $s_data_sampels_id,
                'aktivitas_id'              => $s_aktivitas_id,
                'lab_akuns_id'              => $s_lab_akuns_id
            ]);
            $response->success     = 1;
            $response->message     = 'BERHASIL MANAMBAHKAN AKTIVITAS TRACKING BARU';
        } catch (Exception $e) {
            $response->success     = 0;
            $response->message     = $e->getMessage();
        }

        die(json_encode($response));
    }
    #POST TRACKING

    #GET HASILANALISA
    /**
     * @OA\Get(
     *      path="/gethasilanalisa/{data_sampels_id}",
     *      operationId="getProjectsList",
     *      tags={"Hasil Analisa"},
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
    function GetHasilAnalisa($data_sampels_id = null)
    {
        $response   = new usr();
        if (isset($data_sampels_id)) {
            $hasilanalisa    = DB::table('hasil_analisas')
                ->where('data_sampels_id', $data_sampels_id)
                ->get();

            $hasilanalisa           = json_decode(json_encode($hasilanalisa), true);
            if (count($hasilanalisa) <= 0) {
                $response->success  = 0;
                $response->message  = "DATA TIDAK DITEMUKAN";
                die(json_encode($response));
            } else {
                $s_id                 = '';
                $s_tahun              = '';
                $s_jenis_samples_id   = '';
                $s_parameters_id_s    = '';
                $s_no_lab             = '';
                $s_hasil              = '';
                $s_status             = '';

                foreach ($hasilanalisa as $key => $value) {

                    $s_id                 .= $value['id'] . '-';
                    $s_tahun              .= $value['tahun'] . '-';
                    $s_jenis_samples_id   .= $value['jenis_samples_id'] . '-';
                    $s_parameters_id_s    .= $value['parameters_id_s'] . '-';
                    $s_no_lab             .= $value['no_lab'] . '-';
                    $s_hasil              .= $value['hasil'] . '-';
                    $s_status             .= $value['status'] . '-';
                }

                $s_id                 = substr($s_id, 0, -1);
                $s_tahun              = substr($s_tahun, 0, -1);
                $s_jenis_samples_id   = substr($s_jenis_samples_id, 0, -1);
                $s_parameters_id_s    = substr($s_parameters_id_s, 0, -1);
                $s_no_lab             = substr($s_no_lab, 0, -1);
                $s_hasil              = substr($s_hasil, 0, -1);
                $s_status             = substr($s_status, 0, -1);

                $response->id               = $s_id;
                $response->tahun            = $s_tahun;
                $response->jenis_samples_id = $s_jenis_samples_id;
                $response->parameters_id_s  = $s_parameters_id_s;
                $response->no_lab           = $s_no_lab;
                $response->hasil            = $s_hasil;
                $response->status           = $s_status;
            }
        } else {
            $response->success = 0;
            $response->message = "KUPA TIDAK BOLEH KOSONG";
        }
        die(json_encode($response));
    }
    #GET HASILANALISA

#PAKETS
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
            die(json_encode($response));
        }
    }
#PAKETS
}
