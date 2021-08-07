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
                            <div class="col-md-6" style="margin-left: auto; margin-right: auto;">
                                <form action="{{ url('admin/crud_akseslevel') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Akses Level</label>
                                                <input type="number" name="id" class="form-control" placeholder="Akses Level ...">
                                                @if(session('error_insert'))
                                                    @if ($errors->has('id'))
                                                        <span class="text-danger">{{ $errors->first('id') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Nama Jabatan</label>
                                                <input type="text" name="jabatan" class="form-control" placeholder="Masukan Nama Jabatan ...">
                                                @if(session('error_insert'))
                                                    @if ($errors->has('jabatan'))
                                                        <span class="text-danger">{{ $errors->first('jabatan') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Submit</label>
                                                <button class="form-control btn btn-primary" name="action" value="add"><abbr title="Tambahkan Akses Level"><i class="fas fa-plus-square"></i></abbr></button>
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
                            <div class="col-md-6" style="margin-left: auto; margin-right: auto;">

                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th class="hijau">NO</th>
                                            <th class="biru">AKSES LEVEL</th>
                                            <th class="biru">NAMA JABATAN</th>
                                            <th class="biru">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($akseslevel as $aklevel)
                                        <form action="{{ url('admin/crud_akseslevel') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="u_id" value="{{ $aklevel->id }}">
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <input value="{{ $aklevel->id }}" name="u_idakseslevel_{{ $aklevel->id }}" type="number" class="form-control text-center" placeholder="Akses Level ...">
                                                    @if(session('error_update'))
                                                        @if ($errors->has('u_idakseslevel_'.$aklevel->id.''))
                                                            <span class="text-danger">{{ $errors->first('u_idakseslevel_'.$aklevel->id.'') }}</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <input value="{{ $aklevel->jabatan }}" name="u_jabatan_{{ $aklevel->id }}" type="text" class="form-control text-center" placeholder="Masukan Nama Jabatan ...">
                                                    @if(session('error_update'))
                                                        @if ($errors->has('u_jabatan_'.$aklevel->id.''))
                                                            <span class="text-danger">{{ $errors->first('u_jabatan_'.$aklevel->id.'') }}</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="row" style="margin-left: auto; margin-right:auto;">
                                                        <div class="col-md-5">
                                                            <button class="btn btn-success" name="action" value="update"><abbr title="UPDATE"><i class="fas fa-redo"></i></abbr></button>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <button class="btn btn-danger" name="action" value="delete"><abbr title="DELETE"><i class="fas fa-trash"></i></abbr></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </form>
                                        @endforeach
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