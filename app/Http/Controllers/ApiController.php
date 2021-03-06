<?php

namespace App\Http\Controllers;

use App\Http\Controllers\usr as ControllersUsr;
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
use Illuminate\Bus\Batch;
use SebastianBergmann\Exporter\Exporter;


use SimpleSoftwareIO\QrCode\Facades\QrCode;


date_default_timezone_set("Asia/Jakarta");

class usr
{
}
class ApiController extends Controller
{

#1 - 4 PARAMETERS
    #1. GET PARAMETERS
    /**
     * @OA\Get(
     *      path="/getparameters",
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
    public static function GetParameters()
    {
        $response                   = new usr();
        $str_id                     = '';
        $str_simbol                 = '';
        $str_nama_unsur             = '';
        $parameter                  = DB::table('parameters')
            ->get();
        $parameter                  = json_decode(json_encode($parameter), true);

        try {
            if (empty($parameter)) {
                $response->success          = 0;
                $response->messages         = 'DATA PARAMETER TIDAK DITEMUKAN';
            } else {
                try {
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
                } catch (Exception $e) {
                    $response->success      = 0;
                    $response->message      = 'GAGAL GET DATA, PESAN KESALAHAN (' . $e->getMessage() . ')';
                }
            }
        } catch (Exception $e) {
            $response->success      = 0;
            $response->message      = 'QUERY GET PARAMETER ERROR, PESAN KESALAHAN (' . $e->getMessage() . ')';
        }
        return json_encode($response);
    }
    #1. GET PARAMETERS

    #2. INSERT PARAMETERS
    /**
     * @OA\Post(
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

        $s_simbol           = '';
        $s_nama_unsur       = '';
        if (
            (!isset($request->simbol) and !isset($request->nama_unsur)) and
            (!isset($simbol) and !isset($nama_unsur))
        ) {
            $response->success = 0;
            $response->message = 'DATA WAJIB DIISI';
        } elseif ((isset($request->simbol) or isset($request->nama_unsur))) {
            $s_simbol       = $request->simbol;
            $s_nama_unsur   = $request->nama_unsur;
        } elseif ((isset($simbol) or isset($nama_unsur))) {
            $s_simbol       = $simbol;
            $s_nama_unsur   = $nama_unsur;
        }

        $rules      = [
            'simbol'            => 'required|string|min:1|max:5',
            'nama_unsur'        => 'required|string|min:1|max:25'
        ];
        $messages   = [
            'simbol.required'          => 'SIMBOL WAJIB DIISI',
            'simbol.min'               => 'SIMBOL WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'simbol.max'               => 'SIMBOL WAJIB DIISI DENGAN HURUF MAKSIMAL 5 KARAKTER',
            'nama_unsur.required'      => 'NAMA UNSUR WAJIB DIISI',
            'nama_unsur.min'           => 'NAMA UNSUR WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'nama_unsur.max'           => 'NAMA UNSUR WAJIB DIISI DENGAN HURUF MAKSIMAL 25 KARAKTER',
        ];
        $arr_parameter = array(
            'simbol'        => $s_simbol,
            'nama_unsur'    => $s_nama_unsur
        );

        $validator = Validator::make($arr_parameter, $rules, $messages);
        if ($validator->fails()) {
            $response->success  = 0;
            $response->message = 'TERJADI KESALAHAN SAAT INGIN MENAMBAHKAN DATA, PESAN KESALAHAN :' . $validator->errors()->first();
        } else {
            try {
                DB::table('parameters')
                    ->insert([
                        'simbol'        => $arr_parameter['simbol'],
                        'nama_unsur'    => $arr_parameter['nama_unsur']
                    ]);

                $response->success  = 1;
                $response->message  = 'BERHASIL MENAMBAHKAN DATA KE TABEL PARAMETERS';
            } catch (Exception $e) {
                $response->success  = 0;
                $response->message  = 'GAGAL MENAMBAHKAN DATA BARU :' . $e->getMessage();
            }
        }

        return json_encode($response);
    }
    #2. INSERT PARAMETERS

    #3. UPDATE PARAMETERS
    /**
     * @OA\Post(
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

        $s_id = '';
        $s_simbol = '';
        $s_nama_unsur = '';
        if (
            (!isset($request->id) and !isset($request->simbol) and !isset($request->nama_unsur)) and
            (!isset($id) and !isset($simbol) and !isset($nama_unsur))
        ) {
            $response->success = 0;
            $response->message = 'DATA WAJIB DIISI';
        } elseif (
            isset($request->id) or isset($request->simbol) or isset($request->nama_unsur)
        ) {
            $s_id           = $request->id;
            $s_simbol       = $request->simbol;
            $s_nama_unsur   = $request->nama_unsur;
        } elseif (
            isset($id) or isset($simbol) or isset($nama_unsur)
        ) {
            $s_id           = $id;
            $s_simbol       = $simbol;
            $s_nama_unsur   = $nama_unsur;
        }

        $rules      = [
            'id'                => 'required|exists:parameters,id',
            'simbol'            => 'required|string|min:1|max:5',
            'nama_unsur'        => 'required|string|min:1|max:25'
        ];
        $messages   = [
            'id.required'              => 'ID PARAMETER YANG INGIN DIUPDATE HARUS ADA',
            'id.exists'                => 'ID PARAMETER TIDAK DITEMUKAN',
            'simbol.required'          => 'SIMBOL WAJIB DIISI',
            'simbol.min'               => 'SIMBOL WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'simbol.max'               => 'SIMBOL WAJIB DIISI DENGAN HURUF MAKSIMAL 5 KARAKTER',
            'nama_unsur.required'      => 'NAMA UNSUR WAJIB DIISI',
            'nama_unsur.min'           => 'NAMA UNSUR WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'nama_unsur.max'           => 'NAMA UNSUR WAJIB DIISI DENGAN HURUF MAKSIMAL 25 KARAKTER',
        ];
        $arr_parameter = array(
            'id'            => $s_id,
            'simbol'        => $s_simbol,
            'nama_unsur'    => $s_nama_unsur
        );

        $validator = Validator::make($arr_parameter, $rules, $messages);
        if ($validator->fails()) {
            $response->success  = 0;
            $response->message = 'TERJADI KESALAHAN SAAT INGIN MENGUPDATE DATA, PESAN KESALAHAN :' . $validator->errors()->first();
        } else {
            try {
                DB::table('parameters')
                    ->where('id', '=', $s_id)
                    ->update([
                        'simbol'        => $s_simbol,
                        'nama_unsur'    => $s_nama_unsur
                    ]);

                $response->success  = 1;
                $response->message  = 'BERHASIL MELAKUKAN UPDATE DATA DENGAN ID :' . $s_id;
            } catch (Exception $e) {
                $response->success  = 0;
                $response->message  = 'GAGAL MELAKUKAN UPDATE DATA :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #3. UPDATE PARAMETERS

    #4. DELETE PARAMETERS
    /**
     * @OA\Get(
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
    public static function DeleteParameters($id = null)
    {
        $response           = new usr();
        $deleteparameter    = '';
        $s_id               = '';
        if (!isset($id)) {
            $response->success = 0;
            $response->message = 'DATA WAJIB DIISI';
        } elseif (isset($id)) {
            $s_id           = $id;
        }

        $deleteparameter    = DB::table('parameters')
            ->where('id', '=', $s_id)
            ->first();
        if (empty($deleteparameter)) {
            $response->success = 0;
            $response->message = 'DATA DENGAN ID: ' . $s_id . ' DITEMUKAN';
        } else {
            try {
                DB::table('parameters')
                    ->where('id', '=', $s_id)
                    ->delete();

                $response->success = 1;
                $response->message = 'DATA DENGAN ID :' . $s_id . ' BERHASIL DIHAPUS';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL HAPUS DATA :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #4. DELETE PARAMETERS

#1 - 4 PARAMETERS

#5 AKSES LEVEL
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
    public static function GetAksesLevels()
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
                    $str_halamans_id_s      .= $value['halamans_id_s'] . ';';
                }

                $str_id                     = substr($str_id, 0, -1);
                $str_jabatan                = substr($str_jabatan, 0, -1);
                $str_halamans_id_s          = substr($str_halamans_id_s, 0, -1);

                $response->id               = $str_id;
                $response->jabatan          = $str_jabatan;
                $response->halamans_id_s    = $str_halamans_id_s;
                $response->success          = 1;
            }
        } catch (Exception $e) {
            $response->success      = 0;
            $response->message      = $e->getMessage();
        }
        return json_encode($response);
    }

    # INSERT AKSES LEVELS
    public static function InsertAksesLevels(Request $request)
    {
        $response   = new usr();

        $str_id             = $request->id;
        $str_jabatan        = $request->jabatan;
        $str_halamans_id_s  = '';
        for ($i = 0; $i < count($request->halamans_id_s); $i++) {
            $str_halamans_id_s .= $request->halamans_id_s[$i] . '-';
        }
        $str_halamans_id_s = substr($str_halamans_id_s, 0, -1);

        $arr_akseslevels  = [
            'id'            => $str_id,
            'jabatan'       => $str_jabatan,
            'halamans_id_s' => $str_halamans_id_s
        ];

        $rules      = [
            'id'            => 'required|numeric|min:1',
            'jabatan'       => 'required|string|min:2'
        ];
        $messages   = [
            'id.required'               => 'ID AKSES LEVEL WAJIB DIISI',
            'id.min'                    => 'ID AKSES LEVEL MINIMAL DIISI DENGAN ANGKA MINIMAL 1',
            'jabatan.required'          => 'JABATAN WAJIB DIISI',
            'jabatan.min'               => 'JABATAN WAJIB DIISI DENGAN HURUF MINIMAL 2 KARAKTER'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $response->success = 0;
            $response->message = 'TERJADI KESALAHAN PENGISIAN DATA, PESAN KESALAHAN :' . $validator->errors()->first();
        } else {
            try {
                DB::table('akses_levels')
                    ->insert([
                        'id'            => $arr_akseslevels['id'],
                        'jabatan'       => $arr_akseslevels['jabatan'],
                        'halamans_id_s' => $arr_akseslevels['halamans_id_s']
                    ]);
                $response->success = 1;
                $response->message = 'AKSES LEVEL BARU BERHASIL DIINPUTKAN';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL MEMASUKAN DATA AKSES LEVEL BARU, PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }

    # UPDATE AKSES LEVELS
    public static function UpdateAksesLevels(Request $request)
    {
        $response = new usr();
        $str_id             = $request->id;
        $str_u_id           = $request->u_id;
        $str_jabatan        = $request->jabatan;
        $str_halamans_id_s  = '';
        for ($i = 0; $i < count($request->halamans_id_s); $i++) {
            $str_halamans_id_s .= $request->halamans_id_s[$i] . '-';
        }
        $str_halamans_id_s = substr($str_halamans_id_s, 0, -1);

        $arr_akseslevels  = [
            'id'            => $str_id,
            'u_id'          => $str_u_id,
            'jabatan'       => $str_jabatan,
            'halamans_id_s' => $str_halamans_id_s
        ];

        $rules      = [
            'id'              => 'required|exists:akses_levels,id',
            'u_id'            => 'required|numeric|min:1',
            'jabatan'         => 'required|string|min:2'
        ];
        $messages   = [
            'id.required'                 => 'ID AKSES LEVEL WAJIB DIISI',
            'id.exists'                   => 'ID AKSES TIDAK DITEMUKAN',
            'u_id.required'               => 'ID AKSES LEVEL WAJIB DIISI',
            'u_id.min'                    => 'ID AKSES LEVEL MINIMAL DIISI DENGAN ANGKA MINIMAL 1',
            'jabatan.required'            => 'JABATAN WAJIB DIISI',
            'jabatan.min'                 => 'JABATAN WAJIB DIISI DENGAN HURUF MINIMAL 2 KARAKTER'
        ];


        $validator = Validator::make($arr_akseslevels, $rules, $messages);
        if ($validator->fails()) {
            $response->success = 0;
            $response->message = 'TERJADI KESALAHAN PENGISIAN DATA, PESAN KESALAHAN :' . $validator->errors()->first();
        } else {
            try {
                DB::table('akses_levels')
                    ->where('id', '=', $request->id)
                    ->update([
                        'id'            => $arr_akseslevels['u_id'],
                        'jabatan'       => $arr_akseslevels['jabatan'],
                        'halamans_id_s' => $arr_akseslevels['halamans_id_s']
                    ]);
                $response->success = 1;
                $response->message = 'AKSES LEVEL BARU BERHASIL DI UPDATE';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL UPDATE DATA AKSES LEVE, PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }

    # DELETE AKSES LEVELS
    public static function DeleteAksesLevels($id = null)
    {
        $response   = new usr();
        $s_id       = '';
        if (!isset($id)) {
            $response->success = 0;
            $response->message = 'DATA ID AKSES LEVEL TIDAK BOLEH KOSONG';
        } else {
            $s_id   = $id;
        }

        $f_akseslevels = DB::table('akses_levels')
            ->where('id', '=', $s_id)
            ->first();

        if (empty($f_akseslevels)) {
            $response->success = 0;
            $response->message = 'DATA AKSES LEVEL TIDAK DITEMUKAN';
        } else {
            try {
                DB::table('akses_levels')
                    ->where('id', '=', $s_id)
                    ->delete();

                $response->success = 1;
                $response->message = 'DATA AKSES LEVEL BERHASIL DIHAPUS';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL HAPUS DATA AKSES LEVELS, PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #5. GET AKSES LEVEL
#5 AKSES LEVEL

#6 JENIS SAMPEL
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
    public static function GetJenisSampels()
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
                $response->message          = 'BERIKUT LIST DATA JENIS SAMPEL';
            }
        } catch (Exception $e) {
            $response->success      = 0;
            $response->message      = $e->getMessage();
        }
        return json_encode($response);
    }

    #INSERT JENIS SAMPELS
    public static function InsertJenisSampels(Request $request)
    {
        $response   = new usr();
        $rules      = [
            'jenissampels'      => 'required|string|min:2|max:20',
            'lambangsampel'     => 'required|string|min:1|max:3'
        ];
        $messages   = [
            'jenissampels.required'     => 'JENIS SAMPEL WAJIB DIISI',
            'jenissampels.min'          => 'JENIS SAMPEL WAJIB DIISI DENGAN HURUF MINIMAL 2 KARAKTER',
            'jenissampels.max'          => 'JENIS SAMPEL WAJIB DIISI DENGAN HURUF MAKSIMAL 20 KARAKTER',
            'lambangsampel.required'  => 'LAMBANG SAMPEL WAJIB DIISI',
            'lambangsampel.min'       => 'LAMBANG SAMPEL WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'lambangsampel.max'       => 'LAMBANG SAMPEL WAJIB DIISI DENGAN HURUF MAKSIMAL 3 KARAKTER'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $response->success = 0;
            $response->message = 'TERJADI KESALAHAN PENGISIAN DATA, PESAN KESALAHAN :' . $validator->errors()->first();
        } else {
            try {
                DB::table('jenis_sampels')
                    ->insert([
                        'jenis_sampel'      => $request->jenissampels,
                        'lambang_sampel'    => $request->lambangsampel
                    ]);
                $response->success = 1;
                $response->message = 'DATA JENIS SAMPEL BARU BERHASIL DIINPUTKAN';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL MENGINSERTKAN DATA, PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #INSERT JENIS SAMPELS

    #UPDATE JENIS SAMPELS
    public static function UpdateJenisSampels(Request $request)
    {
        $response   = new usr();
        $rules      = [
            'uid'              => 'required|exists:jenis_sampels,id',
            'ujenissampels'    => 'required|string|min:2|max:20',
            'ulambangsampels'   => 'required|string|min:1|max:3'
        ];
        $messages   = [
            'uid.required'                 => 'ID UNTUK MENGUPDATE JENIS SAMPEL WAJIB DIISI',
            'uid.exists'                   => 'ID JENIS SAMPEL TIDAK DITEMUKAN',
            'ujenissampels.required'       => 'JENIS SAMPEL WAJIB DIISI',
            'ujenissampels.min'            => 'JENIS SAMPEL WAJIB DIISI DENGAN HURUF MINIMAL 2 KARAKTER',
            'ujenissampels.max'            => 'JENIS SAMPEL WAJIB DIISI DENGAN HURUF MAKSIMAL 20 KARAKTER',
            'ulambangsampels.required'      => 'LAMBANG SAMPEL WAJIB DIISI',
            'ulambangsampels.min'           => 'LAMBANG SAMPEL WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'ulambangsampels.max'           => 'LAMBANG SAMPEL WAJIB DIISI DENGAN HURUF MAKSIMAL 3 KARAKTER'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $response->success = 0;
            $response->message = 'TERJADI KESALAHAN PENGISIAN DATA, PESAN KESALAHAN :' . $validator->errors()->first();
        } else {
            $updatejenissampels     = DB::table('jenis_sampels')
                ->where('id', '=', $request->uid)
                ->first();
            $updatejenissampels     = json_decode(json_encode($updatejenissampels), true);
            if (!empty($updatejenissampels)) {
                try {
                    DB::table('jenis_sampels')
                        ->where('id', '=', $request->uid)
                        ->update([
                            'jenis_sampel'     => $request->ujenissampels,
                            'lambang_sampel'   => $request->ulambangsampels
                        ]);
                    $response->success = 1;
                    $response->message = 'BERHASIL UPDATE DATA JENIS SAMPEL';
                } catch (Exception $e) {
                    $response->success = 0;
                    $response->message = 'TERJADI KESALAHAN KETIKA UPDATE DATA JENIS SAMPEL, PESAN KESALAHAN :' . $e->getMessage();
                }
            } else {
                $response->success = 0;
                $response->message = 'DATA YANG INGIN DIUPDATE TIDAK DITEMUKAN';
            }
        }
        return json_encode($response);
    }
    #UPDATE JENIS SAMPELS

    #DELETE JENIS SAMPELS
    public static function DeleteJenisSampels($id = null)
    {
        $response = new usr();
        if (!isset($id)) {
            $response->success = 0;
            $response->message = 'ID JENIS SAMPEL YANG INGIN DIHAPUS KOSONG';
        } else {
            try {
                DB::table('jenis_sampels')
                    ->where('id', '=', $id)
                    ->delete();
                $response->success = 1;
                $response->message = 'DATA DENGAN ID :' . $id . ' BERHASIL DIHAPUS';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'DATA JENIS SAMPEL DENGAN ID :' . $id . ' GAGAL DIHAPUS, PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #DELETE JENIS SAMPELS
    #6. GET JENIS SAMPELS
#6 JENIS SAMPEL

#7 METODES
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
    public static function GetMetodes()
    {
        $response   = new usr();
        $metodes    = DB::table('metodes')->get();
        $metodes    = json_decode(json_encode($metodes), true);

        $str_id                 = '';
        $str_metode             = '';
        $str_parameters_id_s    = '';

        if (empty($metodes)) {
            $response->success          = 0;
            $response->messages         = 'DATA METODE TIDAK DITEMUKAN';
        } else {
            try {
                foreach ($metodes as $value) {
                    $str_id                 .= $value['id'] . '-';
                    $str_metode             .= $value['metode'] . '-';
                    $str_parameters_id_s    .= $value['parameters_id_s'] . ';';
                }
                $response->id                 = substr($str_id, 0, -1);
                $response->metode             = substr($str_metode, 0, -1);
                $response->parameters_id_s    = substr($str_parameters_id_s, 0, -1);
                $response->success            = 1;
                $response->message            = 'BERIKUT LIST METODE';
            } catch (Exception $e) {
                $response->success            = 0;
                $response->message            = 'GAGAL MENDAPATKAN LIST METODE, PESAN KESALAHAN: ' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #7. GET METODES

    #INSERT METODES
    public static function InsertMetodes(Request $request)
    {
        $str_metode             = $request->metodes;
        $str_parameters_id_s    = '';
        foreach ($request->parameters_id_s as $value) {
            $str_parameters_id_s .= $value . '-';
        }
        $str_parameters_id_s = substr($str_parameters_id_s, 0, -1);
        $arr_metode         = [
            'metode'            => $str_metode,
            'parameters_id_s'   => $str_parameters_id_s
        ];

        $response   = new usr();
        $rules      = [
            'metode'            => 'required|string|min:1|max:75',
            'parameters_id_s'   => 'required|string|min:1|max:45'
        ];
        $messages   = [
            'metode.required'          => 'METODE WAJIB DIISI',
            'metode.min'               => 'METODE WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'metode.max'               => 'METODE WAJIB DIISI DENGAN HURUF MAKSIMAL 75 KARAKTER',
            'parameters_id_s.required'  => 'PARAMETER ID WAJIB DIISI',
            'parameters_id_s.min'       => 'PARAMETER ID WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'parameters_id_s.max'       => 'PARAMETER ID WAJIB DIISI DENGAN HURUF MAKSIMAL 45 KARAKTER',
        ];
        $validator = Validator::make($arr_metode, $rules, $messages);
        if ($validator->fails()) {
            $response->success = 0;
            $response->message = 'TERJADI KESALAHAN PENGISIAN DATA, PESAN KESALAHAN :' . $validator->errors()->first();
        } else {
            try {
                DB::table('metodes')
                    ->insert([
                        'metode'            => $arr_metode['metode'],
                        'parameters_id_s'   => $arr_metode['parameters_id_s']
                    ]);
                $response->success = 1;
                $response->message = 'METODE BARU BERHASIL DIINPUTKAN';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'TERJADI SAAT MENAMBAHKAN DATA KE TABEL METODE, PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #INSERT METODES

    #UPDATE METODES
    public static function UpdateMetodes(Request $request)
    {
        $response = new usr();
        $str_id                 = $request->id;
        $str_metode             = $request->metode;
        $str_parameters_id_s    = '';
        foreach ($request->parameters_id_s as $value) {
            $str_parameters_id_s .= $value . '-';
        }
        $str_parameters_id_s = substr($str_parameters_id_s, 0, -1);
        $arr_metode         = [
            'id'                => $str_id,
            'metode'            => $str_metode,
            'parameters_id_s'   => $str_parameters_id_s
        ];
        $rules      = [
            'id'                => 'required|exists:metodes,id',
            'metode'            => 'required|string|min:1|max:75',
            'parameters_id_s'   => 'required|string|min:1|max:45'
        ];
        $messages   = [
            'id.required'               => 'ID WAJIB DIISI',
            'id.exists'                 => 'ID METODE TIDAK DITEMUKAN',
            'metode.required'           => 'METODE WAJIB DIISI',
            'metode.exists'             => 'METODE ID TIDAK DITEMUKAN',
            'metode.min'                => 'METODE WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'metode.max'                => 'METODE WAJIB DIISI DENGAN HURUF MAKSIMAL 75 KARAKTER',
            'parameters_id_s.required'  => 'PARAMETER ID WAJIB DIISI',
            'parameters_id_s.min'       => 'PARAMETER ID WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'parameters_id_s.max'       => 'PARAMETER ID WAJIB DIISI DENGAN HURUF MAKSIMAL 45 KARAKTER',
        ];
        $validator = Validator::make($arr_metode, $rules, $messages);
        if ($validator->fails()) {
            $response->success  = 0;
            $response->message = 'TERJADI KESALAHAN SAAT INGIN MENGUPDATE DATA, PESAN KESALAHAN :' . $validator->errors()->first();
        } else {
            try {
                DB::table('metodes')
                    ->where('id', '=', $arr_metode['id'])
                    ->update([
                        'metode'            => $arr_metode['metode'],
                        'parameters_id_s'   => $arr_metode['parameters_id_s']
                    ]);

                $response->success  = 1;
                $response->message = 'DATA BERHASIL DIUPDATE';
            } catch (Exception $e) {
                $response->success  = 0;
                $response->message = 'TERJADI KESALAHAN SAAT INGIN MENGUPDATE DATA, PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #UPDATE METODES

    #DELETE METODES
    public static function DeleteMetodes($id)
    {
        $response = new usr();
        try {
            DB::table('metodes')
                ->where('id', '=', $id)
                ->delete();

            $response->success = 1;
            $response->message = 'DATA METODE DENGAN ID:' . $id . ' BERHASIL DIHAPUS';
        } catch (Exception $e) {
            $response->success = 0;
            $response->message = 'GAGAL HAPUS DATA METODE, PESAN KESALAHAN :' . $e->getMessage();
        }
        return json_encode($response);
    }
    #DELETE METODES
#7 METODES

#8 HALAMANS
    #8. GET HALAMANS
    /**
     * @OA\Get(
     *      path="/gethalamans",
     *      operationId="getProjectsList",
     *      tags={"8. Get Halamans"},
     *      summary="Mendapatkan List Data Halaman Yang Terdaftar",
     *      description="Mendapatkan List Data Halaman Yang Terdaftar",
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
    public static function GetHalamans()
    {
        $response       = new usr();
        $get_halamans   = DB::table('halamans')
            ->get();
        $get_halamans                = json_decode(json_encode($get_halamans), true);

        $s_id = '';
        $s_halaman = '';
        $s_url = '';
        $s_simbol = '';
        if (empty($get_halamans)) {
            $response->success = 0;
            $response->message = 'DATA PADA TABEL HALAMAN MASIH BELUM TERISI';
        } else {
            try {
                foreach ($get_halamans as $value) {
                    $s_id       .= $value['id'] . '-';
                    $s_halaman  .= $value['halaman'] . '-';
                    $s_url      .= $value['url'] . '-';
                    $s_simbol   .= $value['simbol'] . ';';
                }
                $response->id       = substr($s_id, 0, -1);
                $response->halaman  = substr($s_halaman, 0, -1);
                $response->url      = substr($s_url, 0, -1);
                $response->simbol   = substr($s_simbol, 0, -1);
                $response->success  = 1;
                $response->message  = 'BERIKUT LIST HALAMAN YANG TERSEDIA';
            } catch (Exception $e) {
                $response->success  = 0;
                $response->message  = 'GAGAL GET DATA HALAMAN, PESAN KESALAHAN : ' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #8. GET HALAMANS

    #INSERT HALAMANS
    public static function InsertHalamans(Request $request)
    {
        $response  = new usr();
        $rules      = [
            'halaman'   => 'required|string|min:1|max:75',
            'url'       => 'required|string|min:1|max:45',
            'simbol'    => 'nullable|string|max:100'
        ];
        $messages   = [
            'halaman.required' => 'HALAMAN WAJIB DIISI',
            'halaman.min'      => 'HALAMAN WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'halaman.max'      => 'HALAMAN WAJIB DIISI DENGAN HURUF MAKSIMAL 45 KARAKTER',
            'url.required'     => 'URL WAJIB DIISI',
            'url.min'          => 'URL WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'url.max'          => 'URL WAJIB DIISI DENGAN HURUF MAKSIMAL 75 KARAKTER',
            'simbol.max'       => 'SIMBOL WAJIB DIISI DENGAN HURUF MAKSIMAL 100 KARAKTER',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $response->success = 0;
            $response->message = 'TERJADI KESALAHAN PENGISIAN DATA, PESAN KESALAHAN :' . $validator->errors()->first();
        } else {
            try {
                DB::table('halamans')
                    ->insert([
                        'halaman'   => $request->halaman,
                        'url'       => $request->url,
                        'simbol'    => $request->simbol
                    ]);
                $response->success = 1;
                $response->message = 'BERHASIL MEMASUKAN DATA HALAMAN BARU';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL INSERT HALAMAN BARU, PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #INSERT HALAMANS

    #UPDATE HALAMANS
    public static function UpdateHalamans(Request $request)
    {
        $response  = new usr();
        $rules      = [
            'id'        => 'required|exists:halamans,id',
            'halaman'   => 'required|string|min:1|max:75',
            'url'       => 'required|string|min:1|max:45',
            'simbol'    => 'nullable|string|max:100'
        ];
        $messages   = [
            'id.required'      => 'ID HALAMAN WAJIB DIISI',
            'id.exists'        => 'ID HALAMAN TIDAK DITEMUKAN',
            'halaman.required' => 'HALAMAN WAJIB DIISI',
            'halaman.min'      => 'HALAMAN WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'halaman.max'      => 'HALAMAN WAJIB DIISI DENGAN HURUF MAKSIMAL 45 KARAKTER',
            'url.required'     => 'URL WAJIB DIISI',
            'url.min'          => 'URL WAJIB DIISI DENGAN HURUF MINIMAL 1 KARAKTER',
            'url.max'          => 'URL WAJIB DIISI DENGAN HURUF MAKSIMAL 75 KARAKTER',
            'simbol.max'       => 'SIMBOL WAJIB DIISI DENGAN HURUF MAKSIMAL 100 KARAKTER',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $response->success = 0;
            $response->message = 'TERJADI KESALAHAN PENGISIAN DATA, PESAN KESALAHAN :' . $validator->errors()->first();
        } else {
            try {
                DB::table('halamans')
                    ->where('id', '=', $request->id)
                    ->update([
                        'halaman'   => $request->halaman,
                        'url'       => $request->url,
                        'simbol'    => $request->simbol
                    ]);
                $response->success = 1;
                $response->message = 'BERHASIL UPDATE DATA HALAMAN';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL UDATE HALAMAN, PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #UPDATE HALAMANS

    #DELETE HALAMANS
    public static function DeleteHalamans($id)
    {
        $response  = new usr();
        $arr_halamans = [
            'id' => $id
        ];
        $rules      = [
            'id'        => 'required|exists:halamans,id'
        ];
        $messages   = [
            'id.required'      => 'ID HALAMAN WAJIB DIISI',
            'id.exists'        => 'ID HALAMAN TIDAK DITEMUKAN'
        ];
        $validator = Validator::make($arr_halamans, $rules, $messages);
        if ($validator->fails()) {
            $response->success = 0;
            $response->message = 'TERJADI KESALAHAN PENGISIAN DATA, PESAN KESALAHAN :' . $validator->errors()->first();
        } else {
            try {
                DB::table('halamans')
                    ->where('id', '=', $arr_halamans['id'])
                    ->delete();
                $response->success = 1;
                $response->message = 'BERHASIL HAPUS DATA HALAMAN';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL UDATE HALAMAN, PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #DELETE HALAMANS
#8 HALAMANS

#9 - 10 DETAIL TRACKING
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
    public static function GetDetailTrackings($data_sampels_id = null)
    {
        $response = new usr();
        $getdetailtrackings = '';

        if (!isset($data_sampels_id)) {
            $response->success = 0;
            $response->message = 'DATA SAMPELS ID TIDAK ADA';
        }
        $s_aktivitas_waktu  = '';
        $s_aktivitas_id     = '';
        $s_aktivitas        = '';
        $s_lab_akuns_id     = '';
        $s_lab_akuns_nama   = '';
        $s_group            = '';

        $getdetailtrackings = DB::table('detail_trackings')
            ->join('aktivitas', 'detail_trackings.aktivitas_id', '=', 'aktivitas.id')
            ->join('lab_akuns', 'detail_trackings.lab_akuns_id', '=', 'lab_akuns.id')
            ->join('group_aktivitas', 'group_aktivitas.id', '=', 'aktivitas.groups_id')
            ->select('detail_trackings.*', 'aktivitas.aktivitas as aktivitas', 'lab_akuns.nama as nama', 'group_aktivitas.group as group')
            ->where('detail_trackings.data_sampels_id', '=', $data_sampels_id)
            ->orderByDesc('detail_trackings.aktivitas_waktu')
            ->get();

        $getdetailtrackings = json_decode(json_encode($getdetailtrackings), true);

        try {
            if (empty($getdetailtrackings)) {
                $response->success = 0;
                $response->message = 'DATA TIDAK DITEMUKAN';
            } else {
                foreach ($getdetailtrackings as $value) {

                    $s_aktivitas_waktu  .= str_replace('-', '/', $value['aktivitas_waktu']) . '-';
                    $s_aktivitas_id     .= $value['aktivitas_id'] . '-';
                    $s_aktivitas        .= $value['aktivitas'] . '-';
                    $s_lab_akuns_id     .= $value['lab_akuns_id'] . '-';
                    $s_lab_akuns_nama   .= $value['nama'] . '-';
                    $s_group            .= $value['group'].'-';
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
                $response->group            = substr($s_group, 0, -1);
                $response->success = 1;
                $response->message = 'TERAKHIR UPDATE ' . $waktu;
            }
        } catch (Exception $e) {
            $response->success = 0;
            $response->message = $e->getMessage();
        }
        return json_encode($response);
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

        if (
            (!isset($request->aktivitas_waktu) and !isset($request->data_sampels_id) and !isset($request->aktivitas_id) and !isset($request->lab_akuns_id)) and
            (!isset($aktivitas_waktu) and !isset($data_sampels_id) and !isset($aktivitas_id) and !isset($lab_akuns_id))
        ) {
            $response->success     = 0;
            $response->message     = 'ADA DATA YANG KOSONG';
        } elseif (
            isset($request->aktivitas_waktu) or isset($request->data_sampels_id) or isset($request->aktivitas_id) or isset($request->lab_akuns_id)
        ) {
            $str_aktivitas_waktu              = $request->aktivitas_waktu;
            $str_data_sampels_id              = $request->data_sampels_id;
            $str_aktivitas_id                 = $request->aktivitas_id;
            $str_lab_akuns_id                 = $request->lab_akuns_id;
        } elseif (isset($aktivitas_waktu) or isset($data_sampels_id) or isset($aktivitas_id) or isset($lab_akuns_id)) {
            $str_aktivitas_waktu              = $aktivitas_waktu;
            $str_data_sampels_id              = $data_sampels_id;
            $str_aktivitas_id                 = $aktivitas_id;
            $str_lab_akuns_id                 = $lab_akuns_id;
        }

        $rules      = [
            'aktivitas_waktu'   => 'required|date|after:yesterday',
            'data_sampels_id'   => 'required|exists:data_sampels,id',
            'aktivitas_id'      => 'required|exists:aktivitas,id',
            'lab_akuns_id'      => 'required|exists:lab_akuns,id'
        ];
        $messages   = [
            'aktivitas_waktu.required'  => 'WAKTU WAJIB ADA',
            'aktivitas_waktu.after'     => 'MINIMAL WAKTU UNTUK MENAMBAHKAN AKTIVITAS BARU ADALAH HARI INI',
            'data_sampels_id.required'  => 'ID KUPA WAJIB ADA',
            'data_sampels_id.exists'    => 'ID KUPA TIDAK DITEMUKAN',
            'aktivitas_id.required'     => 'ID AKTIVITAS WAJIB ADA',
            'aktivitas_id.exists'       => 'ID TIDAK DITEMUKAN',
            'lab_akuns_id.required'     => 'ID LAB AKUNS WAJIB ADA',
            'lab_akuns_id.exists'       => 'ID LAB AKUNS TIDAK DITEMUKAN'
        ];
        $arr_aktivitas = array(
            'aktivitas_waktu'   => $str_aktivitas_waktu,
            'data_sampels_id'   => $str_data_sampels_id,
            'aktivitas_id'      => $str_aktivitas_id,
            'lab_akuns_id'      => $str_lab_akuns_id
        );

        $validator = Validator::make($arr_aktivitas, $rules, $messages);
        if ($validator->fails()) {
            $response->success  = 0;
            $response->message = 'TERJADI KESALAHAN SAAT INGIN MENGUPDATE DATA, PESAN KESALAHAN :' . $validator->errors()->first();
        } else {
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
        }
        return json_encode($response);
    }
    #10. INSERT DETAIL TRACKING
#9 - 10 DETAIL TRACKING

#11 - 14 DATA SAMPELS
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
        $s_catatan_userlabs     = '';
        #PELANGGANS
        $s_pelanggans_id        = '';
        $s_pelanggans_nama    = '';

        #JENIS SAMPELS
        $s_jenis_sampels_id     = ''; $s_jenis_sampel       = ''; $s_ketersediaan_alat = '';
        if(empty($getdatasampelsall))
        {
            $response->success = 0;
            $response->message = 'DATA SAMPEL MASIH KOSONG';
        } else {
            try {
                foreach ($getdatasampelsall as $value) {
                    #DATA SAMPELS
                    $s_id               .= $value['id'] . '-';
                    $s_pakets_id_s      .= $value['pakets_id_s'] . ';';

                    $date       = date_create($value['tanggal_masuk']);
                    $waktu      = date_format($date, 'H:i:s d-m-Y');

                    $s_tanggal_masuk    .= str_replace('-', '/', $waktu).'-'; 
                    $s_tanggal_selesai  .= $value['tanggal_selesai'].'-'; 
                    $s_nomor_surat      .= $value['nomor_surat'].'-'; 
                    $s_jumlah_sampel    .= $value['jumlah_sampel'].'-';
                    $s_catatan_userlabs .= $value['catatan_userlabs'].'-'; 
                    $s_status           .= $value['status'].'-';

                    #PELANGGANS
                    $s_pelanggans_id    .= $value['pelanggans_id'] . '-';
                    $s_pelanggans_nama  .= $value['pelanggan'] . '-';

                    #JENIS SAMPELS
                    $s_jenis_sampels_id .= $value['jenis_sampels_id'].'-'; 
                    $s_jenis_sampel     .= $value['jenis_sampel'].'-';

                    $s_ketersediaan_alat .= $value['ketersedian_alats_id'].'-';
                }

                #DATA SAMPELS
                $response->id               = substr($s_id, 0, -1);
                $response->pakets_id_s      = substr($s_pakets_id_s, 0, -1); 
                $response->tanggal_masuk    = substr($s_tanggal_masuk, 0, -1); 
                $response->tanggal_selesai  = substr($s_tanggal_selesai, 0, -1); 
                $response->nomor_surat      = substr($s_nomor_surat, 0, -1); 
                $response->jumlah_sampel    = substr($s_jumlah_sampel, 0, -1); 
                $response->catatan_userlabs = substr($s_catatan_userlabs, 0, -1); 
                $response->status           = substr($s_status, 0, -1);

                #PELANGGANS
                $response->pelanggans_id    = substr($s_pelanggans_id, 0, -1); 
                $response->pelanggans       = substr($s_pelanggans_nama, 0, -1);

                #JENIS SAMPELS
                $response->jenis_sampels_id     = substr($s_jenis_sampels_id, 0, -1); 
                $response->jenis_sampel         = substr($s_jenis_sampel, 0, -1);
                $response->ketersediaan_alat    = substr($s_ketersediaan_alat, 0, -1);
                $response->success = 1;
                $response->message = 'BERIKUT LIST DATA SAMPELS';

            } catch (Exception $e) {
                $response->success = 0;
                $response->message = $e->getMessage();
            }
        }
        return json_encode($response);
    }

    #12. GET DATA SAMPELS BY ID
    /**
     * @OA\Get(
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

        if (!isset($request->id) and !isset($id)) {
            $response->success = 0;
            $response->message = 'ID KOSONG';
        } elseif (isset($request->id)) {
            $id_s       = $request->id;
        } elseif (isset($id)) {
            $id_s       = $id;
        }

        $response           = new usr();
        $getdatasampelsall  = DB::table('data_sampels')
            ->join('pelanggans', 'data_sampels.pelanggans_id', '=', 'pelanggans.id')
            ->join('jenis_sampels', 'data_sampels.jenis_sampels_id', '=', 'jenis_sampels.id')
            ->select('data_sampels.*', 'pelanggans.nama as pelanggan', 'jenis_sampels.jenis_sampel as jenis_sampel', 'jenis_sampels.lambang_sampel as simbol')
            ->where('data_sampels.id', '=', $id_s)
            ->get();


        $getdatasampelsall      = json_decode(json_encode($getdatasampelsall), true);

        #DATA SAMPELS
        $s_id                   = ''; $s_pakets_id_s        = ''; $s_tanggal_masuk  = ''; $s_tanggal_selesai  = ''; 
        $s_nomor_surat          = ''; $s_jumlah_sampel      = ''; $s_status         = '';
        $s_catatan_userlabs     = '';
        #PELANGGANS
        $s_pelanggans_id        = '';
        $s_pelanggans_nama    = '';

        #JENIS SAMPELS
        $s_jenis_sampels_id     = ''; $s_jenis_sampel       = ''; 
        $s_ketersediaan_alat    = ''; $s_simbol             = '';
        if(empty($getdatasampelsall))
        {
            $response->success = 0;
            $response->message = 'DATA SAMPEL MASIH KOSONG';
        } else {
            try {
                foreach ($getdatasampelsall as $value) {
                    #DATA SAMPELS
                    $s_id               .= $value['id'] . '-';
                    $s_pakets_id_s      .= $value['pakets_id_s'] . ';';

                    $date       = date_create($value['tanggal_masuk']);
                    $waktu      = date_format($date, 'H:i:s d-m-Y');

                    $s_tanggal_masuk    .= str_replace('-', '/', $waktu).'-'; 
                    $s_tanggal_selesai  .= $value['tanggal_selesai'].'-'; 
                    $s_nomor_surat      .= $value['nomor_surat'].'-'; 
                    $s_jumlah_sampel    .= $value['jumlah_sampel'].'-';
                    $s_catatan_userlabs .= $value['catatan_userlabs'].'-'; 
                    $s_status           .= $value['status'].'-';

                    #PELANGGANS
                    $s_pelanggans_id    .= $value['pelanggans_id'] . '-';
                    $s_pelanggans_nama  .= $value['pelanggan'] . '-';

                    #JENIS SAMPELS
                    $s_jenis_sampels_id .= $value['jenis_sampels_id'].'-'; 
                    $s_jenis_sampel     .= $value['jenis_sampel'].'-'; 
                    $s_simbol           .= $value['simbol'].'-';

                    $s_ketersediaan_alat .= $value['ketersedian_alats_id'].'-';
                }

                #DATA SAMPELS
                $response->id               = substr($s_id, 0, -1);
                $response->pakets_id_s      = substr($s_pakets_id_s, 0, -1); 
                $response->tanggal_masuk    = substr($s_tanggal_masuk, 0, -1); 
                $response->tanggal_selesai  = substr($s_tanggal_selesai, 0, -1); 
                $response->nomor_surat      = substr($s_nomor_surat, 0, -1); 
                $response->jumlah_sampel    = substr($s_jumlah_sampel, 0, -1); 
                $response->catatan_userlabs = substr($s_catatan_userlabs, 0, -1); 
                $response->status           = substr($s_status, 0, -1);

                #PELANGGANS
                $response->pelanggans_id    = substr($s_pelanggans_id, 0, -1); 
                $response->pelanggans       = substr($s_pelanggans_nama, 0, -1);

                #JENIS SAMPELS
                $response->jenis_sampels_id     = substr($s_jenis_sampels_id, 0, -1); 
                $response->jenis_sampel         = substr($s_jenis_sampel, 0, -1);
                $response->simbol               = substr($s_simbol, 0, -1);
                $response->ketersediaan_alat    = substr($s_ketersediaan_alat, 0, -1);
                $response->success = 1;
                $response->message = 'BERIKUT LIST DATA SAMPELS';

            } catch (Exception $e) {
                $response->success = 0;
                $response->message = $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #12. GET DATA SAMPELS BY ID

    #13. INSERT DATA SAMPELS
    /**
     * @OA\Post(
     *      path="/insertdatasampels/{jenis_sampels_id}/{pelanggans_id}/{pakets_id_s}/{tanggal_masuk}/{tanggal_selesai}/{nomor_surat}/{jumlah_sampel}/{status}/{batch_size}/{ketersediaan_alat}/{catatan_userlabs}",
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
     *      @OA\Parameter(
     *          name="batch_size",
     *          description="BATCH SIZE",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="ketersediaan_alat",
     *          description="KETERSEDIAN ALAT",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="catatan_userlabs",
     *          description="CATATAN USERLAB",
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

    /**  @todo fix this function **/
    public static function InsertDataSampels(
        Request $request,
        $jenis_sampels_id = null,
        $pelanggans_id = null,
        $pakets_id_s = null,
        $tanggal_masuk = null,
        $tanggal_selesai = null,
        $nomor_surat = null,
        $jumlah_sampel = null,
        $status = null,
        $batch_size = null,
        $ketersediaan_alat = null,
        $catatan_userlabs = null,
        $catatan_pelanggan = null
    ) {
        $m_data_sampels         = new DataSampel();
        $response               = new usr();
        $s_jenis_sampels_id     = '';
        $s_pelanggans_id        = '';
        $s_pakets_id_s          = '';
        $s_tanggal_masuk        = '';
        $s_tanggal_selesai      = '';
        $s_nomor_surat          = '';
        $s_jumlah_sampel        = '';
        $s_status               = '';
        $s_batch_size           = '';
        $s_ketersediaan_alat    = '';
        $s_catatan_userlabs     = '';
        $s_catatan_pelanggan    = '';

        $getpakets          = app('App\Http\Controllers\ApiController')->GetPakets(); 
        $getpakets          = json_decode($getpakets, true);
        $pakets             = '';
        if($getpakets['success'] == 1){
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

        $s_parameters           = '';
        $s_hasil                = '';
        for ($i = 0; $i < count($pakets['id']); $i++) { 
            if(in_array($pakets['id'][$i], $request->pakets_id_s)){
                $s_parameters   .= $pakets['parameters_id_s'][$i].'-';        
            }
        }        
        $s_parameters   = substr($s_parameters, 0, -1);

        for($i = 0; $i < count(explode('-', $s_parameters)); $i++){
            $s_hasil        .= '-;';
        }

        $s_hasil        = substr($s_hasil, 0, -1);

        if (
            (!isset($request->jenis_sampels_id) and !isset($request->pelanggans_id)     and !isset($request->pakets_id_s) and
                !isset($request->tanggal_masuk)     and !isset($request->tanggal_selesai)   and !isset($request->nomor_surat) and
                !isset($request->jumlah_sampel)     and !isset($request->status)            and !isset($request->batch_size) and
                !isset($request->ketersediaan_alat) and !isset($request->catatan_userlabs)  and !isset($request->catatan_pelanggan)) and
            (!isset($jenis_sampels_id)  and !isset($pelanggans_id)      and !isset($pakets_id_s) and
                !isset($tanggal_masuk)      and !isset($tanggal_selesai)    and !isset($nomor_surat) and
                !isset($jumlah_sampel)      and !isset($status)             and !isset($batch_size)  and
                !isset($ketersediaan_alat)  and !isset($catatan_userlabs)   and !isset($catatan_pelanggan))
        ) {
            $response->success = 0;
            $response->message = 'DATA WAJIB DIISI';
        } else if (
            isset($request->jenis_sampels_id)   or isset($request->pelanggans_id)     or isset($request->pakets_id_s) or
            isset($request->tanggal_masuk)      or isset($request->tanggal_selesai)   or isset($request->nomor_surat) or
            isset($request->jumlah_sampel)      or isset($request->status)            or isset($request->batch_size)  or
            isset($request->ketersediaan_alat)  or isset($request->catatan_userlabs)  or isset($request->catatan_pelanggan)
        ) {
            $s_jenis_sampels_id     = $request->jenis_sampels_id;
            $s_pelanggans_id        = $request->pelanggans_id;
            $s_pakets_id_s          = implode('-', $request->pakets_id_s);
            $s_tanggal_masuk        = $request->tanggal_masuk;
            $s_tanggal_selesai      = $request->tanggal_selesai;
            $s_nomor_surat          = $request->nomor_surat;
            $s_jumlah_sampel        = $request->jumlah_sampel;
            $s_status               = $request->status;
            $s_batch_size           = $request->batch_size;
            $s_ketersediaan_alat    = $request->ketersediaan_alat;
            $s_catatan_userlabs     = $request->catatan_userlabs;
            $s_catatan_pelanggan    = $request->catatan_pelanggan;
        } else if (
            isset($jenis_sampels_id)  or isset($pelanggans_id)      or isset($pakets_id_s)      or
            isset($tanggal_masuk)     or isset($tanggal_selesai)    or isset($nomor_surat)      or
            isset($jumlah_sampel)     or isset($status)             or isset($batch_size)       or
            isset($ketersediaan_alat) or isset($catatan_userlabs)   or isset($catatan_pelanggan)
        ) {
            $s_jenis_sampels_id     = $jenis_sampels_id;
            $s_pelanggans_id        = $pelanggans_id;
            $s_pakets_id_s          = $pakets_id_s;
            $s_tanggal_masuk        = $tanggal_masuk;
            $s_tanggal_selesai      = $tanggal_selesai;
            $s_nomor_surat          = $nomor_surat;
            $s_jumlah_sampel        = $jumlah_sampel;
            $s_status               = $status;
            $s_batch_size           = $batch_size;
            $s_ketersediaan_alat    = $ketersediaan_alat;
            $s_catatan_userlabs     = $catatan_userlabs;
            $s_catatan_pelanggan    = $catatan_pelanggan;
        }

        $arr_data_sampels   = array(
            'jenis_sampels_id'  => $s_jenis_sampels_id,
            'pelanggans_id'     => $s_pelanggans_id,
            'pakets_id_s'       => $s_pakets_id_s,
            'tanggal_masuk'     => $s_tanggal_masuk,
            'tanggal_selesai'   => $s_tanggal_selesai,
            'nomor_surat'       => $s_nomor_surat,
            'jumlah_sampel'     => $s_jumlah_sampel,
            'batch_size'        => $s_batch_size,
            'ketersediaan_alat' => $s_ketersediaan_alat,
            'catatan_userlabs'  => $s_catatan_userlabs
        );

        $rules = [
            'jenis_sampels_id'  => 'required|exists:jenis_sampels,id',
            'pelanggans_id'     => 'required|exists:pelanggans,id',
            'pakets_id_s'       => 'required|string|min:1',
            'tanggal_masuk'     => 'required|date|after:yesterday',
            'tanggal_selesai'   => 'required|numeric|min:1',
            'nomor_surat'       => 'required|string|min:1',
            'jumlah_sampel'     => 'required|numeric|min:1',
            'batch_size'        => 'required|string|min:1|max:30',
            'ketersediaan_alat' => 'required|numeric|min:0|max:1',
            'catatan_userlabs'  => 'nullable|string|min:1'
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
            'batch_size.required'           => 'BATCH SIZE WAJIB DIISI',
            'batch_size.min'                => 'MINIMAL PENGISIAN BATCH SIZE ADALAH 1 KARAKTER',
            'batch_size.max'                => 'MAKSIMAL PENGISIAN BATCH SIZE ADALAH 30 KARAKTER',
            'ketersediaan_alat.required'    => 'KETERSEDIAN ALAT WAJIB DIISI',
            'ketersediaan_alat.min'         => 'KETERSEDIAAN ALAT KETERSEDIAN VALUE ADALAH TRUE ATAU FALSE',
            'ketersediaan_alat.max'         => 'KETERSEDIAAN ALAT KETERSEDIAN VALUE ADALAH TRUE ATAU FALSE',
            'catatan_userlabs.min'          => 'MAKSIMAL PENGISIAN CATATAN ADALAH 1 KARAKTER',
        ];

        $validator = Validator::make($arr_data_sampels, $rules, $messages);

        $status_save = 0;
        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first().'1';
        } else {
            $m_data_sampels->jenis_sampels_id       = $s_jenis_sampels_id;
            $m_data_sampels->pelanggans_id          = $s_pelanggans_id;
            $m_data_sampels->pakets_id_s            = $s_pakets_id_s;
            $m_data_sampels->tanggal_masuk          = $s_tanggal_masuk;
            $m_data_sampels->tanggal_selesai        = $s_tanggal_selesai;
            $m_data_sampels->nomor_surat            = $s_nomor_surat;
            $m_data_sampels->jumlah_sampel          = $s_jumlah_sampel;
            $m_data_sampels->status                 = '0';
            $m_data_sampels->ketersedian_alats_id   = $s_ketersediaan_alat;
            $m_data_sampels->catatan_userlabs       = $s_catatan_userlabs;
            $m_data_sampels->catatan_pelanggans     = '';
            
            
            $batch      = explode(',', $s_batch_size);
            $arr_batch  = array();                    
            $val_batch  = 0;
            for ($i = 0; $i < count($batch); $i++) {
                $val_batch += (int)$batch[$i];
                array_push($arr_batch, $val_batch);
            }
            if($val_batch != $s_jumlah_sampel)
            {
                $response->success = 0;
                $response->message = 'JUMLAH BATCH TIDAK SAMA DENGAN JUMLAH SAMPEL'; 
            }
            else{
                try {
                    $m_data_sampels->save();

                    $l_hasil_analisis   = DB::table('hasil_analisas')
                        ->where('jenis_sampels_id', '=', $m_data_sampels->jenis_sampels_id)
                        ->orderByDesc('no_lab')->take(1)->get();

                    $l_hasil_analisis   = json_decode(json_encode($l_hasil_analisis), true);
                    
                    $n                  = 0;

                    $t                  = date('y', strtotime($m_data_sampels->tanggal_masuk));
                    
                    foreach ($l_hasil_analisis as $value) {
                        if (isset($value['no_lab'])) {
                            $n = $value['no_lab'];
                        }               
                        else{
                            $n = 0;
                        }  
                    }
                       
                    
                    
                    try {
                        $no_batch = 0;
                        for ($i = $n; $i < $n + array_sum($batch); $i++) {
                            $n_b = 0;
                            if ($i < $arr_batch[$no_batch] + $n or $i > $arr_batch[$no_batch] and $no_batch > count($arr_batch) - 1) {
                                $n_b = $no_batch + 1;
                            } else {
                                $n_b = $no_batch + 2;
                                $no_batch += 1;
                            }
                            DB::table('hasil_analisas')
                            ->insert([
                                'jenis_sampels_id'  => $m_data_sampels->jenis_sampels_id,
                                'data_sampels_id'   => $m_data_sampels->id,
                                'tahun'             => $t,
                                'no_lab'            => $i + 1,
                                'kode_contoh'       => '',
                                'lab_akuns_id'      => '1',
                                'parameters_id'     => $s_parameters,
                                'hasil'             => $s_hasil,
                                'hasil_verifikasi'  => $s_hasil,
                                'status'            => '0',
                                'log'               => '',
                                'batch'             => $n_b,
                                'verifikasi_hasil'  => 0
                            ]);
                        }
                        $status_save = 1;
                    } catch (Exception $e) {
                        $response->success = 0;
                        $response->message = 'GAGAL MEMASUKAN DATA : ' . $e->getMessage();
                    }
                    if ($status_save == 1) {
                        try {
                            DB::table('detail_trackings')->insert([
                                'aktivitas_waktu'           => date('Y-m-d H:i', strtotime('now')),
                                'data_sampels_id'           => $m_data_sampels->id,
                                'aktivitas_id'              => 1,
                                'lab_akuns_id'              => 1
                            ]);
                            $response->sampels_id       = $m_data_sampels->id;
                            $response->pelanggans_id    = $m_data_sampels->pelanggans_id;
                            $response->success          = 1;
                            $response->message          = 'BERHASIL MEMASUKAN DATA KUPA BARU';
                        } catch (Exception $e) {
                            $response->success = 0;
                            $response->message = 'GAGAL MEMASUKAN DATA : ' . $e->getMessage();
                        }
                    }

                
                } catch (Exception $e) {
                    $response->success = 0;
                    $response->message = $e->getMessage().' SALAH SATU';
                }
            }
            
        }
        return json_encode($response);
    }
    #13. INSERT DATA SAMPELS
#11 - 14 DATA SAMPELS

#15 - 16 HASIL ANALISA
   
    public static function GetQrCode($sampels_id){
        $response               = new usr();

        $gethasilanalisas       = app('App\Http\Controllers\ApiController')->GetHasilAnalisas($sampels_id);
        $gethasilanalisas       = json_decode($gethasilanalisas, true);
        
        $arr_batch              = explode('-', $gethasilanalisas['batch']);
        $arr_tahun              = explode('-', $gethasilanalisas['tahun']);
        $arr_data_sampels_id    = explode('-', $gethasilanalisas['data_sampels_id']);
        $arr_no_lab             = explode('-', $gethasilanalisas['no_lab']);
        $arr_simbol             = explode('-', $gethasilanalisas['simbol']);

        $arr_batch_2            = explode('-', $gethasilanalisas['batch']);
        $arr_batch_2            = array_unique($arr_batch_2);
        $arr_batch_2            = array_values($arr_batch_2);

        $data_sampels_id        = array();      
        $no_lab                 = array();      
        $no_lab2                = array();
        $tahun                  = array();
        $simbol                 = array();

        for ($i = 0; $i < count($arr_batch_2); $i++) 
        { 
            #SAMPEL ID
            $a_id = array();
            $s_id = '';

            #NO LAB
            $a_no_lab = array();
            $s_no_lab = '';

            #TAHUN 
            $a_tahun = array();
            $s_tahun = '';

            #SIMBOL
            $a_simbol = array();
            $s_simbol = '';

            for ($j = 0; $j < count($arr_batch); $j++) 
            { 
                if($arr_batch[$j] == $arr_batch_2[$i]){
                    $s_id       .= $arr_data_sampels_id[$j].'-';
                    $s_no_lab   .= $arr_no_lab[$j].'-';
                    $s_tahun    .= $arr_tahun[$j].'-';
                    $s_simbol   .= $arr_simbol[$j].'-';
                }
            }
            #SAMPEL ID
            $s_id = substr($s_id, 0, -1);
            array_push($a_id, explode('-', $s_id));
            $data_sampels_id[$arr_batch_2[$i]] = $a_id;

            #NO LAB
            $s_no_lab = substr($s_no_lab, 0, -1);        
            array_push($a_no_lab, explode('-', $s_no_lab));
            $no_lab[$arr_batch_2[$i]] = $a_no_lab;
            $no_lab2[$arr_batch_2[$i]] = $a_no_lab;

            #TAHUN
            $s_tahun = substr($s_tahun, 0, -1);        
            array_push($a_tahun, explode('-', $s_tahun));
            $tahun[$arr_batch_2[$i]] = $a_tahun;

            #SIMBOL
            $s_simbol = substr($s_simbol, 0, -1);        
            array_push($a_simbol, explode('-', $s_simbol));
            $simbol[$arr_batch_2[$i]] = $a_simbol;

        }

        $s_sampel_id    = '';
        $s_no_lab_1     = '';
        $s_no_lab_2     = '';
        $s_batch        = '';

        for ($i = 0; $i < count($arr_batch_2); $i++) 
        {
            $s_id   = '';
            $s_nl_1 = ''; 
            $s_nl_2 = ''; 
            for ($j = 0; $j < count($data_sampels_id[$arr_batch_2[$i]]); $j++) { 
                $s_id       = current($data_sampels_id[$arr_batch_2[$i]][$j]);
                $s_nl_1     = current($no_lab[$arr_batch_2[$i]][$j]).':'.end($no_lab[$arr_batch_2[$i]][$j]);
                $s_nl_2     = current($no_lab2[$arr_batch_2[$i]][$j]).current($simbol[$arr_batch_2[$i]][$j]).':'.end($no_lab2[$arr_batch_2[$i]][$j]).end($simbol[$arr_batch_2[$i]][$j]);
            }
            $s_sampel_id .= $s_id.'|';
            $s_no_lab_1  .= $s_nl_1.'|';
            $s_no_lab_2  .= $s_nl_2.'|';
            $s_batch     .= $arr_batch_2[$i].'|';
        }

        $response->sampel_id = substr($s_sampel_id, 0, -1);
        $response->no_lab_1  = substr($s_no_lab_1, 0, -1);
        $response->no_lab_2  = substr($s_no_lab_2, 0, -1);
        $response->batch     = substr($s_batch, 0, -1);

        return json_encode($response);
    }

    public static function GetQrCodeBatch($sampels_id, $b_s){
        $response               = new usr();

        $gethasilanalisas       = app('App\Http\Controllers\ApiController')->GetHasilAnalisas($sampels_id);
        $gethasilanalisas       = json_decode($gethasilanalisas, true);
        
        $arr_batch              = explode('-', $gethasilanalisas['batch']);
        $arr_tahun              = explode('-', $gethasilanalisas['tahun']);
        $arr_data_sampels_id    = explode('-', $gethasilanalisas['data_sampels_id']);
        $arr_no_lab             = explode('-', $gethasilanalisas['no_lab']);
        $arr_simbol             = explode('-', $gethasilanalisas['simbol']);

        $arr_batch_2            = explode('-', $gethasilanalisas['batch']);
        $arr_batch_2            = array_unique($arr_batch_2);
        $arr_batch_2            = array_values($arr_batch_2);

        $data_sampels_id        = array();      
        $no_lab                 = array();      
        $no_lab2                = array();
        $tahun                  = array();
        $simbol                 = array();

        for ($i = 0; $i < count($arr_batch_2); $i++) 
        { 
            if($arr_batch_2[$i] == $b_s){
                #SAMPEL ID
                $a_id = array();
                $s_id = '';

                #NO LAB
                $a_no_lab = array();
                $s_no_lab = '';

                #TAHUN 
                $a_tahun = array();
                $s_tahun = '';

                #SIMBOL
                $a_simbol = array();
                $s_simbol = '';

                for ($j = 0; $j < count($arr_batch); $j++) 
                { 
                    if($arr_batch[$j] == $arr_batch_2[$i]){
                        $s_id       .= $arr_data_sampels_id[$j].'-';
                        $s_no_lab   .= $arr_no_lab[$j].'-';
                        $s_tahun    .= $arr_tahun[$j].'-';
                        $s_simbol   .= $arr_simbol[$j].'-';
                    }
                }
                #SAMPEL ID
                $s_id = substr($s_id, 0, -1);
                array_push($a_id, explode('-', $s_id));
                $data_sampels_id[$arr_batch_2[$i]] = $a_id;

                #NO LAB
                $s_no_lab = substr($s_no_lab, 0, -1);        
                array_push($a_no_lab, explode('-', $s_no_lab));
                $no_lab[$arr_batch_2[$i]] = $a_no_lab;
                $no_lab2[$arr_batch_2[$i]] = $a_no_lab;

                #TAHUN
                $s_tahun = substr($s_tahun, 0, -1);        
                array_push($a_tahun, explode('-', $s_tahun));
                $tahun[$arr_batch_2[$i]] = $a_tahun;

                #SIMBOL
                $s_simbol = substr($s_simbol, 0, -1);        
                array_push($a_simbol, explode('-', $s_simbol));
                $simbol[$arr_batch_2[$i]] = $a_simbol;
            }
        }

        $s_sampel_id    = '';
        $s_no_lab_1     = '';
        $s_no_lab_2     = '';
        $s_batch        = '';

        for ($i = 0; $i < count($arr_batch_2); $i++) 
        {
            $s_id   = '';
            $s_nl_1 = ''; 
            $s_nl_2 = ''; 
            if($arr_batch_2[$i] == $b_s){
                for ($j = 0; $j < count($data_sampels_id[$arr_batch_2[$i]]); $j++) { 
                    $s_id       = current($data_sampels_id[$arr_batch_2[$i]][$j]);
                    $s_nl_1     = current($no_lab[$arr_batch_2[$i]][$j]).'-'.end($no_lab[$arr_batch_2[$i]][$j]);
                    $s_nl_2     = current($tahun[$arr_batch_2[$i]][$j]).current($simbol[$arr_batch_2[$i]][$j]).'.'.current($no_lab2[$arr_batch_2[$i]][$j]).'-'.end($tahun[$arr_batch_2[$i]][$j]).end($simbol[$arr_batch_2[$i]][$j]).'.'.end($no_lab2[$arr_batch_2[$i]][$j]);
                }                
                $s_sampel_id .= $s_id.'|';
                $s_no_lab_1  .= $s_nl_1.'|';
                $s_no_lab_2  .= $s_nl_2.'|';
                $s_batch     .= $arr_batch_2[$i].'|';
            }
        }

        $response->sampel_id = substr($s_sampel_id, 0, -1);
        $response->no_lab_1  = substr($s_no_lab_1, 0, -1);
        $response->no_lab_2  = substr($s_no_lab_2, 0, -1);
        $response->batch     = substr($s_batch, 0, -1);

        return json_encode($response);
    }
    
    public static function QrCodeAll($sampel_id){       
        $qrcode = app('App\Http\Controllers\ApiController')->GetQrCode($sampel_id);
        $qrcode = json_decode($qrcode, true);
        
        $d_s_id         = explode('|', $qrcode['sampel_id']);
        $d_s_no_lab_1   = explode('|', $qrcode['no_lab_1']);
        $d_s_no_lab_2   = explode('|', $qrcode['no_lab_2']);
        $d_s_batch      = explode('|', $qrcode['batch']);
        
        $arr_cr_code    = array();
        $arr_data       = [
            'no_lab'   => explode('|', $qrcode['no_lab_2']),
            'batch'    => explode('|', $qrcode['batch'])
        ];
        
        for ($i = 0; $i < count($d_s_id); $i++) { 
            $s_id       = $d_s_id[$i];
            $s_no_lab_1 = $d_s_no_lab_1[$i];
            $s_no_lab_2 = $d_s_no_lab_2[$i]; 
            $s_batch    = $d_s_batch[$i];

            /* $qrcd   = QrCode::generate($qrcode);
            echo $qrcd.'<br><br>'; */

            $dataqrcode = '{"sid":"'.$s_id.'","nl1":"'.$s_no_lab_1.'","nl2":"'.$s_no_lab_2.'","b":"'.$s_batch.'"}';  
            $qrcodes = urlencode(app('App\Http\Controllers\ApiController')->Enkripsi($dataqrcode));
            $qrcd       = QrCode::generate($qrcodes);
            array_push($arr_cr_code, $qrcd);
        }  
    }

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
                ->join('jenis_sampels', 'jenis_sampels.id', '=', 'hasil_analisas.jenis_sampels_id')
                ->select('hasil_analisas.*', 'jenis_sampels.lambang_sampel as simbol')
                ->where('hasil_analisas.data_sampels_id', '=', $data_sampels_id)
                ->get();

            $hasilanalisa           = json_decode(json_encode($hasilanalisa), true);
            if ($hasilanalisa == []) {
                $response->success  = 0;
                $response->message  = "DATA TIDAK DITEMUKAN";
            } else {
                $str_id                 = '';
                $str_data_sampels_id    = '';
                $str_tahun              = '';
                $str_jenis_samples_id   = '';
                $str_parameters_id_s    = '';
                $str_no_lab             = '';
                $str_kode_contoh        = '';
                $str_hasil              = '';
                $str_hasil_verifikasi   = '';
                $str_status             = '';
                $str_batch              = '';
                $str_log                = '';

                $str_simbol             = '';

                foreach ($hasilanalisa as $keys => $value) {

                    $str_id                 .= $value['id'] . '-';
                    $str_data_sampels_id    .= $value['data_sampels_id'] .'-';
                    $str_tahun              .= $value['tahun'] . '-';
                    $str_jenis_samples_id   .= $value['jenis_sampels_id'] . '-';
                    $str_parameters_id_s    .= $value['parameters_id'] . ';';
                    $str_no_lab             .= $value['no_lab'] . '-';
                    $str_kode_contoh        .= $value['kode_contoh'] . '-';
                    $str_hasil              .= $value['hasil'] . '|';
                    $str_hasil_verifikasi   .= $value['hasil_verifikasi'] . '|';
                    $str_status             .= $value['status'] . '-';
                    $str_batch              .= $value['batch'] . '-';
                    $str_log                .= $value['log'] . '|';

                    $str_simbol             .= $value['simbol'].'-';
                }

                $str_id                 = substr($str_id, 0, -1);
                $str_data_sampels_id    = substr($str_data_sampels_id, 0, -1);
                $str_tahun              = substr($str_tahun, 0, -1);
                $str_jenis_samples_id   = substr($str_jenis_samples_id, 0, -1);
                $str_parameters_id_s    = substr($str_parameters_id_s, 0, -1);
                $str_no_lab             = substr($str_no_lab, 0, -1);
                $str_kode_contoh        = substr($str_kode_contoh, 0, -1);
                $str_hasil              = substr($str_hasil, 0, -1);
                $str_hasil_verifikasi   = substr($str_hasil_verifikasi, 0, -1);
                $str_status             = substr($str_status, 0, -1);
                $str_batch              = substr($str_batch, 0, -1);
                $str_log                = substr($str_log, 0, -1);

                
                $str_simbol             = substr($str_simbol, 0, -1);

                $response->id               = $str_id;
                $response->data_sampels_id  = $str_data_sampels_id;
                $response->tahun            = $str_tahun;
                $response->jenis_sampels_id = $str_jenis_samples_id;
                $response->parameters_id_s  = $str_parameters_id_s;
                $response->no_lab           = $str_no_lab;
                $response->kode_contoh      = $str_kode_contoh;
                $response->hasil            = $str_hasil;
                $response->hasil_verifikasi = $str_hasil_verifikasi;
                $response->status           = $str_status;
                $response->batch            = $str_batch;
                $response->log              = $str_log;

                $response->simbol           = $str_simbol;


                $response->success          = 1;
                $response->message          = 'DATA DITEMUKAN';
            }
        } else {
            $response->success = 0;
            $response->message = "KUPA TIDAK BOLEH KOSONG";
        }
        return json_encode($response);
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
        $response           = new usr();
        $rules              = [
            'id'            => 'required|exists:hasil_analisas,id',
            'hasil'         => 'required'
        ];
        $messages   = [
            'id.required'          => 'HASIL ANALISA ID WAJIB ADA',
            'id.exists'            => 'HASIL ANALISA ID TIDAK DITEMUKAN',
            'hasil.required'       => 'HASIL WAJIB DIISI'
        ];

        if ((!isset($request->id) and !isset($request->hasil)) and
            (!isset($id) and !isset($hasil))
        ) {
            $response->success = 0;
            $response->message = 'DATA TIDAK DAPAT KOSONG';
        } elseif (isset($request->id) and isset($request->hasil)) {
            $str_id         = $request->id;
            $str_hasil      = $request->hasil;
        } elseif (!empty($hasil) and !empty($id)) {
            $str_id         = $id;
            $str_hasil      = $hasil;
        }
        $data       = [
            'id'    => $str_id,
            'hasil' => $str_hasil
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
            $hasil_analisas     = DB::table('hasil_analisas')
                ->where('id', '=', $data['id'])
                ->get();

            $hasil_analisas     = json_decode(json_encode($hasil_analisas), true);

            $ex_hasil   = $hasil_analisas[0]['hasil'];
            $ex_hasil   = explode(";", $ex_hasil);
            $str_hasil  = explode(";", $str_hasil);
            $ex_log     = $hasil_analisas[0]['log'];
            $ex_param   = $hasil_analisas[0]['parameters_id_s'];

            $getparam   = app('App\Http\Controllers\ApiController')->GetParameters();
            $getparam   = json_decode($getparam, true);

            $param      = [
                'id'        => explode('-', $getparam['id']),
                'simbol' => explode('-', $getparam['simbol'])
            ];



            for ($i = 0; $i < count($ex_hasil); $i++) {
                if ($ex_hasil[$i] == "-" and $str_hasil[$i] != "-") {
                    $ex_hasil[$i] = $str_hasil[$i];
                } elseif ($str_hasil[$i] != "-") {
                    $ex_hasil[$i] .= $str_hasil[$i];
                }
                if (in_array($ex_param[$i], $param['id'])) {
                    $ex_log .= date('Y-m-d H:m:s', strtotime('now')) . ': Nilai ' . $param['simbol'][array_search($ex_param[$i], $param['id'])] . ' ditambahkan dengan nilai ' . $str_hasil[$i];
                }
            }

            $str_hasil = '';
            foreach ($ex_hasil as $value) {
                $str_hasil .= $value;
                $str_hasil .= ';';
            }

            $str_hasil = rtrim($str_hasil, ';');

            $data       = [
                'id'    => $str_id,
                'hasil' => $str_hasil,
                'log'   => $ex_log
            ];

            try {
                DB::table('hasil_analisas')
                    ->where('id', '=', $data['id'])
                    ->update([
                        'hasil' => $data['hasil'],
                        'log'   => $data['log']
                    ]);
                $response->success = 1;
                $response->message = 'HASIL ANALISA BERHASIL DITAMBAHKAN';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL MELAKUKAN UPDATE DATA DENGAN ID :' . $data['id'] . ', PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #16. UPDATE HASIL ANALISA
#16 - 17 HASIL ANALISA

#17 - 21 PELANGGANS
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
    public static function GetPelanggans()
    {
        $response       = new usr();
        $pelanggans     = DB::table('pelanggans')
            ->get();
        $pelanggans     = json_decode(json_encode($pelanggans), true);
        $s_id           = ''; $s_email              = ''; $s_password       = ''; 
        $s_nama         = ''; $s_perusahaan         = ''; $s_nomor_telepon  = ''; 
        $s_npwp         = ''; $s_alamat             = ''; $s_tanggal_registrasi = ''; 
        
        if(empty($pelanggans)){
            $response->success = 0;
            $response->message = 'LIST DATA PELANGGAN BELUM TERISI PADA DATABASE';
        } else {
            try {
                foreach ($pelanggans as $value) {
                    $s_id                   .= $value['id'].'-'; 
                    $s_email                .= $value['email'].'-'; 
                    $s_password             .= $value['password'].'-'; 
                    $s_nama                 .= $value['nama'].'-'; 
                    $s_perusahaan           .= $value['perusahaan'].'-'; 
                    $s_nomor_telepon        .= $value['nomor_telepon'].'-'; 
                    $s_alamat               .= $value['alamat'].'-'; 
                    $s_npwp                 .= $value['npwp'].';'; 
                    $tgl                     = strtotime($value['tanggal_registrasi']);
                    $f_tgl                   = date('d/m/Y', $tgl);
                    $s_tanggal_registrasi   .= $f_tgl . '-';
                }
                $response->id                   = substr($s_id, 0, -1);
                $response->email                = substr($s_email, 0, -1);
                $response->password             = substr($s_password, 0, -1);
                $response->nama                 = substr($s_nama, 0, -1);
                $response->perusahaan           = substr($s_perusahaan, 0, -1);    
                $response->nomor_telepon        = substr($s_nomor_telepon, 0, -1);  
                $response->npwp                 = substr($s_npwp, 0, -1);      
                $response->alamat               = substr($s_alamat, 0, -1);
                $response->tanggal_registrasi   = substr($s_tanggal_registrasi, 0, -1);
                $response->success              = 1;
                $response->message              = 'BERIKUT DATA LIST DARI PELANGGAN';
            } catch (Exception $e) {
                $response->success              = 0;
                $response->message              = 'GAGAL MENDAPATKAN LIST DATA PELANGGAN, PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #17. GET PELANGGANS

    #18. INSERT PELANGGANS
    /**
     * @OA\Post(
     *      path="/insertpelanggans/{email}/{password}/{nama}/{perusahaan}/{nomor_telepon}/{npwp}/{alamat}",
     *      operationId="getProjectsList",
     *      tags={"18. Insert Pelanggan"},
     *      summary="Mendaftarkan Data Pelanggan Baru Ke Database Pelanggan",
     *      description="Mendaftarkan Data Pelanggan Baru Ke Database Pelanggan",
     *      @OA\Parameter(
     *          name="email",
     *          description="EMAIL",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="PASSWORD",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="nama",
     *          description="NAMA",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="perusahaan",
     *          description="PERUSAHAAN",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="nomor_telepon",
     *          description="NOMOR TELEPON",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="npwp",
     *          description="NPWP",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="alamat",
     *          description="ALAMAT",
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
    public static function InsertPelanggans(Request $request, $email = null,
    $password = null, $nama = null, $perusahaan = null,
    $nomor_telepon = null, $npwp = null, $alamat = null)
    {
        $response = new usr();
        $s_email                    = ''; $s_password           = ''; $s_nama     = '';
        $s_perusahaan               = ''; $s_nomor_telepon      = ''; $s_npwp     = ''; 
        $s_alamat                   = ''; $s_tanggal_registrasi = '';
        
        if(
            (!isset($request->email) OR !isset($request->password) OR !isset($request->nama) OR !isset($request->perusahaan) OR !isset($request->nomor_telepon)  OR !isset($request->npwp) OR !isset($request->alamat)) 
            AND
            (empty($email) OR empty($password) OR empty($nama) OR empty($perusahaan) OR empty($nomor_telepon) OR empty($npwp) OR empty($alamat))
        ){
            $response->success = 0;
            $response->message = 'DATA PELANGGAN KOSONG';
        }
        elseif(
            isset($request->email) OR isset($request->password) OR isset($request->nama) OR isset($request->perusahaan) OR isset($request->nomor_telepon) OR isset($request->alamat)
        ){
            $s_email                = $request->email; 
            $s_password             = $request->password; 
            $s_nama                 = $request->nama;
            $s_perusahaan           = $request->perusahaan; 
            $s_nomor_telepon        = $request->nomor_telepon; 
            $s_npwp                 = $request->npwp; 
            $s_alamat               = $request->alamat;

            $f_tgl                  = date('Y-m-d');
            $s_tanggal_registrasi   = $f_tgl;
        }
        elseif(
            !empty($email) OR !empty($password) OR !empty($nama) OR !empty($perusahaan) OR !empty($nomor_telepon) OR !empty($npwp) OR !empty($alamat)
        ){
            $s_email                = $email; 
            $s_password             = $password; 
            $s_nama                 = $nama;
            $s_perusahaan           = $perusahaan; 
            $s_nomor_telepon        = $nomor_telepon; 
            $s_npwp                 = $npwp; 
            $s_alamat               = $alamat;

            $f_tgl                  = date('Y-m-d');
            $s_tanggal_registrasi   = $f_tgl;
        }

        $arr_pelanggan = [
            'email'                 => $s_email,
            'password'              => $s_password,
            'nama'                  => $s_nama,
            'perusahaan'            => $s_perusahaan,
            'nomor_telepon'         => $s_nomor_telepon,
            'npwp'                  => $s_npwp,
            'alamat'                => $s_alamat,
            'tanggal_registrasi'    => $s_tanggal_registrasi 
        ];
        /* echo 'email '.$s_email.'<br>';
        echo 'password '.$s_password.'<br>';
        echo 'nama' .$s_nama.'<br>';
        echo 'perusahaan '.$s_perusahaan.'<br>';
        echo 'nomor_telepon '.$s_nomor_telepon.'<br>';
        echo 'npwp '.$s_npwp.'<br>';
        echo 'alamat '.$s_alamat.'<br>';
        echo 'tanggal_registrasi '.$s_tanggal_registrasi; */

        $rules   = [
            'email'                 => 'required|email',
            'password'              => 'required|string|min:8',
            'nama'                  => 'required|string|min:3|max:50',
            'perusahaan'            => 'required|string|min:3|max:30',
            'nomor_telepon'         => 'required|string|min:8|max:12',
            'npwp'                  => 'required|string|min:20|max:25',
            'alamat'                => 'required|string|min:3|max:250',
            'tanggal_registrasi'    => 'required|date|after:yesterday'
        ];
        $messages = [
            'email.required'                => 'EMAIL WAJIB DIISI',
            'email.email'                   => 'PENGISIAN EMAIL HARUS DIISI DENGAN FORMAT YANG BENAR',
            'password.required'             => 'PASSWORD WAJIB DIISI',
            'password.min'                  => 'MINIMAL PENGISIAN PASSWORD ADALAH 8 KARAKTER',
            'nama.required'                 => 'NAMA WAJIB DIISI',
            'nama.min'                      => 'MINIMAL PENGISIAN NAMA ADALAH 3 KARAKTER',
            'nama.max'                      => 'MAXIMAL PENGISISAN NAMA ADALAH 50 KARAKTER',
            'perusahaan.required'           => 'PERUSAHAAN WAJIB DIISI',
            'perusahaan.min'                => 'MINIMAL PENGISIAN PERUSAHAAN ADALAH 3 KARAKTER',
            'perusahaan.max'                => 'MAXIMAL PENGISISAN PERUSAHAAN ADALAH 30 KARAKTER',
            'nomor_telepon.required'        => 'NOMOR TELEPON WAJIB DIISI',
            'nomor_telepon.min'             => 'MINIMAL PENGISIAN NOMOR TELEPON ADALAH 8 KARAKTER',
            'nomor_telepon.max'             => 'MAXSIMAL PENGISIAN NOMOR TELEPON ADALAH 12 KARAKTER',
            'npwp.required'                 => 'NPWP WAJIB DIISI',
            'npwp.min'                      => 'MINIMAL PENGISIAN NPWP ADALAH 20 KARAKTER',
            'npwp.max'                      => 'MINIMAL PENGISIAN NPWP ADALAH 25 KARAKTER',
            'alamat.required'               => 'ALAMAT WAJIB DIISI',
            'alamat.min'                    => 'MINIMAL PENGISIAN ALAMAT ADALAH 3 KARAKTER',
            'alamat.max'                    => 'MINIMAL PENGISIAN ALAMAT ADALAH 250 KARAKTER',
            'tanggal_registrasi.required'   => 'TANGGAL WAJIB DIISI',
            'tanggal_registrasi.after'      => 'MINIMAL PENGISISAN TANGGAL ADALAH HARI INI'
        ];

        $validator = Validator::make($arr_pelanggan, $rules, $messages);

        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
            try {
                DB::table('pelanggans')
                ->insert([
                    'email'                 => $arr_pelanggan['email'],
                    'password'              => $arr_pelanggan['password'],
                    'nama'                  => $arr_pelanggan['nama'],
                    'perusahaan'            => $arr_pelanggan['perusahaan'],
                    'nomor_telepon'         => $arr_pelanggan['nomor_telepon'],
                    'npwp'                  => $arr_pelanggan['npwp'],
                    'kuesioner'             => '',
                    'alamat'                => $arr_pelanggan['alamat'],
                    'tanggal_registrasi'    => $arr_pelanggan['tanggal_registrasi']
                ]);
                $response->success = 1;
                $response->message = 'BERHASIL MELAKUKAN INSERT DATA PELANGGAN';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL MELAKUKAN INSERT DATA, PESAN KESALAHAN : ' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #18. INSERT PELANGGANS

    #19. UPDATE PELANGGANS  
    /**
     * @OA\Post(
     *      path="/updatepelanggans/{id}/{email}/{password}/{nama}/{perusahaan}/{nomor_telepon}/{npwp}/{alamat}",
     *      operationId="getProjectsList",
     *      tags={"19. Update Pelanggan"},
     *      summary="Melakukan Update Data Pelanggan Berdasarkan Parameter Yang Dikirimkan",
     *      description="Melakukan Update Data Pelanggan Berdasarkan Parameter Yang Dikirimkan",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          description="EMAIL",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="PASSWORD",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="nama",
     *          description="NAMA",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="perusahaan",
     *          description="PERUSAHAAN",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="nomor_telepon",
     *          description="NOMOR TELEPON",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="npwp",
     *          description="NPWP",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="alamat",
     *          description="ALAMAT",
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
     * @todo TAMBAH PARAMETER NPWP
     */  
    public static function UpdatePelanggans(Request $request, $id = null, $email = null,
    $password = null, $nama = null, $perusahaan = null,
    $nomor_telepon = null, $npwp = null, $alamat = null){
        $response       = new usr();

        $s_id           = ''; $s_email        = ''; $s_password       = ''; 
        $s_nama         = ''; $s_perusahaan   = ''; $s_nomor_telepon  = ''; 
        $s_npwp         = ''; $s_alamat       = ''; 

        $status = '';

        if(
            (!isset($request->id) OR !isset($request->email) OR !isset($request->password) OR !isset($request->nama) OR !isset($request->perusahaan) OR !isset($request->nomor_telepon) OR !isset($request->npwp) OR !isset($request->alamat)) 
            AND
            (empty($id) OR empty($email) OR empty($password) OR empty($nama) OR empty($perusahaan) OR empty($nomor_telepon) OR empty($npwp) OR empty($alamat))
        ){
            $response->success = 0;
            $response->message = 'DATA UNTUK MELAKUKAN UPDATE DATA PELANGGAN TIDAK BOLEH KOSONG';
        }
        elseif(
            isset($request->id) OR isset($request->email) OR isset($request->password) OR isset($request->nama) OR isset($request->perusahaan) OR isset($request->nomor_telepon) OR isset($request->npwp) OR isset($request->alamat) 
        ){
            $s_id                   = $request->id; 
            $s_email                = $request->email; 
            $s_password             = $request->password; 
            $s_nama                 = $request->nama; 
            $s_perusahaan           = $request->perusahaan; 
            $s_nomor_telepon        = $request->nomor_telepon; 
            $s_npwp                 = $request->npwp;
            $s_alamat               = $request->alamat;
        }
        elseif(
            !empty($id) OR !empty($email) OR !empty($password) OR !empty($nama) OR !empty($perusahaan) OR !empty($nomor_telepon) OR !empty($alamat)
        ){
            $s_id                   = $id; 
            $s_email                = $email; 
            $s_password             = $password; 
            $s_nama                 = $nama; 
            $s_perusahaan           = $perusahaan; 
            $s_nomor_telepon        = $nomor_telepon; 
            $s_npwp                 = $npwp;
            $s_alamat               = $alamat;
        }

        $f_pelanggans   = DB::table('pelanggans')
            ->where('id', '=', $s_id)
            ->first();
        $f_pelanggans   = json_decode(json_encode($f_pelanggans), true);

        if (empty($f_pelanggans)) {
            $response->success = 0;
            $response->message = 'PELANGGAN DENGAN ID : ' . $s_id . ' TIDAK DITEMUKAN';
        }

        $arr_pelanggan  = [
            'id'                    => $s_id,
            'email'                 => $s_email,
            'password'              => $s_password,
            'nama'                  => $s_nama,
            'perusahaan'            => $s_perusahaan,
            'nomor_telepon'         => $s_nomor_telepon,
            'npwp'                  => $s_npwp,
            'alamat'                => $s_alamat
        ];

       /*  echo 'email '.$s_email.'<br>';
        echo 'password '.$s_password.'<br>';
        echo 'nama' .$s_nama.'<br>';
        echo 'perusahaan '.$s_perusahaan.'<br>';
        echo 'nomor_telepon '.$s_nomor_telepon.'<br>';
        echo 'npwp '.$s_npwp.'<br>';
        echo 'alamat '.$s_alamat.'<br>'; */

        $rules   = [
            'id'                    => 'required|exists:pelanggans,id',
            'email'                 => 'required|email',
            'password'              => 'required|string|min:8',
            'nama'                  => 'required|string|min:3|max:50',
            'perusahaan'            => 'required|string|min:3|max:30',
            'nomor_telepon'         => 'required|string|min:8|max:12',
            'npwp'                  => 'required|string|min:20|max:25',
            'alamat'                => 'required|string|min:3|max:250',
        ];
        $messages = [
            'id.required'                   => 'ID PELANGGAN WAJIB DIISI',
            'id.exists'                     => 'ID PELANGGAN TIDAK DITEMUKAN',
            'email.required'                => 'EMAIL WAJIB DIISI',
            'email.email'                   => 'PENGISIAN EMAIL HARUS DIISI DENGAN FORMAT YANG BENAR',
            'password.required'             => 'PASSWORD WAJIB DIISI',
            'password.min'                  => 'MINIMAL PENGISIAN PASSWORD ADALAH 8 KARAKTER',
            'nama.required'                 => 'NAMA WAJIB DIISI',
            'nama.min'                      => 'MINIMAL PENGISIAN NAMA ADALAH 3 KARAKTER',
            'nama.max'                      => 'MAXIMAL PENGISISAN NAMA ADALAH 50 KARAKTER',
            'perusahaan.required'           => 'PERUSAHAAN WAJIB DIISI',
            'perusahaan.min'                => 'MINIMAL PENGISIAN PERUSAHAAN ADALAH 3 KARAKTER',
            'perusahaan.max'                => 'MAXIMAL PENGISISAN PERUSAHAAN ADALAH 30 KARAKTER',
            'nomor_telepon.required'        => 'NOMOR TELEPON WAJIB DIISI',
            'nomor_telepon.min'             => 'MINIMAL PENGISIAN NOMOR TELEPON ADALAH 8 KARAKTER',
            'nomor_telepon.max'             => 'MAXSIMAL PENGISIAN NOMOR TELEPON ADALAH 12 KARAKTER',
            'npwp.required'                 => 'NPWP WAJIB DIISI',
            'npwp.min'                      => 'MINIMAL PENGISIAN NPWP ADALAH 20 KARAKTER',
            'npwp.max'                      => 'MINIMAL PENGISIAN NPWP ADALAH 25 KARAKTER',
            'alamat.required'               => 'ALAMAT WAJIB DIISI',
            'alamat.min'                    => 'MINIMAL PENGISIAN ALAMAT ADALAH 3 KARAKTER',
            'alamat.max'                    => 'MINIMAL PENGISIAN ALAMAT ADALAH 250 KARAKTER',
        ];

        $validator = Validator::make($arr_pelanggan, $rules, $messages);

        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
            try {
                DB::table('pelanggans')
                ->where('id', '=', $arr_pelanggan['id'])
                ->update([
                    'email'                 => $arr_pelanggan['email'],
                    'password'              => $arr_pelanggan['password'],
                    'nama'                  => $arr_pelanggan['nama'],
                    'perusahaan'            => $arr_pelanggan['perusahaan'],
                    'nomor_telepon'         => $arr_pelanggan['nomor_telepon'],
                    'npwp'                  => $arr_pelanggan['npwp'],
                    'alamat'                => $arr_pelanggan['alamat']
                ]);
                $response->success = 1;
                $response->message = 'PERUBAHAN DATA PELANGGAN DENGAN ID: ' . $arr_pelanggan['id'] . ', BERHASIL DILAKUKAN.';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'PERUBAHAN DATA PELANGGAN DENGAN ID: ' . $arr_pelanggan['id'] . ', GAGAL DILAKUKAN. PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #19. UPDATE PELANGGANS

    #20. DELETE PELANGGANS  
    /**
     * @OA\Post(
     *      path="/deletepelanggans/{id}",
     *      operationId="getProjectsList",
     *      tags={"20. Delete Pelanggan"},
     *      summary="Hapus Data Pelanggan Berdasarkan ID Pelanggan Yang Dikirimkan",
     *      description="Hapus Data Pelanggan Berdasarkan ID Pelanggan Yang Dikirimkan",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID",
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
    public static function DeletePelanggans($id)
    {
        $response   = new usr();
        $s_id       = '';
        if (empty($id)) {
            $response->success = 0;
            $response->message = 'TIDAK ADA ID PELANGGAN YANG AKAN DIHAPUS';
        } elseif (!empty($id)) {
            $s_id   = $id;
        }
        $f_pelanggans = DB::table('pelanggans')
            ->where('id', '=', $s_id)
            ->get();
        $f_pelanggans = json_decode(json_encode($f_pelanggans), true);
        if (empty($f_pelanggans)) {
            $response->success = 0;
            $response->message = 'DATA DENGAN ID: ' . $s_id . ' TIDAK DITEMUKAN.';
        } else {
            try {
                DB::table('pelanggans')
                    ->where('id', '=', $s_id)
                    ->delete();

                $response->success = 1;
                $response->message = 'DATA DENGAN ID: ' . $s_id . ' TELAH DIHAPUS.';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL MENGHAPUS PELANGGAN, PESAN KESALAHAN: ' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
    #20. DELETE PELANGGANS

    #21. LOGIN PELANGGANS
    /**
     * @OA\Post(
     *      path="/loginpelanggans/{email}/{password}",
     *      operationId="getProjectsList",
     *      tags={"21. Login Pelanggan"},
     *      summary="Login User Dengan Status Pelangan",
     *      description="Login User Dengan Status Pelangan",
     *      @OA\Parameter(
     *          name="email",
     *          description="EMAIL",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="PASSWORD",
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
    public static function LoginPelanggans(Request $request, $email = null, $password = null)
    {
        $response               = new usr();
        $s_id                   = '';
        $s_email                = '';
        $s_password             = '';
        $s_nama                 = '';
        $s_perusahaan           = '';
        $s_nomor_telepon        = '';
        $s_alamat               = '';
        $s_tanggal_registrasi   = '';
        if (isset($email) and isset($password)) {
            $s_email      = $email;
            $s_password   = $password;
        } elseif (!empty($request->email) and !empty($request->password)) {
            $s_email      = $request->email;
            $s_password   = $request->password;
        } elseif (!isset($email) || !isset($password) || empty($request->email) || empty($request->password)) {
            $response->success = 0;
            $response->message = "Kolom tidak boleh kosong";
        }

        $userPelanggan = DB::table('pelanggans')
                    ->where('email', '=', $s_email)
                    ->first();
        $userPelanggan   = json_decode(json_encode($userPelanggan), true);


        try {
            if ($userPelanggan == []) {
                $response->success      = 0;
                $response->message      = "USER TIDAK DITEMUKAN";
                return json_encode($response);
            } elseif ($userPelanggan['password'] != $s_password) {
                $response->success      = 0;
                $response->message      = "INVALID PASSWORD";
                return json_encode($response);
            }
            else{
                $response->id                   = $userPelanggan['id'];
                $response->email                = $userPelanggan['email'];
                $response->password             = $userPelanggan['password'];
                $response->nama                 = $userPelanggan['nama'];
                $response->perusahaan           = $userPelanggan['perusahaan'];
                $response->nomor_telepon        = $userPelanggan['nomor_telepon'];
                $response->alamat               = $userPelanggan['alamat'];
                $response->tanggal_registrasi   = $userPelanggan['tanggal_registrasi'];

                $response->success              = 1;
                $response->message              = 'BERHASIL MELAKUKAN LOGIN';
                return json_encode($response);
            }
        } catch (Exception $e) {
            $response->success = 0;
            $response->message = 'QUERY LOGIN SALAH, PESAN KESALAHAN (' . $e->getMessage() . ')';
            return json_encode($response);
        }

        return json_encode($response);
    }
    #21. LOGIN PELANGGANS
#17 - 21 PELANGGANS

#22 AKTIVITAS
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
    public static function GetAktivitas()
    {
        $response               = new usr();
        try {
            $aktivitas          = DB::table('aktivitas')
                ->get();
            $aktivitas          = json_decode(json_encode($aktivitas), true);

            $str_aktivitas_id   = '';
            $str_groups_id      = '';
            $str_aktivitas      = '';

            if (count($aktivitas) < 1) {
                $response->success          = 0;
                $response->messages         = 'DATA JENIS SAMPEL TIDAK DITEMUKAN';
            } else if (count($aktivitas) > 0) {
                $str_aktivitas_id           = '';
                $str_aktivitas              = '';
                $str_groups_id              = '';

                foreach ($aktivitas as $value) {
                    $str_aktivitas_id         .= $value['id'] . '-';
                    $str_aktivitas            .= $value['aktivitas'] . '-';
                    $str_groups_id            .= $value['groups_id'] . '-';
                }

                $str_aktivitas_id             = substr($str_aktivitas_id, 0, -1);
                $str_aktivitas                = substr($str_aktivitas, 0, -1);
                $str_groups_id                = substr($str_groups_id, 0, -1);

                $response->id                 = $str_aktivitas_id;
                $response->aktivitas          = $str_aktivitas;
                $response->groups_id          = $str_groups_id;
                $response->success            = 1;
                $response->message            = 'BERIKUT LIST AKTIVITAS';
            }
        } catch (Exception $e) {
            $response->success      = 0;
            $response->message      = $e->getMessage();
        }

        return json_encode($response);
    }
    #22. GET AKTIVITAS

    #INSERT AKTIVITAS
    public static function InsertAktivitas(Request $request)
    {
        $response   = new usr();
        $rules      = [
            'aktivitas'            => 'required|string|min:2|max:75',
            'groups_id'            => 'required|exists:group_aktivitas,id'
        ];
        $messages   = [
            'aktivitas.required'               => 'AKTIVITAS WAJIB DIISI',
            'aktivitas.min'                    => 'AKTIVITAS WAJIB DIISI DENGAN HURUF MINIMAL 2 KARAKTER',
            'aktivitas.max'                    => 'AKTIVITAS WAJIB DIISI DENGAN HURUF MAKSIMAL 75 KARAKTER',
            'groups_id.required'               => 'GROUP WAJIB DIISI',
            'groups_id.exists'                 => 'GROUP TIDAK DITEMUKAN',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
            try {
                DB::table('aktivitas')
                    ->insert([
                        'aktivitas' => $request->aktivitas,
                        'groups_id' => $request->groups_id
                    ]);
                $response->success = 1;
                $response->message = 'AKTIVITAS BARU BERHASIL DITAMBAHKAN';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL MENAMBAHKAN DATA KE TABEL AKTIVITAS, PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }

    #UPDATE AKTIVITAS
    public static function UpdateAktivitas(Request $request)
    {
        $response   = new usr();
        $rules      = [
            'id'         => 'required|exists:aktivitas,id',
            'aktivitas'  => 'required|string|min:2|max:75',
            'groups_id'            => 'required|exists:group_aktivitas,id'
        ];
        $messages   = [
            'id.required'          => 'AKTIVITAS ID WAJIB ADA',
            'id.exists'            => 'AKTIVITAS ID TIDAK DITEMUKAN',
            'aktivitas.required'   => 'AKTIVITAS WAJIB DIISI',
            'aktivitas.min'        => 'AKTIVITAS WAJIB DIISI DENGAN HURUF MINIMAL 2 KARAKTER',
            'aktivitas.max'        => 'AKTIVITAS WAJIB DIISI DENGAN HURUF MAKSIMAL 75 KARAKTER',
            'groups_id.required'               => 'GROUP WAJIB DIISI',
            'groups_id.exists'                 => 'GROUP TIDAK DITEMUKAN',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
            try {
                DB::table('aktivitas')
                    ->where('id', '=', $request->id)
                    ->update([
                        'aktivitas' => $request->aktivitas,
                        'groups_id' => $request->groups_id
                    ]);
                $response->success = 1;
                $response->message = 'AKTIVITAS BERHASIL DIUPDATE';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL MELAKUKAN UPDATE DATA DENGAN ID :' . $request->id . ', PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }

    #DELETE AKTIVITAS
    public static function DeleteAktivitas($id)
    {
        $response   = new usr();
        $rules      = [
            'id'            => 'required|exists:aktivitas,id',
        ];
        $messages   = [
            'id.required'   => 'AKTIVITAS ID WAJIB ADA',
            'id.exists'     => 'AKTIVITAS ID TIDAK DITEMUKAN',
        ];
        $arr_aktivitas = array(
            'id'            => $id
        );

        $validator = Validator::make($arr_aktivitas, $rules, $messages);

        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
            try {
                DB::table('aktivitas')
                    ->where('id', '=', $arr_aktivitas['id'])
                    ->delete();
                $response->success = 1;
                $response->message = 'AKTIVITAS BERHASIL DIHAPUS';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL MELAKUKAN UPDATE DATA DENGAN ID :' . $arr_aktivitas['id'] . ', PESAN KESALAHAN :' . $e->getMessage();
            }
        }
        return json_encode($response);
    }
#22 AKTIVITAS

#23 - 27 LAB AKUN
    #23. GET LAB AKUNS
    /**
     * @OA\Get(
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

        $s_id               = '';
        $s_metodes_id_s   = '';
        $s_akses_levels_id  = '';
        $s_akses_level    = '';
        $s_nama             = '';
        $s_email          = '';
        $s_password         = '';
        $s_jabatan        = '';
        $s_status_akun      = '';

        if (empty($akun_labs)) {
            $response->success = 0;
            $response->message = 'AKUN LAB MASIH KOSONG';
        } else {
            try {
                foreach ($akun_labs as $value) {
                    $s_id               .= $value['id'] . '-';
                    $s_metodes_id_s     .= $value['metodes_id_s'] . ';';
                    $s_akses_levels_id  .= $value['akses_levels_id'] . '-';
                    $s_akses_level      .= $value['akses_level'] . '-';
                    $s_nama             .= $value['nama'] . '-';
                    $s_email            .= $value['email'] . '-';
                    $s_password         .= $value['password'] . '-';
                    $s_jabatan          .= $value['jabatan'] . '-';
                    $s_status_akun      .= $value['status_akun'] . '-';
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
                $response->message          = 'GAGAL GET DATA AKUN LAB, PESAN KESALAHAN: ' . $e->getMessage();
            }
        }
        return json_encode($response);
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
    public static function LoginUserLab(Request $request, $email = null, $password = null)
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

    #26. INSERT LAB AKUNS
    /**
     * @OA\Post(
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
    public static function InsertLabAkuns(
        Request $request,
        $metodes_id_s = null,
        $akses_levels_id = null,
        $nama = null,
        $email = null,
        $password = null,
        $jabatan = null,
        $status_akun = null
    ) {
        $response = new usr();
        $s_metodes_id_s = '';
        $s_akses_levels_id    = '';
        $s_nama         = '';
        $s_email              = '';
        $s_password     = '';
        $s_jabatan            = '';
        $s_status_akun  = '';
        if (
            (!isset($request->metodes_id_s) or !isset($request->akses_levels_id) or
                !isset($request->nama) or !isset($request->email) or
                !isset($request->password) or !isset($request->jabatan) or
                !isset($request->status_akun)) and
            (!isset($metodes_id_s) or !isset($akses_levels_id) or
                !isset($nama) or !isset($email) or
                !isset($password) or  !isset($jabatan) or
                !isset($status_akun))
        ) {
            $response->success = 0;
            $response->message = 'DATA KOSONG';
        } elseif (
            isset($request->metodes_id_s) or isset($request->akses_levels_id) or
            isset($request->nama) or isset($request->email) or
            isset($request->password) or isset($request->jabatan) or
            isset($request->status_akun)
        ) {
            $s_metodes_id_s     = $request->metodes_id_s;
            $s_akses_levels_id  = $request->akses_levels_id;
            $s_nama             = $request->nama;
            $s_email            = $request->email;
            $s_password         = $request->password;
            $s_jabatan          = $request->jabatan;
            $s_status_akun      = $request->status_akun;
        } elseif (
            isset($metodes_id_s) or isset($akses_levels_id) or
            isset($nama) or isset($email) or
            isset($password) or  isset($jabatan) or
            isset($status_akun)
        ) {
            $s_metodes_id_s     = $metodes_id_s;
            $s_akses_levels_id  = $akses_levels_id;
            $s_nama             = $nama;
            $s_email            = $email;
            $s_password         = $password;
            $s_jabatan          = $jabatan;
            $s_status_akun      = $status_akun;
        }
        $str_metodes_id_s = '';
        foreach ($s_metodes_id_s as $value) {
            $str_metodes_id_s .= $value . '-';
        }
        $str_metodes_id_s = substr($str_metodes_id_s, 0, -1);

        $d_lab_akuns    = array(
            'metodes_id_s'      => $str_metodes_id_s,
            'akses_levels_id'   => $s_akses_levels_id,
            'nama'              => $s_nama,
            'email'             => $s_email,
            'password'          => $s_password,
            'jabatan'           => $s_jabatan,
            'status_akun'       => $s_status_akun
        );
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
            'metodes_id_s.min'          => 'METODE ID HARUS DIISI DENGAN HURUF MINIMAL 1 KARAKTER ',
            'akses_levels_id.required'  => 'AKSES LEVEL WAJIB DIISI',
            'akses_levels_id.exists'    => 'ID AKSES LEVEL TIDAK DITEMUKAN',
            'nama.required'             => 'NAMA WAJIB DIISI',
            'nama.min'                  => 'NAMA HARUS DIISI DENGAN HURUF MINIMAL 3 KARAKTER ',
            'nama.max'                  => 'BATAS KARAKTER UNTUK PENGISIAN NAMA ADALAH 50 KARAKTER',
            'email.required'            => 'EMAIL WAJIB DIISI',
            'email.email'               => 'FORMAT PENGISIAN HARUS DIISI DENGAN EMAIL',
            'password.required'         => 'PASSWORD WAJIB DIISI',
            'password.min'              => 'PASSWORD HARUS DIISI DENGAN HURUF MINIMAL 8 KARAKTER ',
            'jabatan.required'          => 'JABATAN WAJIB DIISI',
            'jabatan.min'               => 'JABATAN HARUS DIISI DENGAN HURUF MINIMAL 2 KARAKTER',
            'status_akun.required'      => 'STATUS AKUN WAJIB DIISI',
            'status_akun.min'           => 'STATUS AKUN NONAKTIF ADALAH 0',
            'status_akun.max'           => 'STATUS AKUN YANG AKTIF ADALAH 1'
        ];

        $validator = Validator::make($d_lab_akuns, $rules, $messages);
        $m_lab_akuns    = new LabAkun();

        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
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
        return json_encode($response);
    }
    #26. INSERT LAB AKUNS

    #25. UPDATE LAB AKUNS
    /**
     * @OA\Post(
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
    public static function UpdateLabAkuns(
        Request $request,
        $id = null,
        $metodes_id_s = null,
        $akses_levels_id = null,
        $nama = null,
        $email = null,
        $password = null,
        $jabatan = null,
        $status_akun = null
    ) {
        $response = new usr();
        $s_id               = '';
        $s_metodes_id_s   = '';
        $s_akses_levels_id  = '';
        $s_nama           = '';
        $s_email            = '';
        $s_password       = '';
        $s_jabatan          = '';
        $s_status_akun    = '';
        if (
            (!isset($request->id) or !isset($request->metodes_id_s) or
                !isset($request->akses_levels_id) or !isset($request->nama) or
                !isset($request->email) or !isset($request->password) or
                !isset($request->jabatan) or !isset($request->status_akun)) and
            (!isset($id) or !isset($metodes_id_s) or
                !isset($akses_levels_id) or !isset($nama) or
                !isset($email) or !isset($password) or
                !isset($jabatan) or !isset($status_akun))
        ) {
            $response->success = 0;
            $response->message = 'DATA KOSONG';
        } elseif (
            isset($request->metodes_id_s) or isset($request->akses_levels_id) or
            isset($request->nama) or isset($request->email) or
            isset($request->password) or isset($request->jabatan) or
            isset($request->status_akun)
        ) {
            $s_id               = $request->id;
            $s_metodes_id_s     = $request->metodes_id_s;
            $s_akses_levels_id  = $request->akses_levels_id;
            $s_nama             = $request->nama;
            $s_email            = $request->email;
            $s_password         = $request->password;
            $s_jabatan          = $request->jabatan;
            $s_status_akun      = $request->status_akun;
        } elseif (
            isset($metodes_id_s) or isset($akses_levels_id) or
            isset($nama) or isset($email) or
            isset($password) or  isset($jabatan) or
            isset($status_akun)
        ) {
            $s_id               = $id;
            $s_metodes_id_s     = $metodes_id_s;
            $s_akses_levels_id  = $akses_levels_id;
            $s_nama             = $nama;
            $s_email            = $email;
            $s_password         = $password;
            $s_jabatan          = $jabatan;
            $s_status_akun      = $status_akun;
        }

        $str_metodes_id_s = '';
        foreach ($s_metodes_id_s as $value) {
            $str_metodes_id_s .= $value . '-';
        }
        $str_metodes_id_s = substr($str_metodes_id_s, 0, -1);

        $d_lab_akuns    = array(
            'id'                => $s_id,
            'metodes_id_s'      => $str_metodes_id_s,
            'akses_levels_id'   => $s_akses_levels_id,
            'nama'              => $s_nama,
            'email'             => $s_email,
            'password'          => $s_password,
            'jabatan'           => $s_jabatan,
            'status_akun'       => $s_status_akun
        );
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

        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
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
        return json_encode($response);
    }
    #25. INSERT LAB AKUNS

    #27. DELETE LAB AKUNS
    /**
     * @OA\Post(
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
        if (!isset($request->id) and !isset($id)) {
            $response->succces = 0;
            $response->message = 'ID HARUS DIISI';
        } elseif (isset($request->id)) {
            $s_id       = $request->id;
        } elseif (isset($id)) {
            $s_id       = $id;
        }

        $lab_akuns_by_id  = DB::table('lab_akuns')
            ->where('id', '=', $s_id)
            ->first();

        $lab_akuns_by_id   = json_decode(json_encode($lab_akuns_by_id), true);

        if (!empty($lab_akuns_by_id)) {

            try {
                $del_lab_akuns = LabAkun::find($s_id);
                $del_lab_akuns->delete();

                $response->success = 1;
                $response->message = 'DATA LAB AKUNS DENGAN ID: ' . $s_id . ' BERHASIL DIHAPUS';
            } catch (Exception $e) {
                $response->success = 1;
                $response->message = 'GAGAL HAPUS LAB AKUNS PESAN KESALAHAN: ' . $e->getMessage();
            }
        } else {
            $response->success = 0;
            $response->message = 'DATA TIDAK DITEMUKAN';
        }

        return json_encode($response);
    }
    #27. DELETE LAB AKUNS
#23 - 27 LAB AKUN

#28 - 31 PAKETS
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
        $s_paket    = ''; $s_parameters_id_s    = ''; $s_metodes_id_s = ''; 
        $s_harga    = '';

        $get_pakets     = DB::table('pakets')
            ->join('jenis_sampels', 'pakets.jenis_sampels_id', '=', 'jenis_sampels.id')
            ->select('pakets.*', 'jenis_sampels.jenis_sampel as jenis_sampel')
            ->get();
        $get_pakets   = json_decode(json_encode($get_pakets), true);

        if (empty($get_pakets)) {
            $response->success = 0;
            $response->message = 'BELUM ADA DATA UNTUK TABEL PAKET';
        } else {
            try {
                foreach ($get_pakets as $value) {
                    $s_id                   .= $value['id'].'-'; 
                    $s_jenis_sampels_id     .= $value['jenis_sampels_id'].'-'; 
                    $s_jenis_sampel         .= $value['jenis_sampel'].'-'; 
                    $s_paket                .= $value['paket'].'-'; 
                    $s_parameters_id_s      .= $value['parameters_id_s'].';'; 
                    $s_metodes_id_s         .= $value['metodes_id_s'].';'; 
                    $s_harga                .= $value['harga'].'-';
                }
                $response->id               = substr($s_id, 0, -1);
                $response->jenis_sampels_id = substr($s_jenis_sampels_id, 0, -1);
                $response->jenis_sampel     = substr($s_jenis_sampel, 0, -1);
                $response->paket            = substr($s_paket, 0, -1);
                $response->parameters_id_s  = substr($s_parameters_id_s, 0, -1);
                $response->metodes_id_s     = substr($s_metodes_id_s, 0, -1);
                $response->harga            = substr($s_harga, 0, -1);
                $response->success          = 1;
                $response->message          = 'BERIKUT LIST DATA PAKET';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL GET DATA PAKET, PESAN KESALAHAN :' . $e->getMessage();
            }
        }

        return json_encode($response);
    }
    #28. GET PAKET

    #29. INSERT PAKETS
    /**
     * @OA\Post(
     *      path="/insertpakets/{jenis_sampels_id}/{paket}/{parameters_id_s}/{metodes_id_s}/{harga}",
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
     *          name="metodes_id_s",
     *          description="METODES ID",
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
    public static function InsertPakets(Request $request, $metodes_id_s = null, $jenis_sampels_id = null, $paket = null, $parameters_id_s = null, $harga = null)
    {
        $insert = '';
        $response = new usr();

        $s_jenis_sampels_id = ''; $s_paket = ''; $s_parameters_id_s = ''; $s_metodes_id_s = ''; $s_harga = 0;
        if  ((isset($jenis_sampels_id) AND !isset($paket) AND !isset($parameters_id_s) AND !isset($harga)) AND
             (!isset($request->jenis_sampels_id) AND !isset($request->paket) AND !isset($request->parameters_id_s) AND !isset($request->harga)))   
        {
            $response->success      = 0;
            $response->message      = 'DATA SWAGGER ATAU REQUEST KOSONG';
        }
        if(isset($jenis_sampels_id) or isset($paket) or isset($parameters_id_s) or isset($harga) or isset($metodes_id_s))
        {
            $s_jenis_sampels_id     = $jenis_sampels_id;
            $s_paket                = $paket;
            $s_parameters_id_s      = $parameters_id_s;
            $s_metodes_id_s         = $metodes_id_s;
            $s_harga                = $harga;
        }
        elseif(isset($request->metodes_id_s) or isset($request->jenis_sampels_id)  or isset($request->paket) or isset($request->parameters_id_s)  or isset($request->harga))   
        {
            $s_jenis_sampels_id     = $request->jenis_sampels_id;
            $s_paket                = $request->paket;
            $s_parameters_id_s      = $request->parameters_id_s;
            $s_metodes_id_s         = $request->metodes_id_s;
            $s_harga                = $request->harga;
        }

        $rules = [
            'jenis_sampels_id'  => 'required|exists:jenis_sampels,id',
            'paket'             => 'required|string|min:1',
            'parameters_id_s'   => 'required|string|min:1',
            'metodes_id_s'      => 'required|string|min:1',
            'harga'             => 'required|numeric|min:10000'
        ];

        $messages   = [
            'jenis_sampels_id.required'     => 'Jenis Sampel Wajib Diisi',
            'jenis_sampels_id.exists'       => 'Jenis Sampel Tidak Ditemukan',
            'paket.required'                => 'Paket Wajib Diisi',
            'paket.min'                     => 'Paket Wajib Diisi Minimal 1 Huruf',
            'parameters_id_s.required'      => 'Parameters ID Wajib Diisi',
            'parameters_id_s.min'           => 'Parameters ID Wajib Diisi Minimal 1 Huruf',
            'metodes_id_s.required'         => 'Metode Wajib Diisi',
            'metodes_id_s.min'              => 'Metode Wajib Diisi Minimal 1 Huruf',
            'harga.required'                => 'Harga Wajib Diisi',
            'harga.numeric'                 => 'Harga Wajib Diisi Dengan Angka',
            'harga.min'                     => 'Harga Minimal Adalah 10000'
        ];

        $reqAll = [
            'jenis_sampels_id'  => $s_jenis_sampels_id,
            'paket'             => $s_paket,
            'parameters_id_s'   => $s_parameters_id_s,
            'metodes_id_s'      => $s_metodes_id_s,
            'harga'             => str_replace('.', '',$s_harga)
        ];

        $validator = Validator::make($reqAll, $rules, $messages);

        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
            try {
                DB::table('pakets')
                ->insert([
                    'jenis_sampels_id'  => $reqAll['jenis_sampels_id'],
                    'paket'             => $reqAll['paket'],
                    'parameters_id_s'   => $reqAll['parameters_id_s'],
                    'metodes_id_s'      => $reqAll['metodes_id_s'],
                    'harga'             => $reqAll['harga']
                ]);
                $response->success = 1;
                $response->message = 'BERHASIL MEMASUKAN DATA PAKET BARU';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = $e->getMessage();
            }
        }

        return json_encode($response);
    }
    #29. INSERT PAKETS

    #30. UPDATE PAKETS
    /**
     * @OA\Post(
     *      path="/updatepakets/{id}/{jenis_sampels_id}/{paket}/{parameters_id_s}/{metodes_id_s}/{harga}",
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
     *          name="metodes_id_s",
     *          description="METODE ID",
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
    public static function UpdatePakets(Request $request, $metodes_id_s = null, $id = null, $jenis_sampels_id = null, $paket = null, $parameters_id_s = null, $harga = null)
    {
        $update = '';
        $response = new usr();

        $s_id = 0; $s_jenis_sampels_id = ''; $s_paket = ''; $s_metodes_id_s = ''; $s_parameters_id_s = ''; $s_harga = 0;
        if  (
                (!isset($id) or !isset($jenis_sampels_id) or !isset($paket) or !isset($parameters_id_s) or !isset($harga)) AND
                (!isset($request->id) or !isset($request->jenis_sampels_id) or !isset($request->paket) or !isset($request->parameters_id_s) or !isset($request->harga))
            )   
        {
            $response->message      = 'DATA SWAGGER ATAU REQUEST KOSONG';
        }
        if(isset($metodes_id_s) or isset($id) or isset($jenis_sampels_id) or isset($paket) or isset($parameters_id_s) or isset($harga))
        {
            $s_id                   = $id;
            $s_jenis_sampels_id     = $jenis_sampels_id;
            $s_paket                = $paket;
            $s_parameters_id_s      = $parameters_id_s;
            $s_metodes_id_s         = $metodes_id_s;
            $s_harga                = $harga;
        } elseif (isset($request->id)  or isset($request->jenis_sampels_id)  or isset($request->paket)  or isset($request->parameters_id_s)  or isset($request->harga)) {
            $s_id                   = $request->id;
            $s_jenis_sampels_id     = $request->jenis_sampels_id;
            $s_paket                = $request->paket;
            $s_parameters_id_s      = $request->parameters_id_s;
            $s_metodes_id_s         = $request->metodes_id_s;
            $s_harga                = $request->harga;
        }

        try {
            $update     = DB::table('pakets')
                ->where('id', '=', $s_id)
                ->first();

            $update = json_decode(json_encode($update), true);
        } catch (Exception $e) {
            $response->success = 0;
            $response->message = 'QUERY SELECT BERMASALAH : ' . $e->getMessage();
        }

        if (empty($update)) {
            $response->success = 0;
            $response->message = 'DATA TIDAK DITEMUKAN';
        } else {
            try {
                DB::table('pakets')
                ->where('id', '=', $s_id)
                ->update([
                    'jenis_sampels_id'  => $s_jenis_sampels_id,
                    'paket'             => $s_paket,
                    'parameters_id_s'   => $s_parameters_id_s,
                    'metodes_id_s'      => $s_metodes_id_s,
                    'harga'             => $s_harga
                ]);

                $response->success = 1;
                $response->message = 'BERHASIL MELAKUKAN UPDATE DATA';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = 'GAGAL MELAKUKAN UPDATE : ' . $e->getMessage();
            }
        }

        return json_encode($response);
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
        if (!isset($id)) {
            $response->success = 0;
            $response->message = 'PARAMETER ID TIDAK DITEMUKAN';
        } else {
            try {
                $delete = DB::table('pakets')
                    ->where('id', '=', $id)
                    ->first();

                $delete = json_decode(json_encode($delete), true);

                if (empty($delete)) {
                    $response->success = 0;
                    $response->message = 'DATA TIDAK DITEMUKAN';
                } else {
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
        return json_encode($response);
    }
    #31. DELETE PAKETS
#28 - 31 PAKETS


#32 - 36 GROUP AKTIFITAS
    public static function GetGroupAktivitas()
    {
        $response           = new usr();
        $getgroupaktivitas  = DB::table('group_aktivitas')->get();
        $getgroupaktivitas  = json_decode(json_encode($getgroupaktivitas), true);
        $str_id             = '';
        $str_group          = '';
        if (empty($getgroupaktivitas)) {
            $response->success = 0;
            $response->message = 'DATA BELUM TERISI';
        } else {
            try {
                foreach ($getgroupaktivitas as $value) {
                    $str_id             .= $value['id'] . '-';
                    $str_group          .= $value['group'] . '-';
                }
                $str_id         = substr($str_id, 0, -1);
                $str_group      = substr($str_group, 0, -1);

                $response->id       = $str_id;
                $response->group    = $str_group;
                
                $response->success  = 1;
                $response->message  = 'BERIKUT LIST DATA GROUP AKTIVITAS';
            } catch (Exception $e) {
                $response->success  = 0;
                $response->message  = 'KESALAHAN SAAT MENGAMBAIL DATA :' . $e->getMessage();
            }
        }

        return json_encode($response);
    }

    public static function InsertGroupAktivitas(Request $request, $group = null)
    {
        $response   = new usr();
        $str_group  = '';
        if (!isset($request->group) and !isset($group)) {
            $response->success = 0;
            $response->message = 'DATA TIDAK DAPAT KOSONG';
        } elseif (isset($request->group)) {
            $str_group         = $request->group;
        } elseif (!empty($group)) {
            $str_group         = $group;
        }
        $data       = [
            'group' => $str_group
        ];

        $rules      = [
            'group' => 'required|string|min:3|max:45'
        ];
        $messages   = [
            'group.required'    => 'GROUP AKTIVITAS TIDAK BOLEH KOSONG',
            'group.min'         => 'GROUP AKTIVITAS HARUS DIISI DENGAN KARAKTER MINIMAL 3 HURUF',
            'group.max'         => 'GROUP AKTIVITAS HARUS DIISI DENGAN KARAKTER MAKSIMAL 45 HURUF'
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
            try {
                DB::table('group_aktivitas')
                    ->insert([
                        'group' => $data['group']
                    ]);
                $response->success = 1;
                $response->message = 'BERHASIL MENAMBAHKAN GROUP BARU';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = $e->getMessage();
            }
        }

        return json_encode($response);
    }

    public static function UpdateGroupAktivitas(Request $request, $id = null, $group = null)
    {
        $response   = new usr();
        $str_id     = '';
        $str_group  = '';
        if ((!isset($request->id) and !isset($request->group)) and
            (!isset($id) and !isset($group))
        ) {
            $response->success = 0;
            $response->message = 'DATA TIDAK DAPAT KOSONG';
        } elseif (isset($request->id) and isset($request->group)) {
            $str_id         = $request->id;
            $str_group      = $request->group;
        } elseif (!empty($group) and !empty($id)) {
            $str_id         = $id;
            $str_group      = $group;
        }
        $data       = [
            'id'    => $str_id,
            'group' => $str_group
        ];

        $rules      = [
            'id'    => 'required|exists:group_aktivitas,id',
            'group' => 'required|string|min:3|max:45'
        ];
        $messages   = [
            'id.required'       => 'ID GROUP WAJIB ADA',
            'id.exitst'         => 'ID GROUP TIDAK DITEMUKAN',
            'group.required'    => 'GROUP AKTIVITAS TIDAK BOLEH KOSONG',
            'group.min'         => 'GROUP AKTIVITAS HARUS DIISI DENGAN KARAKTER MINIMAL 3 HURUF',
            'group.max'         => 'GROUP AKTIVITAS HARUS DIISI DENGAN KARAKTER MAKSIMAL 45 HURUF'
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        } else {
            try {
                DB::table('group_aktivitas')
                    ->where('id', '=', $data['id'])
                    ->update([
                        'group' => $data['group']
                    ]);
                $response->success = 1;
                $response->message = 'BERHASIL UPDATE DATA GRUP';
            } catch (Exception $e) {
                $response->success = 0;
                $response->message = $e->getMessage();
            }
        }

        return json_encode($response);
    }

    public static function DeleteGroupAktivitas($id = null)
    {
        $response   = new usr();
        $data       = [
            'id'    => $id
        ];
        $rules      = [
            'id'    => 'required|exists:group_aktivitas,id'
        ];
        $messages   = [
            'id.required'   => 'ID GRUP AKTIVITAS WAJIB ADA',
            'id.exists'     => 'ID GRUP AKTIVITAS TIDAK DITEMUKAN DIDATABASE'
        ];
        $validator  = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $response->success = 0;
            $response->message = $validator->errors()->first();
        }
        else{                
            try {
                DB::table('group_aktivitas')
                ->delete();
                
                $response->success = 1;
                $response->message = 'DATA BERHASIL DIHAPUS';
            } catch (Exception $e) {
                //throw $th;
            }
        }

        return json_encode($response);
    }
#32 - 36 GROUP AKTIFITAS

#
    public static function Enkripsi($sampels_id){        
        
        error_reporting(0);
        $data           = $sampels_id;
        $cipher         = "aes-128-cbc"; 
        $encryption_key = '%smartlabcbi2021'; 

        $decrypted_data = openssl_encrypt($data, 
                                          $cipher, 
                                          $encryption_key, 
                                          0, 
                                          ''); 
        return $decrypted_data;
    }

    public static function CekResi($user_id, $sampels_id)
    {
        $response   = new usr();

        $decrypted_data = app('App\Http\Controllers\ApiController')->Enkripsi($sampels_id);   
    
        $cekuser    = DB::table('data_sampels')
        ->where('data_sampels.pelanggans_id', '=', $user_id)
        ->where('data_sampels.id', '=', $decrypted_data)
        ->get();
        $cekuser  = json_decode(json_encode($cekuser), true);

        if(!empty($cekuser)){
            $gettrackings   = app('App\Http\Controllers\ApiController')->GetDetailTrackings($decrypted_data);        
            $gettrackings   = json_decode($gettrackings, true);

            $response->aktivitas_waktu = $gettrackings['aktivitas_waktu'];
            $response->lab_akuns_nama = $gettrackings['lab_akuns_nama'];
            $response->group = $gettrackings['group'];
            $response->success  = 1;
            $response->message  = 'DATA DITEMUKAN';
        }
        else{
            $response->success = 0;
            $response->message = 'DATA DENGAN RESI YANG ANDA MINTA TIDAK DAPAT DIAKSES';
        }
        return json_encode($response);
    }
}
