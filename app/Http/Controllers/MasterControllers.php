<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;


use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

# MODEL AKSESLEVEL
use App\Models\AksesLevel;
# MODEL LABAKUN
use App\Models\LabAkun;
# MODEL PELANGGAN
use App\Models\Pelanggan;
# MODEL PARAMETER
use App\Models\Parameter;
# MODEL DATASAMPEL
use App\Models\DataSampel;
use App\Models\HasilAnalisa;
use DateTime;
# MODEL JENISSAMPEL
use App\Models\JenisSampel;
use Symfony\Component\VarDumper\Cloner\Data;

class usr{}

class MasterController extends Controller
{
    #KOMEN
    // 
    //     /**
    //      * Handle the incoming request.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

        
    //     public function __invoke(Request $request)
    //     {
    //     }

    //     public function Login()
    //     {
    //         return view('admin.auth.login');
    //     }

    //     public function Register()
    //     {
    //         return view('admin.auth.register');
    //     }

    //     # PAGES AKSESLEVEL
    //     public function AksesLevel()
    //     {
    //         $akseslevel = AksesLevel::orderBy('id', 'ASC')->get();
    //         return view('admin.akseslevel.daftar', ['akseslevel' => $akseslevel]);
    //     }
    //     # PAGES AKSESLEVEL

    //     # CRUD AKSESLEVEL
    //     public function CrudAksesLevel(Request $request)
    //     {
    //         $status     = $request->action;

    //         #INSERT AKSES LEVEL
    //         if($status == 'add'){
    //             $rules          = [
    //                 'id'            => 'required|numeric|min:0',
    //                 'jabatan'       => 'required|string|min:2|max:20'
    //             ];

    //             $messages       = [
    //                 'id.required'       => 'Akses Level Wajib Diisi',
    //                 'id.min'            => 'Akses Level Wajib Tidak Boleh Angka Minus',
    //                 'jabatan.required'  => 'Jabatan Wajib Diisi',
    //                 'jabatan.min'       => 'Jabatan Minimal Mengandung 2 Karakter',
    //                 'jabatan.max'       => 'Jabatan Maksimal Mengandung 20 Karakter',
    //             ];

    //             $validator = Validator::make($request->all(), $rules, $messages);
    //             if ($validator->fails()) {
    //                 return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error_insert', 'Gagal');
    //             } else {
    //                 $akseslevel                 = new AksesLevel;
    //                 $akseslevel->id             = $request->id;
    //                 $akseslevel->jabatan        = strtolower($request->jabatan);
    //                 try {
    //                     $akseslevel->save();
    //                     return redirect()->back()->with('insert', 'BEHASIL MEMASUKAN DATA');
    //                 } catch (Exception $e) {
    //                     //return redirect()->back()->with('insert', $e->getMessage());

    //                     switch ($e->getMessage()) {
    //                         case strpos($e->getMessage(), '1062') == TRUE:
    //                             return redirect()->back()->with('insert', 'ID AKSES LEVEL ATAU JABATAN SUDAH TERDAFTAR');
    //                             break;
                            
    //                         default:
    //                             return redirect()->back()->with('insert', $e->getMessage());                            
    //                             break;
    //                     }                 
    //                 }
    //             }
    //         }
    //         #INSERT AKSES LEVEL

    //         #UPDATE AKSES LEVEL
    //         elseif ($status == 'update') {
    //             $rules          = [
    //                 'u_idakseslevel_'.$request->u_id.''  => 'required|numeric|min:0',
    //                 'u_jabatan_'.$request->u_id.''       => 'required'
    //             ];

    //             $messages       = [
    //                 'u_idakseslevel_'.$request->u_id.'.required' => 'Akses Level Wajib Diisi',
    //                 'u_idakseslevel_'.$request->u_id.'.min'      => 'Akses Level Wajib Tidak Boleh Angka Minus',
    //                 'u_jabatan_'.$request->u_id.'.required'      => 'Jabatan Wajib Diisi',
    //             ];

    //             $validator = Validator::make($request->all(), $rules, $messages);

    //             if ($validator->fails()) {
    //                 return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error_update', 'Gagal');
    //             } else {
    //                 try {
    //                     $id         = 'u_idakseslevel_'.$request->u_id;
    //                     $idaklev    = $request->$id;
    //                     $jabatan    = 'u_jabatan_'.$request->u_id;
    //                     $u_jabatan  = $request->$jabatan;
    //                     AksesLevel::where('id', $request->u_id)
    //                         ->update(['id' => $idaklev, 'jabatan' => strtolower($u_jabatan)]);
    //                     return redirect()->back()->with('update', 'BEHASIL MENGUPDATE DATA');
    //                 } catch (Exception $e) {

    //                     switch ($e->getMessage()) {
    //                         case strpos($e->getMessage(), '1062') == TRUE:
    //                             return redirect()->back()->with('update', 'ID AKSES LEVEL ATAU JABATAN SUDAH TERDAFTAR');
    //                             break;
                            
    //                         default:
    //                             return redirect()->back()->with('update', $e->getMessage());                            
    //                             break;
    //                     }
    //                 }
    //             }
    //         } 
    //         #UPDATE AKSES LEVEL

    //         # DELETE AKSES LEVEL
    //         elseif($status == 'delete'){
    //             $akseslevel = AksesLevel::find($request->u_id);
    //             try {
    //                 $akseslevel->delete();
    //                 return redirect()->back()->with('delete', 'DATA BERHASIL DIHAPUS');
    //             } catch (Exception $e) {
    //                 //return redirect()->back()->with('delete', $e->getMessage());
    //                 switch ($e->getMessage()) {
    //                     case strpos($e->getMessage(), '1451') == TRUE:
    //                         return redirect()->back()->with('delete', 'AKSES LEVEL SEDANG DIGUNAKAN');
    //                         break;
                        
    //                     default:
    //                         # code...
    //                         break;
    //                 }
    //             }
    //         }
    //         # DELETE AKSES LEVEL
    //     }
    //     # CRUD AKSESLEVEL

    //     # PAGES USERLAB
    //     public function UserLab()
    //     {
    //         $akseslevel = DB::table('akses_levels')->orderBy('id')->get();

    //         #Inner Join
    //         $labAkun    = LabAkun::select('lab_akuns')
    //             ->join('akses_levels', 'lab_akuns.id_akses', '=', 'akses_levels.id')
    //             ->select('lab_akuns.*', 'akses_levels.jabatan as nama_jabatan')
    //             ->orderBy('lab_akuns.id')->get();

    //         return view('admin.userlab.userlab', ['akseslevel' => $akseslevel, 'labakun' => $labAkun]);
    //     }
    //     # PAGES USERLAB

    //     # CRUD USERLAB
    //     public function CrudUserLab(Request $request)
    //     {
    //         $status = $request->action;

    //         # INSERT USERLAB
    //         if ($status == 'add') {
    //             $rules      = [
    //                 'id_akses'      => 'required',
    //                 'nama'          => 'required|string|min:3|max:70',
    //                 'email'         => 'required|email',
    //                 'jabatan'       => 'required|string|min:2|max:25',
    //                 'password'      => 'required|string|min:8'
    //             ];

    //             $messages   = [
    //                 'id_akses.required' => 'Akses Level Wajib Diisi',
    //                 'nama.required'     => 'Nama Wajib Diisi',
    //                 'nama.min'          => 'Minimal Karakter Pengisian Nama Adalah 3 Karakter',
    //                 'nama.max'          => 'Maksimal Karakter Pengisian Nama Adalah 70 Karakter',
    //                 'email.required'    => 'Email Wajib Diisi',
    //                 'email.email'       => 'Masukan Email Dengan Benar',
    //                 'jabatan.required'  => 'Jabatan Wajib Diisi',
    //                 'jabatan.min'       => 'Minimal Karakter Pengisian Jabatan Adalah 2 Karakter',
    //                 'jabatan.max'       => 'Maksimal Karakter Pengisian Jabatan Adalah 25 Karakter',
    //                 'password.required' => 'Password Wajib Diisi',
    //                 'password.min'      => 'Password Minimal Punya 8 Karakter',
    //             ];


    //             $validator = Validator::make($request->all(), $rules, $messages);

    //             if ($validator->fails()) {
    //                 return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error_insert', 'Gagal');
    //             } else {
    //                 $labAkun = new LabAkun;

    //                 $labAkun->id_akses  = $request->id_akses;
    //                 $labAkun->nama      = $request->nama;
    //                 $labAkun->jabatan   = $request->jabatan;
    //                 $labAkun->email     = $request->email;
    //                 $labAkun->password  = $request->password;
    //                 $status_akun        = '0';

    //                 if ($request->id_akses == 5) {
    //                     $status_akun    = '1';
    //                 } elseif ($request->id_akses != 5) {
    //                     $status_akun    = '0'; 
    //                 }
                    
    //                 $labAkun->status_akun   = $status_akun;

    //                 try {
    //                     $labAkun->save();
    //                     return redirect()->back()->with('insert', 'BEHASIL MEMASUKAN DATA');
    //                 } catch (Exception $e) {
    //                     // return redirect()->back()->with('insert', $e->getMessage());

    //                     switch ($e->getMessage()) {
    //                         case strpos($e->getMessage(), '1062') == TRUE:
    //                             return redirect()->back()->with('insert', 'EMAIL TELAH DIGUNAKAN');
    //                             break;
                            
    //                         default:

    //                             break;
    //                     }
    //                 }
    //             }
    //         } 
    //         # INSERT USER LAB
            
    //         #UPDATE USERLAB
    //         elseif ($status == 'update') {
    //             $rules      = [
    //                 'u_id_akses_'.$request->u_idakunlab.''      => 'required',
    //                 'u_nama_'.$request->u_idakunlab.''          => 'required|string|min:3|max:70',
    //                 'u_email_'.$request->u_idakunlab.''         => 'required|email',
    //                 'u_jabatan_'.$request->u_idakunlab.''       => 'required|string|min:2|max:25',
    //                 'u_password_'.$request->u_idakunlab.''      => 'required|string|min:8',
    //                 'u_status_akun_'.$request->u_idakunlab.''   => 'required'
    //             ];

    //             $messages   = [
    //                 'u_id_akses_'.$request->u_idakunlab.'.required'     => 'Akses Level Wajib Diisi',
    //                 'u_nama_'.$request->u_idakunlab.'.required'         => 'Nama Wajib Diisi',
    //                 'u_nama_'.$request->u_idakunlab.'.min'              => 'Minimal Karakter Pengisian Nama Adalah 3 Karakter',
    //                 'u_nama_'.$request->u_idakunlab.'.max'              => 'Maksimal Karakter Pengisian Nama Adalah 70 Karakter',
    //                 'u_email_'.$request->u_idakunlab.'.required'        => 'Email Wajib Diisi',
    //                 'u_email_'.$request->u_idakunlab.'.email'           => 'Masukan Email Dengan Benar',
    //                 'u_jabatan_'.$request->u_idakunlab.'.required'      => 'Jabatan Wajib Diisi',
    //                 'u_jabatan_'.$request->u_idakunlab.'.min'           => 'Minimal Karakter Pengisian Jabatan Adalah 2 Karakter',
    //                 'u_jabatan_'.$request->u_idakunlab.'.max'           => 'Maksimal Karakter Pengisian Jabatan Adalah 25 Karakter',
    //                 'u_password_'.$request->u_idakunlab.'.required'     => 'Password Wajib Diisi',
    //                 'u_password_'.$request->u_idakunlab.'.min'          => 'Password Minimal Punya 8 Karakter',
    //                 'u_status_akun_'.$request->u_idakunlab.'.required'  => 'Status Akun Wajib Diisi'
    //             ];

    //             $validator = Validator::make($request->all(), $rules, $messages);
    //             if ($validator->fails()) {
    //                 return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error_update', 'Gagal');
    //             } else {                
    //                 $u_idakunlab    = $request->u_idakunlab;
    //                 $email          = 'u_email_'.$request->u_idakunlab;
    //                 $u_email        = $request->$email;
    //                 $nama           = 'u_nama_'.$request->u_idakunlab;
    //                 $u_nama         = $request->$nama;
    //                 $jabatan        = 'u_jabatan_'.$request->u_idakunlab;
    //                 $u_jabatan      = $request->$jabatan;
    //                 $id_akses       = 'u_id_akses_'.$request->u_idakunlab;
    //                 $u_id_akses     = $request->$id_akses;
    //                 $password       = 'u_password_'.$request->u_idakunlab;
    //                 $u_password     = $request->$password;
    //                 $status_akun    = 'u_status_akun_'.$request->u_idakunlab;
    //                 $u_status_akun  = $request->$status_akun;

    //                 try {
    //                     LabAkun::where('id', $u_idakunlab)
    //                         ->update([
    //                             'email'   => $u_email,
    //                             'password'  => $u_password,
    //                             'jabatan'   => strtolower($u_jabatan),
    //                             'id_akses'  => $u_id_akses,
    //                             'nama'      => $u_nama,
    //                             'status_akun'   => $u_status_akun,
    //                             'jabatan'   => $u_jabatan
    //                         ]);
    //                     return redirect()->back()->with('update', 'BEHASIL MENGUPDATE DATA');
    //                 } catch (Exception $e) {
    //                     switch ($e->getMessage()) {
    //                         case strpos($e->getMessage(), '1062') == TRUE:
    //                             return redirect()->back()->with('update', 'EMAIL TELAH DIGUNAKAN');
    //                             break;
                            
    //                         default:
    //                             return redirect()->back()->with('update', $e->getMessage());
    //                             break;
    //                     }
    //                 }
    //             }
    //         }
    //         #UPDATE USERLAB

    //         #DELETE USERLAB
    //         elseif ($status == 'delete'){
    //             $userlab = LabAkun::find($request->u_idakunlab);
    //             try {
    //                 $userlab->delete();
    //                 return redirect()->back()->with('delete', 'DATA BERHASIL DIHAPUS');
    //             } catch (Exception $e) {

    //                 return redirect()->back()->with('delete', $e->getMessage());

    //                 /* switch ($e->getMessage()) {
    //                     case strpos($e->getMessage(), '1062') == TRUE:
    //                         return redirect()->back()->with('update', 'EMAIL TELAH DIGUNAKAN');
    //                         break;
                        
    //                     default:
    //                         return redirect()->back()->with('update', $e->getMessage());
    //                         break;
    //                 } */

    //                 /* switch ($e->getCode()) {
    //                     case 23000:
    //                         return redirect()->back()->with('delete', 'DATA SEDANG DIGUNAKAN');
    //                         break;                    
    //                     default:
    //                         # code...
    //                         break;
    //                 } */
    //             }
    //         }
    //         #DELETE USERLAB
    //     }
    //     # CRUD USERLAB

    //     # PAGES PELANGGAN
    //     public function Pelanggan()
    //     {
    //         $pelanggan = Pelanggan::all();
    //         return view('admin.pelanggan.pelanggan', ['pelanggan' => $pelanggan]);
    //     }
    //     # PAGES PELANGGAN

    //     # CRUD PELANGGAN
    //     public function CrudPelanggan(Request $request)
    //     {
    //         $status     = $request->action;
    //         switch ($status) {
    //             #INSERT PELANGGAN
    //             case 'add':
    //                 $rules      = [
    //                     'email'             => 'required|email',
    //                     'password'          => 'required|string|min:8',
    //                     'nama'              => 'required|string|max:70',
    //                     'perusahaan'        => 'required|string|max:70',
    //                     'nomor_telepon'     => 'required|string|max:15',
    //                     'alamat'            => 'required',
    //                     'tanggal'           => 'required|date'
    //                 ];
    //                 $messages   = [
    //                     'email.required'            => 'Email Wajib Diisi',
    //                     'email.email'               => 'Masukan Email Dengan Benar',
    //                     'password.required'         => 'Password Wajib Diisi',
    //                     'password.min'              => 'Password Minimal Punya 8 Karakter',
    //                     'nama.required'             => 'Nama Wajib Diisi',
    //                     'nama.max'                  => 'Maksimal Karakter adalah 70',
    //                     'perusahaan.required'       => 'Perusahaan Wajib Diisi',
    //                     'perusahaan.max'            => 'Maksimal Karakter adalah 70',
    //                     'nomor_telepon.required'    => 'Nomor Telepon Wajib Diisi',
    //                     'nomor_telepon.max'         => 'Maksimal Karakter adalah 15',
    //                     'alamat.required'           => 'Alamat Wajib Diisi',
    //                     'tanggal.required'          => 'Tanggal Wajib Diisi',
    //                     'tanggal.date'              => 'Format Pengisian Tanggal Salah'
    //                 ];

    //                 $validator = Validator::make($request->all(), $rules, $messages);

    //                 if ($validator->fails()) {
    //                     return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error_insert', 'Gagal');
    //                 }
    //                 else{
    //                     $pelanggan = new Pelanggan;

    //                     $pelanggan->email               = $request->email;
    //                     $pelanggan->password            = $request->password;
    //                     $pelanggan->nama                = $request->nama;
    //                     $pelanggan->perusahaan          = $request->perusahaan;
    //                     $pelanggan->nomor_telepon       = $request->nomor_telepon;
    //                     $pelanggan->alamat              = $request->alamat;
    //                     $pelanggan->tanggal_registrasi  = $request->tanggal;
                        
    //                     try {
    //                         $pelanggan->save();                        
    //                         return redirect()->back()->with('insert', 'BEHASIL MEMASUKAN DATA');
    //                     } catch (Exception $e) {                        
    //                         return redirect()->back()->with('insert', $e->getMessage());
    //                     }
    //                 }
    //                 break;            
    //             #INSERT PELANGGAN

    //             #UPDATE PELANGGAN
    //             case 'update':             
    //                 $u_id               = $request->u_idpel;
    //                 $rules      = [
    //                     'u_email_'.$u_id.''           => 'required|email',
    //                     'u_password_'.$u_id.''        => 'required|string|min:8',
    //                     'u_nama_'.$u_id.''            => 'required|string|max:70',
    //                     'u_perusahaan_'.$u_id.''      => 'required|string|max:50',
    //                     'u_nomor_telepon_'.$u_id.''   => 'required|string|max:15',
    //                     'u_alamat_'.$u_id.''          => 'required',
    //                     'u_tanggal_registrasi_'.$u_id.''         => 'required|date'
    //                 ];
    //                 $messages   = [
    //                     'u_email_'.$u_id.'.required'                => 'Email Wajib Diisi',
    //                     'u_email_'.$u_id.'.email'                   => 'Masukan Email Dengan Benar',
    //                     'u_password_'.$u_id.'.required'             => 'Password Wajib Diisi',
    //                     'u_password_'.$u_id.'.min'                  => 'Password Minimal Punya 8 Karakter',
    //                     'u_nama_'.$u_id.'.required'                 => 'Nama Wajib Diisi',
    //                     'u_nama_'.$u_id.'.max'                      => 'Maksimal Karakter adalah 70',
    //                     'u_perusahaan_'.$u_id.'.required'           => 'Perusahaan Wajib Diisi',
    //                     'u_perusahaan_'.$u_id.'.max'                => 'Maksimal Karakter adalah 50',
    //                     'u_nomor_telepon_'.$u_id.'.required'        => 'Nomor Telepon Wajib Diisi',
    //                     'u_nomor_telepon_'.$u_id.'.max'             => 'Maksimal Karakter adalah 15',
    //                     'u_alamat_'.$u_id.'.required'               => 'Alamat Wajib Diisi',
    //                     'u_tanggal_registrasi_'.$u_id.'.required'   => 'Tanggal Wajib Diisi',
    //                     'u_tanggal_registrasi_'.$u_id.'.date'       => 'Format Pengisian Tanggal Salah'
    //                 ];

    //                 $validator = Validator::make($request->all(), $rules, $messages);

    //                 if ($validator->fails()) {
    //                     return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error_update', 'Gagal');
    //                 }
    //                 else{
    //                     #EMAIL
    //                     $email                  = 'u_email_'.$u_id;
    //                     $u_email                = $request->$email;
    //                     # PASSWORD
    //                     $password               = 'u_password_'.$u_id;
    //                     $u_password             = $request->$password;
    //                     # NAMA
    //                     $nama                   = 'u_nama_'.$u_id;
    //                     $u_nama                 = $request->$nama;
    //                     # PERUSAHAAN
    //                     $perusahaan             = 'u_perusahaan_'.$u_id;
    //                     $u_perusahaan           = $request->$perusahaan;
    //                     # NOMOR TELEPON
    //                     $nomor_telepon          = 'u_nomor_telepon_'.$u_id;
    //                     $u_nomor_telepon        = $request->$nomor_telepon;
    //                     # ALAMAT
    //                     $alamat                 = 'u_alamat_'.$u_id;
    //                     $u_alamat               = $request->$alamat;
    //                     # TANGGAL REGISTRASI
    //                     $tanggal_registrasi     = 'u_tanggal_registrasi_'.$u_id;
    //                     $u_tanggal_registrasi   = $request->$tanggal_registrasi;                                    


    //                     try {
    //                         Pelanggan::where('id', $u_id)
    //                             ->update([
    //                                 'email'                 => $u_email,
    //                                 'password'              => $u_password,
    //                                 'nama'                  => $u_nama,
    //                                 'perusahaan'            => $u_perusahaan,
    //                                 'nomor_telepon'         => $u_nomor_telepon,
    //                                 'alamat'                => $u_alamat,
    //                                 'tanggal_registrasi'    => $u_tanggal_registrasi
    //                             ]);
    //                         return redirect()->back()->with('update', 'BEHASIL MENGUPDATE DATA');
    //                     } catch (Exception $e) {
    //                         switch ($e->getMessage()) {
    //                             case strpos($e->getMessage(), '1062') == TRUE:
    //                                 return redirect()->back()->with('update', 'EMAIL TELAH DIGUNAKAN');
    //                                 break;
                                
    //                             default:
    //                                 return redirect()->back()->with('update', $e->getMessage());
    //                                 break;
    //                         }
    //                     }

    //                 }
    //             break;
    //             #UPDATE PELANGGAN

    //             #DELETE
    //             case 'delete':
    //                 $pelanggan = Pelanggan::find($request->u_idpel);
    //                 try {
    //                     $pelanggan->delete();
    //                     return redirect()->back()->with('delete', 'DATA BERHASIL DIHAPUS');
    //                 } catch (Exception $e) {
    //                     return redirect()->back()->with('delete', $e->getMessage());
    //                 }
    //                 break;
    //             #DELETE
    //             default:
    //                 # code...
    //                 break;
    //         }
            
    //     } 
    //     # CRUD PELANGGAN

    //     # PAGES PARAMETER
    //     public function Parameter()
    //     {        
    //         // $parameter      = Parameter::select('parameters')
    //         // ->join('jenis_sampels', 'parameters.id_jenis_sampel', '=', 'jenis_sampels.id')
    //         // ->select('parameters.*', 'jenis_sampels.jenis_sampel as jenis_sampel')
    //         // ->get();

    //         // $jenis_sampels  = JenisSampel::all();  
    //         // return view('admin.parameter.parameter', ['parameter' => $parameter, 'jenis_sampel' => $jenis_sampels]);
    //     }
    //     # PAGES PARAMETER

    //     # CRUD PARAMETER
    //     public function CrudParameter(Request $request)
    //     {      
    //         #C  
    //             // $status     = $request->action;
    //             // switch ($status) {
    //             //     case 'add':
    //             //         $rules         = [
    //             //             'parameter'             => 'required|string|min:1',
    //             //             'harga'                 => 'required|numeric|min:10000',
    //             //             'jenis_sampel'          => 'required'                    
    //             //         ];
    //             //         $messages      = [
    //             //             'parameter.required'        => 'PARAMETER WAJIB DIISI',
    //             //             'parameter.string'          => 'WAJIB DIISI DENGAN HURUF',
    //             //             'paremeter.min'             => 'PARAMETER WAJIB DIISI MINIMAL 1 KARAKTER',
    //             //             'harga.required'            => 'HARGA WAJIB DIISI',
    //             //             'harga.numeric'             => 'HARGA WAJIB DIISI DENGAN ANGKA',
    //             //             'harga.min'                 => 'MINIMAL HARGA ADALAH Rp. 10.000',
    //             //             'jenis_sampel.required'     => 'JENIS SAMPEL WAJIB DIISI'
    //             //         ]; 

    //             //         $reqAll = [
    //             //             'parameter'         => $request->parameter,
    //             //             'harga'             => str_replace('.', '',$request->harga),
    //             //             'jenis_sampel'      => $request->jenis_sampel
    //             //         ];

    //             //         $validator = Validator::make($reqAll, $rules, $messages);

    //             //         if ($validator->fails()) {
    //             //             return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error_insert', 'Gagal');
    //             //         }
    //             //         else{

    //             //             $parameter                     = new Parameter; 
    //             //             $parameter->parameter          = $reqAll['parameter'];
    //             //             $parameter->harga              = $reqAll['harga'];
    //             //             $parameter->id_jenis_sampel    = $reqAll['jenis_sampel'];
    //             //             try {
    //             //                 $parameter->save();                        
    //             //                 return redirect()->back()->with('insert', 'BEHASIL MEMASUKAN DATA');
    //             //             } catch (Exception $e) {
    //             //                 switch ($e->getMessage()) {
    //             //                     case strpos($e->getMessage(), '1062') == TRUE:
    //             //                         return redirect()->back()->with('update', 'TIDAK DAPAT MEMASUKAN PARAMETER YANG SAMA');
    //             //                         break;
    //             //                     case strpos($e->getMessage(), '1452') == TRUE:
    //             //                             return redirect()->back()->with('update', 'ID JENIS SAMPEL TIDAK DITEMUKAN');
    //             //                             break;                           
    //             //                     default:
    //             //                         return redirect()->back()->with('update', $e->getMessage());
    //             //                         break;
    //             //                 }
    //             //             }
    //             //         }
    //             //         break;
    //             //     case 'update':
    //             //         $u_id               = $request->u_id;
    //             //         $rules         = [
    //             //             'u_jenis_analisis_'.$u_id.''    => 'required|string|min:1',
    //             //             'u_harga_'.$u_id.''             => 'required|numeric|min:10000',
    //             //             'u_id_jenis_sampels_'.$u_id.''  => 'required'                   
    //             //         ];
    //             //         $messages      = [
    //             //             'u_jenis_analisis_'.$u_id.'.required'   => 'PARAMETER WAJIB DIISI',
    //             //             'u_jenis_analisis_'.$u_id.'.string'     => 'WAJIB DIISI DENGAN HURUF',
    //             //             'u_jenis_analisis_'.$u_id.'.min'        => 'PARAMETER WAJIB DIISI MINIMAL 1 KARAKTER',
    //             //             'u_harga_'.$u_id.'.required'            => 'HARGA WAJIB DIISI',
    //             //             'u_harga_'.$u_id.'.numeric'             => 'HARGA WAJIB DIISI DENGAN ANGKA',
    //             //             'u_harga_'.$u_id.'.min'                 => 'MINIMAL HARGA ADALAH Rp. 10.000',
    //             //             'u_id_jenis_sampels_'.$u_id.''          => 'JENIS SAMPEL WAJIB DIISI'                 
    //             //         ]; 

    //             //         # PARAMETER
    //             //         $parameter              = 'u_jenis_analisis_'.$u_id;
    //             //         $u_parameter            = $request->$parameter;

    //             //         # HARGA
    //             //         $harga                  = 'u_harga_'.$u_id;
    //             //         $u_harga                = str_replace('.', '', $request->$harga);
    //             //         echo $u_harga;

    //             //         # JENIS SAMPEL
    //             //         $jenis_sampel           = 'u_id_jenis_sampels_'.$u_id;
    //             //         $u_jenis_sampel         = $request->$jenis_sampel;

    //             //         $reqAll = [
    //             //             'u_jenis_analisis_'.$u_id.''        => $u_parameter,
    //             //             'u_harga_'.$u_id.''                 => $u_harga,
    //             //             'u_id_jenis_sampels_'.$u_id.''      => $u_jenis_sampel
    //             //         ];


    //             //         $validator = Validator::make($reqAll, $rules, $messages);

    //             //         if ($validator->fails()) {
    //             //             return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error_update', 'Gagal');
    //             //         }
    //             //         else{

    //             //             try {
    //             //                 Parameter::where('id', $u_id)
    //             //                     ->update([
    //             //                         'parameter'             => $reqAll['u_jenis_analisis_'.$u_id.''],
    //             //                         'harga'                 => $reqAll['u_harga_'.$u_id.''],
    //             //                         'id_jenis_sampel'       => $reqAll['u_id_jenis_sampels_'.$u_id.'']
    //             //                     ]);
    //             //                 return redirect()->back()->with('update', 'BEHASIL MENGUPDATE DATA');
    //             //             } catch (Exception $e) {
    //             //                 switch ($e->getMessage()) {
    //             //                     case strpos($e->getMessage(), '1062') == TRUE:
    //             //                         return redirect()->back()->with('update', 'EMAIL TELAH DIGUNAKAN');
    //             //                         break;
                                    
    //             //                     default:
    //             //                         return redirect()->back()->with('update', $e->getMessage());
    //             //                         break;
    //             //                 }
    //             //             }

    //             //         }

    //             //         break;
    //             //     case 'delete':
    //             //         $parameter = Parameter::find($request->u_id);
    //             //         try {
    //             //             $parameter->delete();
    //             //             return redirect()->back()->with('delete', 'DATA BERHASIL DIHAPUS');
    //             //         } catch (Exception $e) {
    //             //             return redirect()->back()->with('delete', $e->getMessage());
    //             //         }
    //             //         break;
    //             //     default:
    //             //         # code...
    //             //         break;
    //             // }
    //         #C

    //     }
    //     # CRUD PARAMETER    

    //     # PAGE INPUT SAMPEL  
    //     public function InputSampel()
    //     {  
    //         #C
    //             // $pelanggan      = Pelanggan::all();
    //             // $parameter      = Parameter::select('parameters')
    //             // ->join('jenis_sampels', 'parameters.id_jenis_sampel', '=', 'jenis_sampels.id')
    //             // ->select('parameters.*', 'jenis_sampels.jenis_sampel as jenis_sampel')
    //             // ->get();
    //             // $jenis_sampel   = JenisSampel::all();
                
    //             // $data_sampel    = DataSampel::select('data_sampels')
    //             //     ->join('pelanggans', 'data_sampels.id_pelanggan', '=', 'pelanggans.id')
    //             //     ->join('jenis_sampels', 'data_sampels.id_jenis_sampel', '=', 'jenis_sampels.id')
    //             //     ->select('data_sampels.*', 'pelanggans.nama as pelanggan_nama', 'pelanggans.perusahaan as pelanggan_perusahaan', 'jenis_sampels.jenis_sampel as jenis_sampel')
    //             //     ->get();

    //             // return view('admin.sampel.data_sampel', ['pelanggan' => $pelanggan, 'parameter' => $parameter, 'data_sampel' => $data_sampel, 'jenis_sampel' => $jenis_sampel]);
    //         #C
    //     }
    //     # PAGE INPUT SAMPEL

    //     # CRUD INPUT SAMPEL
    //     public function CrudInputSampel(Request $request)
    //     {   
    //         #C
    //             // $status     =  $request->action;
    //             // switch ($status) {
    //             //     case 'add':
    //             //         $rules      = [
    //             //             'tanggal_masuk'             => 'required|date|after:today',
    //             //             'target_selesai'            => 'required|numeric|min:1',
    //             //             'nomor_surat'               => 'required',
    //             //             'pelanggan_id'              => 'required',
    //             //             'jenis_sampel'              => 'required',
    //             //             'parameter'                 => 'required',
    //             //             'jumlah_sampel'             => 'required|numeric'
    //             //         ];

    //             //         $messages   = [
    //             //             'tanggal_masuk.required'    => 'TANGGAL MASUK WAJIB DIISI',
    //             //             'tanggal_masuk.after'       => 'TANGGAL MINIMIAL HARI INI',
    //             //             'tanggal_masuk.date'        => 'FORMAT TANGGAL SALAH',
    //             //             'target_selesai.required'   => 'TARGET SELESAI WAJIB DIISI',
    //             //             'target_selesai.numeric'    => 'TARGET SELESAI WAJIB DIISI DENGAN ANGKA',
    //             //             'nomor_surat.required'      => 'NOMOR SURAT WAJIB DIISI',
    //             //             'pelanggan_id.required'     => 'PELANGGAN WAJIB DIISI',
    //             //             'jenis_sampel.required'     => 'JENIS SAMPEL WAJIB DIISI',
    //             //             'parameter.required'        => 'PARAMETER WAJIB DIISI',
    //             //             'jumlah_sampel.required'    => 'JUMLAH SAMPEL DIISI',
    //             //             'jumlah_sampel.numeric'     => 'JUMLAH SAMPEL WAJIB DIISI DENGAN ANGKA'
    //             //         ];

    //             //         $validator = Validator::make($request->all(), $rules, $messages);

    //             //         if ($validator->fails()) {
    //             //             return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error_insert', 'Gagal');
    //             //         }
    //             //         else{
    //             //             $t_data_sampels                     = new DataSampel;

    //             //             #ID PARAMETER
    //             //             $parameter                          = implode('-', $request->parameter);
    //             //             $t_data_sampels->id_parameter       = $parameter;  
    //             //             #ID PELANGGAN                  
    //             //             $t_data_sampels->id_pelanggan       = $request->pelanggan_id;
    //             //             #TANGGAL MASUK
    //             //             $tanggal                            = strtotime($request->tanggal_masuk);
    //             //             $i_tanggal                          = date('Y-m-d H:i', $tanggal);     
    //             //             $t_data_sampels->tanggal_masuk      = $i_tanggal;
    //             //             #TANGGAL SELESAI
    //             //             $t_data_sampels->tanggal_selesai    = $request->target_selesai;
    //             //             #NOMOR SURAT
    //             //             $t_data_sampels->nomor_surat        = $request->nomor_surat;
    //             //             #PERUSAHAAN
    //             //             $pelanggan_id                       = $request->pelanggan_id;
    //             //             $pelanggan                          = Pelanggan::select('pelanggans')->select('pelanggans.*')->where('id', '=', $pelanggan_id)->get();
    //             //             foreach ($pelanggan as $pelanggans) {
    //             //                 $t_data_sampels->perusahaan     = $pelanggans->perusahaan;
    //             //             }
    //             //             #JENIS SAMPEL
    //             //             $t_data_sampels->id_jenis_sampel    = $request->jenis_sampel;
    //             //             #JENIS SAMPEL
    //             //             $t_data_sampels->jumlah_sampel      = $request->jumlah_sampel;
    //             //             #STATUS
    //             //             $t_data_sampels->status             = "";

    //             //             try {
    //             //                 $t_data_sampels->save();

    //             //                 $last_ = HasilAnalisa::where('id_jenis_sampel', $t_data_sampels->id_jenis_sampel)->orderByDesc('no_lab')->take(1)->get();
    //             //                 $n          = 0;
    //             //                 $t          = date('y', strtotime($t_data_sampels->tanggal_masuk));
    //             //                 $status_save = 0;
    //             //                 if(count($last_) == 0)
    //             //                 {
    //             //                     $n = $t_data_sampels->jumlah_sampel;
    //             //                     for($i = 1; $i <= $n; $i++)
    //             //                     {
    //             //                         try {
    //             //                             DB::table('hasil_analisas')->insert([
    //             //                                 'id_kupa'          => $t_data_sampels->id,
    //             //                                 'tahun'            => strval($t),
    //             //                                 'id_jenis_sampel'  => $t_data_sampels->id_jenis_sampel,
    //             //                                 'no_lab'           => $i,
    //             //                                 'N'                => 0,
    //             //                                 'P'                => 0,
    //             //                                 'K'                => 0,
    //             //                                 'Mg'               => 0,
    //             //                                 'Ca'               => 0,
    //             //                                 'B'                => 0,
    //             //                                 'Cu'               => 0,
    //             //                                 'Zn'               => 0,
    //             //                                 'Fe'               => 0,
    //             //                                 'Mn'               => 0,
    //             //                                 'status'           => '0',
    //             //                                 'retry'            => 0
    //             //                             ]);
    //             //                             $status_save = 1;
    //             //                         } catch (Exception $e) {
    //             //                             return redirect()->back()->with('insert', $e->getMessage());                                
    //             //                         }
    //             //                     }
    //             //                 }
    //             //                 else
    //             //                 {   
    //             //                     $last_      = json_decode(json_encode($last_), true);
    //             //                     $no_lab     = 0;
    //             //                     foreach ($last_ as $key => $value) {
    //             //                         $no_lab = $value['no_lab'];
    //             //                     }
    //             //                     $n = $no_lab + $t_data_sampels->jumlah_sampel;
    //             //                     $index = (int)$no_lab + 1;
    //             //                     for($i = $index; $i <= $n; $i++)
    //             //                     {
    //             //                         try {
    //             //                             DB::table('hasil_analisas')->insert([
    //             //                                 'id_kupa'          => $t_data_sampels->id,
    //             //                                 'tahun'            => strval($t),
    //             //                                 'id_jenis_sampel'  => $t_data_sampels->id_jenis_sampel,
    //             //                                 'no_lab'           => $i,
    //             //                                 'N'                => 0,
    //             //                                 'P'                => 0,
    //             //                                 'K'                => 0,
    //             //                                 'Mg'               => 0,
    //             //                                 'Ca'               => 0,
    //             //                                 'B'                => 0,
    //             //                                 'Cu'               => 0,
    //             //                                 'Zn'               => 0,
    //             //                                 'Fe'               => 0,
    //             //                                 'Mn'               => 0,
    //             //                                 'status'           => '0',
    //             //                                 'retry'            => 0
    //             //                             ]);
    //             //                             $status_save = 1;
    //             //                         } catch (Exception $e) {
    //             //                             return redirect()->back()->with('insert', $e->getMessage());                                
    //             //                         }
    //             //                     }
    //             //                 }

    //             //                 if($status_save == 1)
    //             //                 {
    //             //                     return redirect('admin/hasilanalisis/'.$t_data_sampels->id.'');
    //             //                 }
    //             //             } catch (Exception $e) {
    //             //                 switch ($e->getMessage()) {
    //             //                     case strpos($e->getMessage(), '1062') == TRUE:
    //             //                         return redirect()->back()->with('insert', 'TIDAK DAPAT MEMASUKAN PARAMETER YANG SAMA');
    //             //                         break;                            
    //             //                     default:
    //             //                         return redirect()->back()->with('insert', $e->getMessage());
    //             //                         break;
    //             //                 }
    //             //             }

    //             //         }

    //             //         break;
                    
    //             //     default:
    //             //         # code...
    //             //         break;
    //             // }
    //         #C
    //     }
    //     # CRUD INPUT SAMPEL

    //     # PAGES HASIL ANALISA
    //     function HasilAnalisis($id_kupa = null)
    //     {
    //         $kupa = '';
    //         if(isset($id_kupa))
    //         {
    //             $kupa = $id_kupa;
    //         }

    //         $parameter      = Parameter::select('parameters')
    //         ->join('jenis_sampels', 'parameters.id_jenis_sampel', '=', 'jenis_sampels.id')
    //         ->select('parameters.*', 'jenis_sampels.jenis_sampel as jenis_sampel')
    //         ->get();


    //         $data_sampel    = DataSampel::select('data_sampels')
    //             ->join('pelanggans', 'data_sampels.id_pelanggan', '=', 'pelanggans.id')
    //             ->join('jenis_sampels', 'data_sampels.id_jenis_sampel', '=', 'jenis_sampels.id')
    //             ->select('data_sampels.*', 'pelanggans.nama as pelanggan_nama', 'pelanggans.perusahaan as pelanggan_perusahaan', 'jenis_sampels.jenis_sampel as jenis_sampel')
    //             ->where('data_sampels.id', $id_kupa)
    //             ->get();


    //         $hasil_analisis = DB::table('hasil_analisas')
    //         ->join('jenis_sampels', 'hasil_analisas.id_jenis_sampel', '=', 'jenis_sampels.id')
    //         ->select('hasil_analisas.*', 'jenis_sampels.lambang_sampel as simbol')
    //         ->where('id_kupa', $id_kupa)->get();
    //         return view('admin.sampel.hasil_analisis', ['hasil_analisis' => $hasil_analisis, 'kupa'=> $kupa, 'data_sampel' => $data_sampel, 'parameter' => $parameter]);
    //     }
    //     # PAGES HASIL ANALISA

    //     #CRUD HASIL ANALISA
    //     function CrudHasilAnalisis(Request $request)
    //     {
    //         $status_update  = 0;
    //         $id_analisis    = array();
    //         $d_analisis     = HasilAnalisa::where('id_kupa', $request->id_kupa)->get();
    //         foreach($d_analisis as $analisis)
    //         {
    //             array_push($id_analisis, $analisis->id);
    //         }

    //         try {
    //             for($i = 0; $i < count($id_analisis); $i++)
    //             {
    //                 HasilAnalisa::where('id', $id_analisis[$i])
    //                 ->update([
    //                     'kode_contoh'             => $request->get('kode_contoh')[$i]
    //                 ]);
    //             }
    //             $status_update = 1;
    //         } catch (Exception $e) {
    //             return redirect()->back()->with('update', $e->getMessage());
    //         }

    //         if($status_update == 1)
    //         {
    //             return redirect()->back()->with('update', 'BERHASIL UPDATE DATA');
    //         }
    //     }
    //     #CRUD HASIL ANALISA

    //     #PAGES TRACKING
    //     function Tracking($id_kupa = null)
    //     {
    //         $kupa = '';
    //         if(isset($id_kupa))
    //         {
    //             $kupa = $id_kupa;
    //         }
    //         elseif(!isset($id_kupa))
    //         {
    //             return redirect()->back()->with('tracking_error', 'ID KUPA KOSONG');
    //         }
    //         $dtracking = DB::table('detail_trackings')
    //         ->join('tabel_aktivitas', 'detail_trackings.aktivitas_id', '=', 'tabel_aktivitas.id')
    //         ->join('lab_akuns', 'detail_trackings.petugas_id', '=', 'lab_akuns.id')
    //         ->select('detail_trackings.aktivitas_waktu as waktu', 'tabel_aktivitas.aktivitas as aktivitas', 'lab_akuns.nama as petugas', 'lab_akuns.jabatan as jabatan')
    //         ->where('kupa_id', $kupa)->get();

    //         return view('admin.tracking.tracking')->with('tracking', $dtracking);

    //     }
    //     #PAGES TRACKING



    //     #DEKRIPT
    //     function Dekrip()
    //     {
    //         error_reporting(0);
    //         $cipher = "aes-256-cbc"; 

    //         //Generate a 256-bit encryption key 
    //         $encryption_key = 'S1d3w1nd3rZ0N3SMART%%%L@B2k22*#*'; 

    //         //Data to encrypt 
    //         $data = "1"; 
    //         $encrypted_data = openssl_encrypt($data, $cipher, $encryption_key, 0, ''); 

    //         echo "Encrypted Text: " . $encrypted_data.'<br>'; 

    //         $decrypted_data = openssl_decrypt($encrypted_data, $cipher, $encryption_key, 0, ''); 

    //         echo "Decrypted Text: " . $decrypted_data.'<br>';
    //     }
    //     #DEKSRIP
    #KOMEN
}
