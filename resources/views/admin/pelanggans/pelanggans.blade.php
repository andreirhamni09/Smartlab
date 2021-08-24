@include('admin.layout.header')

<style>
    .hijau {
        background-color: #00621A;
        color: white;
    }

    .biru {
        background-color: #001494;
        color: white;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="content-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 pl-2 text-success">
                    </h1>
                </div>
            </div>

        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="text-success"><strong>DAFTAR USER LAB</strong></h3>
                        </div>

                        <div class="card-body table-responsive">
                            <div style="width:150%;margin-left: auto;">
                                <form action="{{ url('admin/insertpelanggans') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input type="email" name="email" class="form-control" placeholder="E-mail ...">
                                                @if(session('error_insert'))
                                                    @if ($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="Password ...">
                                                @if(session('error_insert'))
                                                    @if ($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input type="text" name="nama" class="form-control" placeholder="Nama ...">
                                                @if(session('error_insert'))
                                                @if ($errors->has('nama'))
                                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                                                @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Perusahaan</label>
                                                <input type="text" name="perusahaan" class="form-control" placeholder="Perusahaan ...">
                                                @if(session('error_insert'))
                                                    @if ($errors->has('perusahaan'))
                                                    <span class="text-danger">{{ $errors->first('perusahaan') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>No. Telepon</label>
                                                <input type="text" name="nomor_telepon" class="form-control" placeholder="No. Telepon ...">
                                                @if(session('error_insert'))
                                                    @if ($errors->has('nomor_telepon'))
                                                    <span class="text-danger">{{ $errors->first('nomor_telepon') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <input type="text" name="alamat" class="form-control" placeholder="Alamat ...">
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Tanggal</label>
                                                <input type="date" name="tanggal_registrasi" class="form-control" value="">
                                                @if(session('error_insert'))
                                                    @if ($errors->has('tanggal'))
                                                    <span class="text-danger">{{ $errors->first('tanggal') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="form-group">
                                                <label>Submit</label>
                                                <input type="submit" class="form-control btn btn-primary" value="TAMBAHKAN">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @if(session('insert'))
                                    <script>
                                        alert("{{ session('insert') }}");
                                    </script>
                                @elseif(session('update'))
                                    <script>
                                        alert("{{ session('update') }}");
                                    </script>
                                @elseif(session('delete'))
                                    <script>
                                        alert("{{ session('delete') }}");
                                    </script>
                                @endif
                            </div>
                        </div>                    


                        <div class="card-body table-responsive">
                            <div style="width:120%; margin-left: auto; margin-right: auto;">
                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th class="hijau">NO</th>
                                            <th class="biru" style="width: 15%;">EMAIL</th>
                                            <th class="biru" style="width: 15%;">PASSWORD</th>
                                            <th class="biru" style="width: 15%;">NAMA</th>
                                            <th class="biru">PERUSAHAAN</th>
                                            <th class="biru" style="width: 12%;">NO. TELEPON</th>
                                            <th class="biru" style="width: 15%;">ALAMAT</th>
                                            <th class="biru">TANGGAL REGISTRASI</th>
                                            <th class="biru" style="width: 15%;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- UPDATE DATA USER LAB -->
                                        @if(empty($pelanggans))
                                            <tr>
                                                <td colspan="9">BELUM ADA PELANGGAN YANG DIINSERTKAN</td>
                                            </tr>
                                        @else
                                            <?php
                                                $arr_pelanggan_id                   = explode('-', $pelanggans['id']);
                                                $arr_pelanggan_email                = explode('-', $pelanggans['email']);
                                                $arr_pelanggan_password             = explode('-', $pelanggans['password']);
                                                $arr_pelanggan_nama                 = explode('-', $pelanggans['nama']);
                                                $arr_pelanggan_perusahaan           = explode('-', $pelanggans['perusahaan']);
                                                $arr_pelanggan_nomor_telepon        = explode('-', $pelanggans['nomor_telepon']);
                                                $arr_pelanggan_alamat               = explode('-', $pelanggans['alamat']);
                                                $arr_pelanggan_tanggal_registrasi   = explode('-', $pelanggans['tanggal_registrasi']);
                                                $no_pelanggan                       = 1;
                                            ?>
                                            @for($i = 0; $i < count($arr_pelanggan_id); $i++)
                                                <form action="{{ url('admin/updatepelanggans') }}" method="POST">
                                                {{ csrf_field() }}
                                                    <tr>
                                                        <input type="hidden" name="id" value="{{ $arr_pelanggan_id[$i] }}">
                                                        <td>{{ $no_pelanggan }}</td>
                                                        <td><input type="text" class="form-control" name="email" value="{{ $arr_pelanggan_email[$i] }}"></td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <input type="password" name="password" id="u_hidden_password_{{$no_pelanggan}}" class="form-control" value="{{ $arr_pelanggan_password[$i] }}">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <button class="btn btn-secondary" id="lihat_{{ $no_pelanggan }}" type="button"><abbr title="Lihat Password"><i class="far fa-eye"></i></abbr></button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nama" class="form-control" value="{{ $arr_pelanggan_nama[$i] }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="perusahaan" class="form-control" value="{{ $arr_pelanggan_perusahaan[$i] }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nomor_telepon" class="form-control" value="{{ $arr_pelanggan_nomor_telepon[$i] }}">    
                                                        </td>
                                                        <td>
                                                            <input type="text" name="alamat" class="form-control" value="{{ $arr_pelanggan_alamat[$i] }}">
                                                        </td>
                                                        <td>
                                                            <?php
                                                                $tanggal        = strtotime(str_replace('/', '-', $arr_pelanggan_tanggal_registrasi[$i]));
                                                                $f_tanggal      = date('Y-m-d', $tanggal);
                                                            ?>
                                                            <input type="date" name="tanggal_registrasi" class="form-control" value="{{ $f_tanggal }}">
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn btn-success">UPDATE</button>
                                                            <a href="deletepelanggans/{{$arr_pelanggan_id[$i]}}" class="btn btn-danger">DELETE</a>
                                                        </td>
                                                    </tr>
                                                </form>

                                                <?php
                                                  $no_pelanggan++;  
                                                ?>
                                            @endfor
                                        @endif
                                        <!-- UPDATE DATA USER LAB -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script src="{{ asset('public/js/js_tabel/jquery-3.5.1.js') }}"></script>
<script> 
    $(document).ready(function(){        
        var no      = <?= $no_pelanggan ?>; 
        for (let i = 1; i < no; i++) 
        {                                                      
            $('#lihat_'+i+'').click(function(){      
                
                var tipe = $('#u_hidden_password_'+i+'').attr('type');
                if(tipe == 'password')
                {
                    $('#u_hidden_password_'+i+'').attr('type', 'text');
                }
                else{
                    $('#u_hidden_password_'+i+'').attr('type', 'password');
                }
            });
        }
    });
</script>

@include('admin.layout.footer')