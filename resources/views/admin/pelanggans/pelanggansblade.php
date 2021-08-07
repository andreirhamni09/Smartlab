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
                                <form action="{{ url('admin/crud_pelanggan') }}" method="POST">
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
                                                <input type="date" name="tanggal" class="form-control" value="">
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
                                                <button name="action" value="add" class="form-control btn btn-primary">TAMBAHKAN</button>
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
                                            <th class="biru" style="width: 18%;">EMAIL</th>
                                            <th class="biru">PASSWORD</th>
                                            <th class="biru">NAMA</th>
                                            <th class="biru">PERUSAHAAN</th>
                                            <th class="biru">NO. TELEPON</th>
                                            <th class="biru">ALAMAT</th>
                                            <th class="biru">TANGGAL REGISTRASI</th>
                                            <th class="biru">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- UPDATE DATA USER LAB -->
                                        <?php $no         = 1; ?>
                                        @if(count($pelanggan) <= 0)
                                            <tr>
                                                <td colspan="9">BELUM ADA PELANGGAN YANG DIINSERTKAN</td>
                                            </tr>
                                        @else
                                            @foreach($pelanggan as $dpelanggan)
                                            <form action="{{ url('admin/crud_pelanggan') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" id="u_idpel_{{$no}}" name="u_idpel" value="{{ $dpelanggan->id }}">
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <input class="form-control" type="email" name="u_email_{{ $dpelanggan->id }}" value="{{ $dpelanggan->email }}">
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-sm-9" id="hide-unhide-{{$no}}">
                                                                <input class="form-control" id="u_hidden_password_{{$no}}" type="password" name="u_password_{{ $dpelanggan->id }}" value="{{ $dpelanggan->password }}" placeholder="{{ $dpelanggan->password }}">
                                                            </div>
                                                            <div class="col-sm-2" id="hide-unhide-btn-{{$no}}">
                                                                <button class="btn btn-secondary" id="lihat_{{ $no }}" value="{{$no}}" type="button"><abbr title="Lihat Password"><i class="far fa-eye"></i></abbr></button>
                                                            </div>
                                                        </div> 
                                                        @if(session('error_update'))
                                                            @if ($errors->has('u_password_'.$dpelanggan->id.''))
                                                            <span class="text-danger">{{ $errors->first('u_password_'.$dpelanggan->id.'') }}</span>                                                            
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="u_nama_{{ $dpelanggan->id }}" value="{{ $dpelanggan->nama }}">
                                                        @if(session('error_update'))
                                                            @if ($errors->has('u_nama_'.$dpelanggan->id.''))
                                                            <span class="text-danger">{{ $errors->first('u_nama_'.$dpelanggan->id.'') }}</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="u_perusahaan_{{ $dpelanggan->id }}" value="{{ $dpelanggan->perusahaan }}">
                                                        @if(session('error_update'))
                                                            @if ($errors->has('u_perusahaan_'.$dpelanggan->id.''))
                                                            <span class="text-danger">{{ $errors->first('u_perusahaan_'.$dpelanggan->id.'') }}</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="u_nomor_telepon_{{ $dpelanggan->id }}" value="{{ $dpelanggan->nomor_telepon }}">
                                                        @if(session('error_update'))
                                                            @if ($errors->has('u_nomor_telepon_'.$dpelanggan->id.''))
                                                            <span class="text-danger">{{ $errors->first('u_nomor_telepon_'.$dpelanggan->id.'') }}</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                    
                                                        <input class="form-control" type="text" name="u_alamat_{{ $dpelanggan->id }}" value="{{ $dpelanggan->alamat }}">
                                                        @if(session('error_update'))
                                                            @if ($errors->has('u_alamat_'.$dpelanggan->id.''))
                                                            <span class="text-danger">{{ $errors->first('u_alamat_'.$dpelanggan->id.'') }}</span>
                                                            @endif
                                                        @endif
                                                    </td>            
                                                    <td>
                                                        <input class="form-control" type="date" name="u_tanggal_registrasi_{{ $dpelanggan->id }}" value="{{ $dpelanggan->tanggal_registrasi }}">
                                                        @if(session('error_update'))
                                                            @if ($errors->has('u_tanggal_registrasi_'.$dpelanggan->id.''))
                                                            <span class="text-danger">{{ $errors->first('u_tanggal_'.$dpelanggan->id.'') }}</span>
                                                            @endif
                                                        @endif
                                                    </td>                                                
                                                    <td>                                                    
                                                        <div class="row" style="margin-left: auto; margin-right:auto;">
                                                            <div class="col-sm-6">
                                                                <button class="btn btn-success" name="action" value="update"><abbr title="UPDATE"><i class="fas fa-redo"></i></abbr></button>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <button class="btn btn-danger" name="action" value="delete"><abbr title="DELETE"><i class="fas fa-trash"></i></abbr></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </form>
                                            <?php $no     += 1; ?>
                                            @endforeach
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
        var no      = <?= $no ?>; 
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