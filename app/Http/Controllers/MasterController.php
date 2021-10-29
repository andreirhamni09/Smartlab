<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AksesLevel;

use App\Controllers\ApiController;
use App\Models\HasilAnalisa;
use DateTime;
use Illuminate\Support\Facades\Date;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use function PHPUnit\Framework\isNull;


date_default_timezone_set("Asia/Jakarta");

use SimpleSoftwareIO\QrCode\Facades\QrCode;

require 'vendor/autoload.php';

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
    public static function Tracking($id){
        $gettracking    = app('App\Http\Controllers\ApiController')->GetDetailTrackings($id);
        $gettracking    = json_decode($gettracking, true);
        $tracking       = array();
        if($gettracking['success'] == '1')
        {
            $tracking = [
                'aktivitas_waktu'   => explode('-', $gettracking['aktivitas_waktu']),
                'aktivitas_id'      => explode('-', $gettracking['aktivitas_id']),
                'aktivitas'         => explode('-', $gettracking['aktivitas']),
                'lab_akuns_id'      => explode('-', $gettracking['lab_akuns_id']),
                'lab_akuns_nama'    => explode('-', $gettracking['lab_akuns_nama']),  
                'group'             => explode('-', $gettracking['group']),                
                'success'           => $gettracking['success'],
                'message'           => $gettracking['message']
            ];  
        }
        else{
            $tracking = [             
                'success'           => $gettracking['success'],
                'message'           => $gettracking['message']
            ];  
        }

        return view('admin.tracking.tracking', [
            'tracking' => $tracking
        ]);
    }
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

    public static function Enkripsi($sampels_id){
        error_reporting(0);
        $cipher = "aes-128-cbc"; 

        //Generate a 256-bit encryption key 
        $encryption_key = '%smartlabcbi2021'; 
        
        $encrypted_data = openssl_encrypt($sampels_id, $cipher, $encryption_key, 0, '');
        
        return urlencode($encrypted_data);
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

    public static function KirimEmail($sampels_id){
        $request = new Request();
        $getdatasampels     = app('App\Http\Controllers\ApiController')->GetDataSampelsById($request, $sampels_id); 
        $getdatasampels     = json_decode($getdatasampels, true);

        if($getdatasampels['success'] == 1)
        {
        
            $waktu      = $getdatasampels['tanggal_masuk'];
            $date       = date_create($waktu);
            $waktu      = date_format($date, 'H:i:s d-m-Y');
            
            $getpelanggans  = DB::table('pelanggans')
                              ->where('pelanggans.id', '=', $getdatasampels['pelanggans_id'])
                              ->first();
            $getpelanggans  = json_decode(json_encode($getpelanggans), true);
            $email          = $getpelanggans['email'];
            $nama           = $getpelanggans['nama'];
            $sampels_id     = app('App\Http\Controllers\MasterController')->Enkripsi($getdatasampels['id']);
            $mail           = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = env('MAIL_HOST');                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                           //Enable SMTP authentication
                $mail->Username   = env('MAIL_USERNAME');                     //SMTP username
                $mail->Password   = env('MAIL_PASSWORD');          
                $mail->SMTPSecure = 'ssl';          //Enable implicit TLS encryption
                $mail->Port       = env('MAIL_PORT');

              
            
                //Recipients
                $mail->setFrom('lab-email@slab.srs-ssms.com', 'Tracking Sampel');
                $mail->addAddress($email);     //Add a recipient
                $mail->addReplyTo('lab-email@slab.srs-ssms.com');
                
                $link = 'https://slab.srs-ssms.com/tracking?resi='.$sampels_id.'';
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Sampel Anda Telah Terdaftar';
                $html_ini           = '
                    <html>
                    <style>
                        .hitam {
                            color:black;
                        }
                    </style>
                    <body style="color:black;">
                        <label>Dear '.$nama.',</label>
                        <p>Terima kasih telah memilih laboratorium PT. Sawit Sumbermas Sarana, tbk. sebagai penyedia jasa analisa laboratorium anda, berikut link untuk tracking dan kode resi yang dapat digunakan untuk melacak sampel :</p>
                        <br><br>
                        <p>Link : <a href='.$link.'>'.$link.'</a></p> 
                        <p>Resi : '.urldecode($sampels_id).'</p> 
                        <p>Tanggal registrasi sampel : '.$waktu.'</p>                         
                        <br><br>                                              
                        <p>Jika ada pertanyaan silahkan hubungi nomor ini atau dapat mengirim email ke </p>

                        <p><b>Terima kasih</b></p>
                    </body>
                    </html>
                
                ';

                $mail->Body    = $html_ini;
            
                if($mail->send())
                {
                    return redirect()->back()->with('kirim_email', 'INFORMASI RESI TELAH DIKIRIMKAN KE EMAIL PELANGGAN');
                }
                else{
                    $pesankesalahan = 'GAGAL KIRIM EMAIL :'.$mail->ErrorInfo;
                    return redirect()->back()->with('kirim_email', $pesankesalahan);
                }
            } catch (Exception $e) {
                $pesankesalahan = 'KONFIGURASI KIRIM EMAIL GAGAL, PESAN KESALAHAN :'.$mail->ErrorInfo;
                return redirect()->back()->with('kirim_email', $pesankesalahan);
            }
        }
        else{
            return redirect()->back()->with('kirim_email', 'GAGAL KIRIM EMAIL DATA TIDAK DITEMUKAN');
        }
    }

#11 14 DATA SAMPELS -> PAGES

#15 16 HASIL ANALISAS -> PAGES
    #CRUD HASIL ANALISA
    public static function CrudHasilAnalisis(Request $request)
    {
        $status_update  = 0;
        $id_analisis    = array();
        $d_analisis     = DB::table('hasil_analisas')
        ->where('data_sampels_id', $request->id_kupa)->get();
        foreach($d_analisis as $analisis)
        {
            array_push($id_analisis, $analisis->id);
        }
        $kode_contoh = $request->kode_contoh;

        try {
            for($i = 0; $i < count($id_analisis); $i++)
            {
                DB::table('hasil_analisas')
                ->where('id', '=', $id_analisis[$i])
                ->update([
                    'kode_contoh'             => $kode_contoh[$i]
                ]);
            }
            $status_update = 1;
        } catch (Exception $e) {
            return redirect()->back()->with('update', $e->getMessage());
        } 

        if($status_update == 1)
        {
            return redirect()->back()->with('update', 'BERHASIL UPDATE DATA');
        }
    }
    #CRUD HASIL ANALISA

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

        $gethasilanalisa   = app('App\Http\Controllers\ApiController')->GetHasilAnalisas($id);
        $gethasilanalisa   = json_decode($gethasilanalisa, true);
        $hasilanalisa      = array();
        if($gethasilanalisa['success'] == 1){
            $hasilanalisa = [
                'id'                => explode('-', $gethasilanalisa['id']),
                'tahun'             => explode('-', $gethasilanalisa['tahun']),
                'jenis_sampels_id'  => explode('-', $gethasilanalisa['jenis_sampels_id']),
                'paket_id'          => explode(';', $gethasilanalisa['parameters_id_s']),
                'no_lab'            => explode('-', $gethasilanalisa['no_lab']),
                'kode_contoh'       => explode('-', $gethasilanalisa['kode_contoh']),
                'hasil'             => explode('|', $gethasilanalisa['hasil']),
                'status'            => explode('-', $gethasilanalisa['status'])
            ];
        } 
        else{
            $hasilanalisa = array();
        }
        
        #QR CODE
        $qrcode = app('App\Http\Controllers\ApiController')->GetQrCode($id);
        $qrcode = json_decode($qrcode, true);
        
        $d_s_id         = explode('|', $qrcode['sampel_id']);
        $d_s_no_lab_1   = explode('|', $qrcode['no_lab_1']);
        $d_s_no_lab_2   = explode('|', $qrcode['no_lab_2']);
        $d_s_batch      = explode('|', $qrcode['batch']);
        
        $arr_qr_code        = array();
        $arr_data_qr_code       = [
            'sampel_id'   => explode('|', $qrcode['sampel_id']),
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
            array_push($arr_qr_code, $qrcd);
        }  

        return view('admin.sampel.hasil_analisis',  [
                'datasampels'   => $datasampels,
                'jenissampels'  => $jenissampels,
                'pelanggans'    => $pelanggans,
                'pakets'        => $pakets,
                'halamans'      => $halamans,
                'hasilanalisa'  => $hasilanalisa,
                'kupa'          => $id,
                'qrcode'        => $arr_qr_code,
                'dataqrcode'    => $arr_data_qr_code
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

#ANALISA SAMPEL
    public static function AnalisaSampel($sampels_id){
        $halamans = app('App\Http\Controllers\MasterController')->GetHal();  
        
        $gethasilanalisa = app('App\Http\Controllers\ApiController')->GetHasilAnalisas($sampels_id);       
        $gethasilanalisa = json_decode($gethasilanalisa, true);

        $analisa_sampel  = '';
        if($gethasilanalisa['success'] == '1')
        {
            $analisa_sampel = [
                'id'               => explode('-', $gethasilanalisa['id']),
                'tahun'            => explode('-', $gethasilanalisa['tahun']),
                'jenis_sampels_id' => explode('-', $gethasilanalisa['jenis_sampels_id']),
                'parameters_id_s'  => explode(';', $gethasilanalisa['parameters_id_s']),
                'no_lab'           => explode('-', $gethasilanalisa['no_lab']),
                'kode_contoh'      => explode('-', $gethasilanalisa['kode_contoh']),
                'hasil'            => explode('|', $gethasilanalisa['hasil']),
                'hasil_verifikasi' => explode('|', $gethasilanalisa['hasil_verifikasi']),
                'status'           => explode('-', $gethasilanalisa['status']),
                'batch'            => explode('-', $gethasilanalisa['batch']),
                'log'              => explode('|', $gethasilanalisa['log']),
                'success'          => $gethasilanalisa['success'],
                'message'          => $gethasilanalisa['message']
            ];
        }
        else
        {
            $analisa_sampel = [
                'success'          => $gethasilanalisa['success'],
                'message'          => $gethasilanalisa['message']
            ];
        }

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

        return view('admin.sampel.analisa_sampel', [
            'halamans'          => $halamans,
            'analisasampel'     => $analisa_sampel,
            'jenissampels'      => $jenissampels
        ]);
    }
#ANALISA SAMPEL

#QRCODE

    public static function QrCodeAll($sampel_id, $batch)
    {   
        $qrcode = app('App\Http\Controllers\ApiController')->GetQrCodeBatch($sampel_id, $batch);
        $qrcode = json_decode($qrcode, true);
        
        $d_s_id         = explode('|', $qrcode['sampel_id']);
        $d_s_no_lab_1   = explode('|', $qrcode['no_lab_1']);
        $d_s_no_lab_2   = explode('|', $qrcode['no_lab_2']);
        $d_s_batch      = explode('|', $qrcode['batch']);
        
        $arr_qr_code        = array();
        $arr_data_qr_code   = [
            'sampel_id'   => explode('|', $qrcode['sampel_id']),
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
            $qrcodes = app('App\Http\Controllers\ApiController')->Enkripsi($dataqrcode);
            $qrcd       = QrCode::size(200)->generate($qrcodes);
            array_push($arr_qr_code, $qrcd);
        }
        /* for ($i = 0; $i < count($arr_qr_code); $i++) { 
            echo $arr_qr_code[$i].'<br>'.$arr_data_qr_code['sampel_id'][$i].'<br><br>';
        } */

        $halamans           = app('App\Http\Controllers\MasterController')->GetHal(); 
        
        
                                                    
        return view('admin.daftarqrcode.qrcode', [
                                                    'halamans'      => $halamans,
                                                    'qrcode'        => $arr_qr_code,
                                                    'dataqrcode'    => $arr_data_qr_code
                                                ]);
    }



    public static function QCEncript($data){        
        
        error_reporting(0);
        $cipher = "aes-128-cbc"; 

        //Generate a 256-bit encryption key 
        $encryption_key = '%smartlabcbi2021'; 
        
        $encrypted_data = openssl_encrypt($data, $cipher, $encryption_key, 0, '');
        
        return $encrypted_data;
    }
#QRCODE

#DEADLINE
    public static function DeadLine(){
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

        $sampels_id         = $datasampels['id'];
        $n_lab              = array();
        $batch              = array();
        $tanggal_masuk      = $datasampels['tanggal_masuk'];
        $batas_selesai      = $datasampels['tanggal_selesai'];
        $tanggal_selesai    = array();
        $tanggal_selesai_2  = array();
        $aktivitas          = array();
        $status             = $datasampels['status'];
        
        for ($i = 0; $i < count($sampels_id); $i++) { 
            $str_gethasilanalisas  = app('App\Http\Controllers\ApiController')->GetHasilAnalisas($sampels_id[$i]);
            $gethasilanalisas = json_decode($str_gethasilanalisas, true);
    
            $b = array_unique(explode('-', $gethasilanalisas['batch']));
            $b = array_values($b);
    
            array_push($batch, implode(',', $b));
        
            
            $t          = explode('-', $gethasilanalisas['tahun']);
            $s          = explode('-', $gethasilanalisas['simbol']);
            $n          = explode('-', $gethasilanalisas['no_lab']);
            $no_lab     = current($t).current($s).'.'.current($n).'-'.end($t).end($s).'.'.end($n);
           
            array_push($n_lab, $no_lab);
    
    
    
            $add_d      = "+".$batas_selesai[$i]." days"; 
            $batas      = strtotime(str_replace('/', '-', $tanggal_masuk[$i]). $add_d);
            $t_now      = strtotime("now");
            $tg_batas   = $batas - $t_now;
            $deadline   = floor($tg_batas / (60 * 60 * 24));
            array_push($tanggal_selesai, date('H:i d-m-Y', $batas));
            array_push($tanggal_selesai_2, $deadline);
    
            $str_get_aktivitas = app('App\Http\Controllers\ApiController')->GetDetailTrackings($sampels_id[$i]);
            $getdetailtrackings = json_decode($str_get_aktivitas, true);
    
            $waktu_detailtrack      = explode('-', $getdetailtrackings['aktivitas_waktu']);
            $aktivitas_detailtrack  = explode('-', $getdetailtrackings['aktivitas']);
            $akt    = 'Aktivitas Terakhir: '.strtoupper(current($aktivitas_detailtrack)). ', Tanggal Pengerjaan : '.date('H:i d-m-Y', strtotime(str_replace('/', '-', current($waktu_detailtrack))));
            array_push($aktivitas, $akt);
        }

        $deadline   = [
            'sampels_id'        => $sampels_id,
            'batch'             => $batch,
            'n_lab'             => $n_lab,
            'tanggal_masuk'     => $tanggal_masuk,        
            'batas_selesai'     => $batas_selesai,        
            'tanggal_selesai'   => $tanggal_selesai,       
            'tanggal_selesai_2'   => $tanggal_selesai_2,           
            'aktivitas'         => $aktivitas,    
            'status'            => $status    
        ];

        return view('admin.sampel.deadline', [
            'halamans'  => $halamans,    
            'deadline'  => $deadline
        ]);
    }
#DEADLINE


#PELANGGAN
    public static function LoginPelanggan(Request $request)
    {        
        $email      = $request->email;
        $password   = $request->password;
        
        $resi       = '';
        if(isset($request->resi))
        {
            $resi       = $request->resi;
        }
        else{
            $resi       = '';
        }

        $loginpelanggan = app('App\Http\Controllers\ApiController')->LoginPelanggans($request, $email, $password);        
        $loginpelanggan = json_decode($loginpelanggan, true);

        if($loginpelanggan['success'] == 1)
        {
            $pelanggans = [
                'id'    => $loginpelanggan['id']
            ];
            return redirect()->route('tracking', ['pelanggan' => $pelanggans])->with('resi', $resi);
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
        session_start();
        session_destroy();
        $resi       = $request->resi;
        $user_id    = $request->id;

        $pelanggans = [
            'id'    => $user_id 
        ];

        $cekresi    = app('App\Http\Controllers\ApiController')->CekResi($user_id, $resi);        
        $cekresi    = json_decode($cekresi, true);
        $resi       = array();
        if($cekresi['success'] == 1){
            $resi   = [
                'aktivitas_waktu'   => explode('-', $cekresi['aktivitas_waktu']),
                'lab_akuns_nama'    => explode('-', $cekresi['lab_akuns_nama']),
                'group'             => explode('-', $cekresi['group']),
                'success'           => $cekresi['success'],
                'message'           => $cekresi['message']
            ];
        }
        else{
            $resi   = [
                'success'           => $cekresi['success'],
                'message'           => $cekresi['message']
            ];
        }
        return redirect()->route('tracking', [
            'pelanggan' => $pelanggans,
            'tracking'  => $resi
        ]);
    }

    public static function Dekrip($sampels_id){
        error_reporting(0);
        $cipher = "aes-128-cbc"; 

        //Generate a 256-bit encryption key 
        $encryption_key = '%smartlabcbi2021'; 
        $decrypted_data = openssl_decrypt($sampels_id, 
                                        $cipher, 
                                        $encryption_key, 
                                        0, 
                                        ''); 

        return $decrypted_data;
    }

    public static function Logout(){
        session_start();
        session_destroy();
        return redirect()->route('login', [
            'status' => 'TELAH LOGOUT'
        ]);
    }

#PELANGGAN

#ADMIN    
    #ADMIN HOME
    public static function AdminHome(){
        $halamans   = app('App\Http\Controllers\MasterController')->GetHal(); 
        return view('admin.home' ,
            ['halamans'      => $halamans]
        );
    }

    public static function Login()
    {
        return view('admin.login');
    }

    public static function LoginAdmin(Request $request)
    {        
        session_start();
        $email      = $request->email;
        $password   = $request->password;

        $loginadmin = app('App\Http\Controllers\ApiController')->LoginPelanggans($request, $email, $password);        
        $loginadmin = json_decode($loginadmin, true);

        if($loginadmin['success'] == '1'){
            $_SESSION['adminlab'] = [
                'id'    => $loginadmin['id'],
                'nama'  => $loginadmin['nama'],
                'email' => $loginadmin['email']
            ];
            return redirect()->route('adminhome');
        }
        else{
            return redirect()->route('loginadmin', ['status' => $loginadmin['message']]);  
        }
       /*  $_SESSION['adminlab'] = 'ANDRE S IRHAMNI WICAKSANA';*/
    }

    public static function LogoutAdmin()
    {
        session_start();
        unset($_SESSION['adminlab']);
        return redirect()->route('loginadmin', ['status' => 'ANDA TELAH LOGOUT']);  
    }
#ADMIN
}
