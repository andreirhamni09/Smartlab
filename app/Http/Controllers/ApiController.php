<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Exception;

class usr{}
class ApiController extends Controller
{
    /**
     * @OA\Post(
     *      path="/loginuserlab/{email}/{password}",
     *      operationId="getProjectById",
     *      tags={"Projects"},
     *      summary="Get project information",
     *      description="Returns project data",
     *      @OA\Parameter(
     *          name="email",
     *          description="email user",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              format="int64",
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
    #POST LOGIN
    function LoginUserLab(Request $request, $email=null, $password=null)
    {
        $response     = new usr();
        $s_email      = '';
        $s_password   = '';

        if(isset($email) AND isset($password))
        {
            $s_email      = $email;
            $s_password   = $password;
        }
        elseif(!isset($email) || !isset($password))
        {
            if(empty($request->email) || empty($request->password))
            {
                $response->success = 0;
                $response->message = "Kolom tidak boleh kosong"; 
                die(json_encode($response));
            }
            elseif(!empty($request->email) || !empty($request->password))
            {
                $s_email      = $request->email;
                $s_password   = $request->password;
            }
        }
        try {
            $userLabLogin   = DB::table('lab_akuns')
            ->where('email', $s_email)
            ->where('password', $s_password)
            ->get();
            
            $userLabLogin   = json_decode(json_encode($userLabLogin), true);

            if(count($userLabLogin) <= 0)
            {
                $response->success      = 0;
                $response->message      = "DATA TIDAK DITEMUKAN";
            }
            foreach ($userLabLogin as $key => $value) {
                $response->id           = $value['id'];
                $response->nama         = $value['nama'];
                $response->id_akses     = $value['id_akses'];
                $response->jabatan      = $value['jabatan'];
                $response->email        = $value['email'];
                $response->password     = $value['password'];
                $response->success      = 1;
            } 
            
        } catch (Exception $e) {
            $response->success      = 0;
            $response->message      = $e->getMessage();
        }
        die(json_encode($response));
    }
    #POST LOGIN

    /**
     * @OA\Get(
     *      path="/getaktivitas",
     *      operationId="getProjectsList",
     *      tags={"Projects"},
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
    #GET AKTIVITAS
    function GetAktivitas()
    {
        $response           = new usr();
        $getaktivitas       = DB::table('tabel_aktivitas')
        ->get();
        $getaktivitas       = json_decode(json_encode($getaktivitas), true);
        $str_aktivitas_id   = '';
        $str_aktivitas      = '';
        if(count($getaktivitas) == 0)
        {
            $response->success = 0;
            $response->message = 'DATA AKTIVITAS TIDAK DITEMUKAN';
        }
        else{
            foreach ($getaktivitas as $key => $value) {
                $str_aktivitas_id   .= $value['id'].'-';
                $str_aktivitas      .= $value['aktivitas'].'-';
            }
            $str_aktivitas_id   = substr($str_aktivitas_id, 0, -1);
            $str_aktivitas      = substr($str_aktivitas, 0, -1);
    
            $response->id           = $str_aktivitas_id;
            $response->aktivitas    = $str_aktivitas; 
            $response->success      = 1; 
        }
        die(json_encode($response));
    }
    #GET AKTIVITAS
    
    #POST TRACKING
    /**
     * @OA\Post(
     *      path="/updateproses/{aktivitas_waktu}/{kupa_id}/{aktivitas_id}/{petugas_id}",
     *      operationId="getProjectById",
     *      tags={"Projects"},
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
     *          name="kupa_id",
     *          description="Kupa ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="aktivitas_id",
     *          description="Tracking ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="petugas_id",
     *          description="Tracking ID",
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
    
    function UpdateProses(Request $request, $aktivitas_waktu = null, $kupa_id = null, $aktivitas_id = null, $petugas_id = null)
    {
        $response               = new usr();
        $s_aktivitas_waktu      = '';
        $s_kupa_id              = '';
        $s_aktivitas_id         = '';
        $s_petugas_id           = '';

        if(!isset($aktivitas_waktu) OR !isset($kupa_id) OR !isset($aktivitas_id) OR !isset($petugas_id))
        {
            if(empty($request->aktivitas_waktu) AND empty($request->kupa_id) AND empty($request->aktivitas_id) AND empty($request->petugas_id))
            {
                $response->success     = 0; 
                $response->message     = 'ADA DATA YANG KOSONG';  
            }
            else if(!empty($request->aktivitas_waktu) AND !empty($request->kupa_id) AND !empty($request->aktivitas_id) AND !empty($request->petugas_id))
            {
                $s_aktivitas_waktu      = $request->aktivitas_waktu;
                $s_kupa_id              = $request->kupa_id;
                $s_aktivitas_id         = $request->aktivitas_id;
                $s_petugas_id           = $request->petugas_id;
            }
        }
        elseif (isset($aktivitas_waktu) AND isset($kupa_id) AND isset($aktivitas_id) AND isset($petugas_id)) {
            $s_aktivitas_waktu      = $aktivitas_waktu;
            $s_kupa_id              = $kupa_id;
            $s_aktivitas_id         = $aktivitas_id;
            $s_petugas_id           = $petugas_id;
        }


        try {
            DB::table('detail_trackings')->insert([
                'aktivitas_waktu'   => $s_aktivitas_waktu,
                'kupa_id'           => $s_kupa_id,
                'aktivitas_id'      => $s_aktivitas_id,
                'petugas_id'        => $s_petugas_id
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

    /**
     * @OA\Get(
     *      path="/getjenissampel",
     *      operationId="getProjectsList",
     *      tags={"Projects"},
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

    #GET JENIS SAMPEL
    function GetJenisSampel()
    {
        $response                   = new usr();
        $jenisSampel                = DB::table('jenis_sampels')
        ->get();
        $jenisSampel                = json_decode(json_encode($jenisSampel), true);
        
        if(count($jenisSampel) == 0)
        {
            $response->success          = 0;
            $response->messages         = 'DATA JENIS SAMPEL TIDAK DITEMUKAN';
        }
        else if(count($jenisSampel) !== 0)
        {
            $str_idJenisSampel          = '';
            $str_jenisSampel            = '';
            $str_lambangSampel          = '';
            $j_jenisSampel              = count($jenisSampel) - 1;
            for ($i = 0; $i < count($jenisSampel); $i++) {
                if($i < $j_jenisSampel)
                {
                    $str_idJenisSampel      .= $jenisSampel[$i]['id'].'-'; 
                    $str_jenisSampel        .= $jenisSampel[$i]['jenis_sampel'].'-'; 
                    $str_lambangSampel      .= $jenisSampel[$i]['lambang_sampel'].'-'; 
                } 
                elseif ($i >= $j_jenisSampel) {
                    $str_idJenisSampel      .= $jenisSampel[$i]['id']; 
                    $str_jenisSampel        .= $jenisSampel[$i]['jenis_sampel']; 
                    $str_lambangSampel      .= $jenisSampel[$i]['lambang_sampel'];
                }
            }
            $response->id               = $str_idJenisSampel;
            $response->jenis_sampel     = $str_jenisSampel;
            $response->lambang_sampel   = $str_lambangSampel;
            $response->success          = 1;
        }
        die(json_encode($response));
    }
    #GET JENIS SAMPEL

    #GET PARAMETER
    /**
     * @OA\Get(
     *      path="/getparameter",
     *      operationId="getProjectsList",
     *      tags={"Projects"},
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
    function GetParameter()
    {
        $response                   = new usr();
        $parameter                  = DB::table('parameters')
        ->join('jenis_sampels', 'parameters.id_jenis_sampel', '=', 'jenis_sampels.id')
        ->select('parameters.*', 'jenis_sampels.jenis_sampel as jenis_sampel', 'jenis_sampels.lambang_sampel as lambang')
        ->get();
        $parameter                  = json_decode(json_encode($parameter), true);
        if(count($parameter) == 0)
        {
            $response->success          = 0;
            $response->messages         = 'DATA PARAMETER TIDAK DITEMUKAN';
        }
        elseif (count($parameter) !== 0) {
            $str_idParameter            = '';
            $str_parameter              = '';
            $str_harga                  = '';
            $str_idJenisSampel          = '';
            $str_jenisSampel            = '';
            $str_lambang                = '';

            $j_parameter                = count($parameter) - 1;
            for ($i = 0; $i < count($parameter); $i++) { 
                if($i == $j_parameter){
                    $str_idParameter            .= $parameter[$i]['id'];
                    $str_parameter              .= $parameter[$i]['parameter'];
                    $str_harga                  .= $parameter[$i]['harga'];
                    $str_idJenisSampel          .= $parameter[$i]['id_jenis_sampel'];
                    $str_jenisSampel            .= $parameter[$i]['jenis_sampel'];
                    $str_lambang                .= $parameter[$i]['lambang'];
                }
                elseif ($i !== $j_parameter) {
                    $str_idParameter            .= $parameter[$i]['id'].'-';
                    $str_parameter              .= $parameter[$i]['parameter'].'-';
                    $str_harga                  .= $parameter[$i]['harga'].'-';
                    $str_idJenisSampel          .= $parameter[$i]['id_jenis_sampel'].'-';
                    $str_jenisSampel            .= $parameter[$i]['jenis_sampel'].'-';
                    $str_lambang                .= $parameter[$i]['lambang'].'-';
                }
            }
            $response->id               = $str_idParameter;
            $response->parameter        = $str_parameter;
            $response->harga            = $str_harga;
            $response->id_jenis_sampel  = $str_idJenisSampel;
            $response->jenis_sampel     = $str_jenisSampel;
            $response->lambang          = $str_lambang;
            $response->success          = 1;
        }
        die(json_encode($response));
    }
    #GET PARAMETER


    #GET HASILANALISA
    /**
     * @OA\Get(
     *      path="/gethasilanalisa/{kupa_id}",
     *      operationId="getProjectsList",
     *      tags={"Projects"},
     *      summary="Mendapatkan List Aktivitas",
     *      description="Mendapatkan List Parameter",
     *      @OA\Parameter(
     *          name="kupa_id",
     *          description="ID Kupa",
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
    function GetHasilAnalisa($kupa_id=null)
    {
        $response   = new usr();
        if(isset($kupa_id))
        {
            $hasilanalisa    = DB::table('hasil_analisas')
            ->where('id_kupa', $kupa_id)
            ->get();

            $hasilanalisa                  = json_decode(json_encode($hasilanalisa), true);
            if(count($hasilanalisa) <= 0){
                $response->success  = 0;
                $response->message  = "DATA TIDAK DITEMUKAN";
            }
            else{
                $s_id                 = '';
                $s_id_kupa            = '';
                $s_tahun              = '';
                $s_id_jenis_sampel    = '';
                $s_no_lab             = '';
                $s_kode_contoh        = '';
                $s_id_petugas         = '';
                $s_N                  = '';
                $s_P                  = '';
                $s_K                  = '';
                $s_Mg                 = '';
                $s_Ca                 = '';
                $s_B                  = '';
                $s_Cu                 = '';
                $s_Zn                 = '';
                $s_Fe                 = '';
                $s_Mn                 = '';
                $s_status             = '';
                $s_retry              = '';

                $j_hasilanalisa        = count($hasilanalisa) - 1;
                for ($i = 0; $i < count($hasilanalisa); $i++) { 
                    if($i != $j_hasilanalisa)
                    {
                        #ID
                        if($hasilanalisa[$i]['id'] != '')
                        {
                            $s_id .= $hasilanalisa[$i]['id'].'-';
                        }
                        else{
                            $s_id .= '-';
                        }
                        #ID

                        #ID KUPA
                        if($hasilanalisa[$i]['id_kupa'] != '')
                        {
                            $s_id_kupa .= $hasilanalisa[$i]['id_kupa'].'-';
                        }
                        else{
                            $s_id_kupa .= '-';
                        }
                        #ID KUPA

                        #TAHUN
                        if($hasilanalisa[$i]['tahun'] != '')
                        {
                            $s_tahun .= $hasilanalisa[$i]['tahun'].'-';
                        }
                        else{
                            $s_tahun .= '-';
                        }
                        #TAHUN

                        #ID JENIS SAMPEL
                        if($hasilanalisa[$i]['id_jenis_sampel'] != '')
                        {
                            $s_id_jenis_sampel .= $hasilanalisa[$i]['id_jenis_sampel'].'-';
                        }
                        else{
                            $s_id_jenis_sampel .= '-';
                        }
                        #ID JENIS SAMPEL

                        #NO LAB
                        if($hasilanalisa[$i]['no_lab'] != '')
                        {
                            $s_no_lab .= $hasilanalisa[$i]['no_lab'].'-';
                        }
                        else{
                            $s_no_lab .= '-';
                        }
                        #NO LAB

                        #KODE CONTOH
                        if($hasilanalisa[$i]['kode_contoh'] != '')
                        {
                            $s_kode_contoh .= $hasilanalisa[$i]['kode_contoh'].'-';
                        }
                        else{
                            $s_kode_contoh .= '-';
                        }
                        #KODE CONTOH
                        
                        #ID PETUGAS
                        if($hasilanalisa[$i]['id_petugas'] != '')
                        {
                            $s_id_petugas .= $hasilanalisa[$i]['id_petugas'].';';
                        }
                        else{
                            $s_id_petugas .= ';';
                        }
                        #ID PETUGAS

                        #N
                        if($hasilanalisa[$i]['N'] != '')
                        {
                            $s_N .= $hasilanalisa[$i]['N'].'-';
                        }
                        else{
                            $s_N .= '-';
                        }
                        #N

                        #P
                        if($hasilanalisa[$i]['P'] != '')
                        {
                            $s_P .= $hasilanalisa[$i]['P'].'-';
                        }
                        else{
                            $s_P .= '-';
                        }
                        #P

                        #K
                        if($hasilanalisa[$i]['K'] != '')
                        {
                            $s_K .= $hasilanalisa[$i]['K'].'-';
                        }
                        else{
                            $s_K .= '-';
                        }
                        #K

                        #Mg
                        if($hasilanalisa[$i]['Mg'] != '')
                        {
                            $s_Mg .= $hasilanalisa[$i]['Mg'].'-';
                        }
                        else{
                            $s_Mg .= '-';
                        }
                        #Mg

                        #Ca
                        if($hasilanalisa[$i]['Ca'] != '')
                        {
                            $s_Ca .= $hasilanalisa[$i]['Ca'].'-';
                        }
                        else{
                            $s_Ca .= '-';
                        }
                        #Ca

                        #B
                        if($hasilanalisa[$i]['B'] != '')
                        {
                            $s_B .= $hasilanalisa[$i]['B'].'-';
                        }
                        else{
                            $s_B .= '-';
                        }
                        #B

                        #Cu
                        if($hasilanalisa[$i]['Cu'] != '')
                        {
                            $s_Cu .= $hasilanalisa[$i]['Cu'].'-';
                        }
                        else{
                            $s_Cu .= '-';
                        }
                        #Cu

                        #Zn
                        if($hasilanalisa[$i]['Zn'] != '')
                        {
                            $s_Zn .= $hasilanalisa[$i]['Zn'].'-';
                        }
                        else{
                            $s_Zn .= '-';
                        }
                        #Zn

                        #Fe
                        if($hasilanalisa[$i]['Fe'] != '')
                        {
                            $s_Fe .= $hasilanalisa[$i]['Fe'].'-';
                        }
                        else{
                            $s_Fe .= '-';
                        }
                        #Fe
                        
                        #Mn
                        if($hasilanalisa[$i]['Mn'] != '')
                        {
                            $s_Mn .= $hasilanalisa[$i]['Mn'].'-';
                        }
                        else{
                            $s_Mn .= '-';
                        }
                        #Mn

                        #STATUS
                        if($hasilanalisa[$i]['status'] != '')
                        {
                            $s_status .= $hasilanalisa[$i]['status'].'-';
                        }
                        else{
                            $s_status .= '-';
                        }
                        #STATUS
                        
                        #RETRY
                        if($hasilanalisa[$i]['retry'] != '')
                        {
                            $s_retry .= $hasilanalisa[$i]['retry'].'-';
                        }
                        else{
                            $s_retry .= '-';
                        }
                        #RETRY
                    }
                    else{
                        #ID
                        if($hasilanalisa[$i]['id'] != '')
                        {
                            $s_id .= $hasilanalisa[$i]['id'];
                        }
                        else{
                            $s_id .= '';
                        }
                        #ID
                        
                        #ID KUPA
                        if($hasilanalisa[$i]['id_kupa'] != '')
                        {
                            $s_id_kupa .= $hasilanalisa[$i]['id_kupa'];
                        }
                        else{
                            $s_id_kupa .= '';
                        }
                        #ID KUPA

                        #TAHUN
                        if($hasilanalisa[$i]['tahun'] != '')
                        {
                            $s_tahun .= $hasilanalisa[$i]['tahun'];
                        }
                        else{
                            $s_tahun .= '';
                        }
                        #TAHUN

                        #ID JENIS SAMPEL
                        if($hasilanalisa[$i]['id_jenis_sampel'] != '')
                        {
                            $s_id_jenis_sampel .= $hasilanalisa[$i]['id_jenis_sampel'];
                        }
                        else{
                            $s_id_jenis_sampel .= '';
                        }
                        #ID JENIS SAMPEL

                        #NO LAB
                        if($hasilanalisa[$i]['no_lab'] != '')
                        {
                            $s_no_lab .= $hasilanalisa[$i]['no_lab'];
                        }
                        else{
                            $s_no_lab .= '';
                        }
                        #NO LAB

                        #KODE CONTOH
                        if($hasilanalisa[$i]['kode_contoh'] != '')
                        {
                            $s_kode_contoh .= $hasilanalisa[$i]['kode_contoh'];
                        }
                        else{
                            $s_kode_contoh .= '';
                        }
                        #KODE CONTOH
                        
                        #ID PETUGAS
                        if($hasilanalisa[$i]['id_petugas'] != '')
                        {
                            $s_id_petugas .= $hasilanalisa[$i]['id_petugas'];
                        }
                        else{
                            $s_id_petugas .= '';
                        }
                        #ID PETUGAS

                        #N
                        if($hasilanalisa[$i]['N'] != '')
                        {
                            $s_N .= $hasilanalisa[$i]['N'];
                        }
                        else{
                            $s_N .= '';
                        }
                        #N

                        #P
                        if($hasilanalisa[$i]['P'] != '')
                        {
                            $s_P .= $hasilanalisa[$i]['P'];
                        }
                        else{
                            $s_P .= '';
                        }
                        #P

                        #K
                        if($hasilanalisa[$i]['K'] != '')
                        {
                            $s_K .= $hasilanalisa[$i]['K'];
                        }
                        else{
                            $s_K .= '';
                        }
                        #K

                        #Mg
                        if($hasilanalisa[$i]['Mg'] != '')
                        {
                            $s_Mg .= $hasilanalisa[$i]['Mg'];
                        }
                        else{
                            $s_Mg .= '';
                        }
                        #Mg

                        #Ca
                        if($hasilanalisa[$i]['Ca'] != '')
                        {
                            $s_Ca .= $hasilanalisa[$i]['Ca'];
                        }
                        else{
                            $s_Ca .= '';
                        }
                        #Ca

                        #B
                        if($hasilanalisa[$i]['B'] != '')
                        {
                            $s_B .= $hasilanalisa[$i]['B'];
                        }
                        else{
                            $s_B .= '';
                        }
                        #B

                        #Cu
                        if($hasilanalisa[$i]['Cu'] != '')
                        {
                            $s_Cu .= $hasilanalisa[$i]['Cu'];
                        }
                        else{
                            $s_Cu .= '';
                        }
                        #Cu

                        #Zn
                        if($hasilanalisa[$i]['Zn'] != '')
                        {
                            $s_Zn .= $hasilanalisa[$i]['Zn'];
                        }
                        else{
                            $s_Zn .= '';
                        }
                        #Zn

                        #Fe
                        if($hasilanalisa[$i]['Fe'] != '')
                        {
                            $s_Fe .= $hasilanalisa[$i]['Fe'];
                        }
                        else{
                            $s_Fe .= '';
                        }
                        #Fe
                        
                        #Mn
                        if($hasilanalisa[$i]['Mn'] != '')
                        {
                            $s_Mn .= $hasilanalisa[$i]['Mn'];
                        }
                        else{
                            $s_Mn .= '';
                        }
                        #Mn

                        #STATUS
                        if($hasilanalisa[$i]['status'] != '')
                        {
                            $s_status .= $hasilanalisa[$i]['status'];
                        }
                        else{
                            $s_status .= '';
                        }
                        #STATUS
                        
                        #RETRY
                        if($hasilanalisa[$i]['retry'] != '')
                        {
                            $s_retry .= $hasilanalisa[$i]['retry'];
                        }
                        else{
                            $s_retry .= '';
                        }
                        #RETRY
                    }
                }

                $response->id = $s_id;
                $response->id_kupa = $s_id_kupa;
                $response->tahun = $s_tahun;
                $response->id_jenis_sampel = $s_id_jenis_sampel;
                $response->no_lab = $s_no_lab;
                $response->kode_contoh = $s_kode_contoh;
                $response->id_petugas = $s_id_petugas;
                $response->N = $s_N;
                $response->P = $s_P;
                $response->K = $s_K;
                $response->Mg = $s_Mg;
                $response->Ca = $s_Ca;
                $response->B = $s_B;
                $response->Cu = $s_Cu;
                $response->Zn = $s_Zn;
                $response->Fe = $s_Fe;
                $response->Mn = $s_Mn;
                $response->status = $s_status;
                $response->retry = $s_retry;

            }
        }
        else
        {
            $response->success = 0;
            $response->message = "KUPA TIDAK BOLEH KOSONG";
        }
        die(json_encode($response));
    }
    #GET HASILANALISA

    #POST HASILANALISA
    function PostHasilAnalisa(Request $request, $id = null, $v_parameter = null)
    {
        $s_id           = '';
        $s_parameter    = '';
        if(!isset($id) OR !isset($v_parameter))
        {
            if(!isset($request->id) AND !isset($request->v_parameter))
            {

            }
            else
            {

            }
        }
    }
    #POST HASILANALISA
}
