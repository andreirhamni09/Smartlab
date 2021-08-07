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
                            <div class="col-md-11" style="margin-left: auto; margin-right: auto;">
                                <form action="{{ url('admin/crud_akunlab') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input type="email" name="email" class="form-control" placeholder="E-mail ..." autofocus>
                                                @if(session('error_insert'))
                                                @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
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
                                        <div class="col-sm-2">
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
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Jabatan</label>
                                                <input type="text" name="jabatan" class="form-control" placeholder="Jabatan ...">
                                                @if(session('error_insert'))
                                                @if ($errors->has('jabatan'))
                                                <span class="text-danger">{{ $errors->first('jabatan') }}</span>
                                                @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Level Akses</label>
                                                
                                                @if(count($akseslevel) <= 0)
                                                <a class="form-control btn btn-success" href="{{ url('admin/akseslevel') }}">Add Akses Level</a>                                                
                                                @else
                                                <Select class="form-control" name="id_akses">
                                                    <option selected disabled>--Pilih Level Akses--</option>
                                                        @foreach($akseslevel as $aklevel)
                                                        <option value="{{ $aklevel->id }}">{{ strtoupper($aklevel->jabatan) }}</option>
                                                        @endforeach
                                                </Select>                                                
                                                @endif

                                                @if(session('error_insert'))
                                                    @if ($errors->has('id_akses'))
                                                    <span class="text-danger">{{ $errors->first('id_akses') }}</span>
                                                    @endif
                                                @endif
                                                
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Submit</label>
                                                <button name="action" value="add" class="form-control btn btn-primary">TAMBAHKAN</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @if(session('insert'))
                                    @if(session('insert') == 'BEHASIL MEMASUKAN DATA')
                                        <span class="text-success">{{ session('insert') }}</span>
                                    @else
                                        <span class="text-danger">{{ session('insert') }}</span>
                                    @endif
                                @elseif(session('update'))
                                    @if(session('update') == 'BEHASIL MENGUPDATE DATA')
                                        <span class="text-success">{{ session('update') }}</span>
                                    @else
                                        <span class="text-danger">{{ session('update') }}</span>
                                    @endif
                                @elseif(session('delete'))
                                    @if(session('delete') == 'DATA BERHASIL DIHAPUS')
                                        <span class="text-success">{{ session('delete') }}</span>
                                    @else
                                        <span class="text-danger">{{ session('delete') }}</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        


                        <div class="card-body table-responsive">
                            <div class="col-md-12" style="margin-left: auto; margin-right: auto;">

                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th class="hijau">NO</th>
                                            <th class="biru">EMAIL</th>
                                            <th class="biru">NAMA</th>
                                            <th class="biru">JABATAN</th>
                                            <th class="biru" style="width: 11.5%;">AKSES LEVEL</th>
                                            <th class="biru">PASSWORD</th>
                                            <th class="biru" style="width: 13.5%;">STATUS AKUN</th>
                                            <th class="biru">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- UPDATE DATA USER LAB -->
                                        <?php $no = 1; ?>
                                        @if(count($labakun) == 0)
                                        <tr>
                                            <td colspan="8">BELUM ADA USERLAB YANG DIINPUTKAN</td>
                                        </tr>
                                        @else
                                            @foreach($labakun as $lAkun)
                                            <form action="{{ url('admin/crud_akunlab') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="u_idakunlab" value="{{ $lAkun->id }}">
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <input class="form-control" type="email" name="u_email_{{ $lAkun->id }}" value="{{ $lAkun->email }}">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="u_nama_{{ $lAkun->id }}" value="{{ $lAkun->nama }}">
                                                        @if(session('error_update'))
                                                            @if ($errors->has('u_nama_'.$lAkun->id.''))
                                                            <span class="text-danger">{{ $errors->first('u_nama_'.$lAkun->id.'') }}</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td><input class="form-control" type="text" name="u_jabatan_{{ $lAkun->id }}" value="{{ $lAkun->jabatan }}"></td>
                                                    <td>
                                                        <Select class="form-control" name="u_id_akses_{{ $lAkun->id }}">
                                                            <option selected disabled>-- {{  strtoupper($lAkun->nama_jabatan) }} --</option>
                                                            @foreach($akseslevel as $aklevel)
                                                            <option value="{{ $aklevel->id }}">{{ strtoupper($aklevel->jabatan) }}</option>
                                                            @endforeach
                                                        </Select>
                                                        @if(session('error_update'))
                                                            @if ($errors->has('u_id_akses_'.$lAkun->id.''))
                                                            <span class="text-danger">{{ $errors->first('u_id_akses_'.$lAkun->id.'') }}</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <input class="form-control" id="u_hidden_password_{{ $no }}" type="password" name="u_password_{{ $lAkun->id }}" value="{{ $lAkun->password }}" placeholder="{{ $lAkun->password }}">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button class="btn btn-secondary" id="lihat_{{ $no }}" type="button"><abbr title="Lihat Password"><i class="far fa-eye"></i></abbr></button>
                                                            </div>
                                                        </div>                                                    
                                                        @if(session('error_update'))
                                                            <span class="text-danger">{{ $errors->first('u_password_'.$lAkun->id.'') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <Select class="form-control" name="u_status_akun_{{ $lAkun->id }}">
                                                            @if($lAkun->status_akun == 0)
                                                            <option selected disabled>-- NONAKTIF --</option>
                                                            @else
                                                            <option selected disabled>-- AKTIF --</option>
                                                            @endif
                                                            <option value="0">NONAKTIF</option>
                                                            <option value="1">AKTIF</option>
                                                        </Select>
                                                        @if(session('error_update'))
                                                            @if ($errors->has('u_status_akun_'.$lAkun->id.''))
                                                            <span class="text-danger">{{ $errors->first('u_status_akun_'.$lAkun->id.'') }}</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="row" style="margin-left: auto; margin-right:auto;">
                                                            <div class="col-md-6">
                                                                <button class="btn btn-success" name="action" value="update"><abbr title="UPDATE"><i class="fas fa-redo"></i></abbr></button>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button class="btn btn-danger" name="action" value="delete"><abbr title="DELETE"><i class="fas fa-trash"></i></abbr></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </form>
                                            <?php $no += 1;?>
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