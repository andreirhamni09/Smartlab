@include('admin.layout.header')
@if(isset($_SESSION['adminlab']))
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
                            <h3 class="text-success"><strong>DAFTAR USER PELANGGAN</strong></h3>
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
                                                <label>NPWP</label>
                                                <input type="text" name="npwp" class="form-control" placeholder="NPWP ...">
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <input type="text" name="alamat" class="form-control" placeholder="Alamat ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="form-group">
                                                <label>Submit</label>
                                                <button type="submit" class="form-control btn btn-primary"><abbr title="TAMBAHKAN"><i class="fas fa-plus"></i></abbr></button>
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
                                            <th class="biru" style="width: 20%;">PASSWORD</th>
                                            <th class="biru" style="width: 15%;">NAMA</th>
                                            <th class="biru">PERUSAHAAN</th>
                                            <th class="biru" style="width: 12%;">NO. TELEPON</th>
                                            <th class="biru" style="width: 15%;">NPWP</th>
                                            <th class="biru" style="width: 15%;">ALAMAT</th>
                                            <th class="biru">TANGGAL REGISTRASI</th>
                                            <th class="biru" style="width: 15%;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- UPDATE DATA USER LAB -->
                                        <?php
                                            $no_pelanggan   = 1;
                                        ?>
                                        @if(empty($pelanggans))
                                            <tr>
                                                <td colspan="9">BELUM ADA PELANGGAN YANG DIINSERTKAN</td>
                                            </tr>
                                        @else
                                            @for($i = 0; $i < count($pelanggans['id']); $i++)
                                                <form action="{{ url('admin/updatepelanggans') }}" method="POST">
                                                {{ csrf_field() }}
                                                    <tr>
                                                        <input type="hidden" name="id" value="{{ $pelanggans['id'][$i] }}">
                                                        <td>{{ $no_pelanggan }}</td>                                                        
                                                        <td><input type="text" class="form-control" name="email" value="{{ $pelanggans['email'][$i] }}"></td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md">
                                                                    <div class="form-group">
                                                                        <input type="password" name="password" id="u_hidden_password_{{$no_pelanggan}}" class="form-control" value="{{ $pelanggans['password'][$i] }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-secondary" id="lihat_{{ $no_pelanggan }}" type="button"><abbr title="Lihat Password"><i class="far fa-eye"></i></abbr></button>
                                                                    </div>
                                                                </div>
                                                            </div>                                                                    
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nama" class="form-control" value="{{ $pelanggans['nama'][$i] }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="perusahaan" class="form-control" value="{{ $pelanggans['perusahaan'][$i] }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nomor_telepon" class="form-control" value="{{ $pelanggans['nomor_telepon'][$i] }}">    
                                                        </td>
                                                        <td>
                                                            <input type="text" name="npwp" class="form-control" value="{{ $pelanggans['npwp'][$i] }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="alamat" class="form-control" value="{{ $pelanggans['alamat'][$i] }}">
                                                        </td>
                                                        <td>
                                                            <?php
                                                                $tanggal        = strtotime(str_replace('/', '-', $pelanggans['tanggal_registrasi'][$i]));
                                                                $f_tanggal      = date('d-M-Y', $tanggal);
                                                            ?>
                                                            {{ $f_tanggal }}
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn btn-success">UPDATE</button>
                                                            <a href="deletepelanggans/{{$pelanggans['id'][$i]}}" class="btn btn-danger">DELETE</a>
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
        if (typeof(<?= $no_pelanggan ?>) != "undefined" && <?= $no_pelanggan ?> !== null) {
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
        }     
    });
</script>
@include('admin.layout.footer')
@else
    @php
        header("Location: " . URL::to('/admin/login?status=Lakukan Login Terlebih Dahulu'), true, 302);
        exit();
    @endphp
@endif