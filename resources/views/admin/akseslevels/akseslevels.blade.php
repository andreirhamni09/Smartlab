@include('admin.layout.header')

@if(session('status'))
@if(session('status') == 'gagal')
<script>
    alert('mantap');
</script>
@endif
@endif

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
                            <h3 class="text-success"><strong>DAFTAR AKSES LEVEL</strong></h3>
                        </div>

                        <div class="card-body table-responsive">
                            <div class="col-md-10" style="margin-left: auto; margin-right: auto;">
                                <form action="{{ url('admin/insertakseslevels') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Akses Level</label>
                                                <input type="number" name="id" class="form-control" placeholder="Akses Level ..." required>
                                                @if(session('error_insert'))
                                                    @if ($errors->has('id'))
                                                        <span class="text-danger">{{ $errors->first('id') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Nama Jabatan</label>
                                                <input type="text" name="jabatan" class="form-control" placeholder="Masukan Nama Jabatan ..." required>
                                                @if(session('error_insert'))
                                                    @if ($errors->has('jabatan'))
                                                        <span class="text-danger">{{ $errors->first('jabatan') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Halaman Id</label>
                                                <input type="text" name="halamans_id_s" class="form-control" placeholder="Masukan Daftar Halaman Id ..." required>
                                                @if(session('error_insert'))
                                                    @if ($errors->has('jabatan'))
                                                        <span class="text-danger">{{ $errors->first('jabatan') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="form-group">
                                                <label style="color: white;">SSS</label>
                                                <button class="form-control btn btn-primary" name="action" value="add"><abbr title="Tambahkan Akses Level"><i class="fas fa-plus-square btn-primary"></i></abbr></button>
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
                            <div class="col-md-10" style="margin-left: auto; margin-right: auto;">

                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th class="hijau">NO</th>
                                            <th class="biru">AKSES LEVEL</th>
                                            <th class="biru">NAMA JABATAN</th>
                                            <th class="biru">DAFTAR AKSES HALAMAN</th>
                                            <th class="biru">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(empty($akseslevels))
                                            <tr>
                                                <td class="hijau" colspan="5">DATA MASIH KOSONG</td>
                                            </tr>
                                        @else
                                            <?php
                                                $arr_level_akses_id             = explode('-', $akseslevels['id']);
                                                $arr_level_akses_jabatan        = explode('-', $akseslevels['jabatan']);
                                                $arr_level_akses_halamans_id_s  = explode(';', $akseslevels['halamans_id_s']);
                                                $no = 1;
                                            ?>
                                            @for($i = 0; $i < count($arr_level_akses_id); $i++)
                                            <form action="{{ url('admin/updateakseslevels')}}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $arr_level_akses_id[$i] }}">
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td><input required type="number" name="u_id" value="{{ $arr_level_akses_id[$i] }}" class="form-control" placeholder="Akses Level Id ..."></td>
                                                    <td><input required type="text" name="u_jabatan" value="{{ $arr_level_akses_jabatan[$i] }}" class="form-control" placeholder="Update Jabatan ..."></td>
                                                    <td>    
                                                        <input required type="text" name="u_halamans_id_s" value="{{ $arr_level_akses_halamans_id_s[$i] }}" class="form-control" placeholder="Halaman Id ...">
                                                    </td>
                                                    <td>
                                                        <button type="submit" class="btn btn-success">UPDATE</button>
                                                        <a href="deleteakseslevels/{{$arr_level_akses_id[$i]}}" type="submit" class="btn btn-danger">DELETE</a>
                                                    </td>
                                                </tr>
                                            </form>
                                            <?php $no++; ?>
                                            @endfor
                                        @endif
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


@include('admin.layout.footer')