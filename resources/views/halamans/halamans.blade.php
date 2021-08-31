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
                            <div style="width:100%; margin-left: auto; margin-right: auto;">
                                <form action="{{ url('admin/inserthalamans') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Halaman</label>
                                                <input type="text" name="halaman" class="form-control" placeholder="Halaman ..." autofocus>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Url</label>
                                                <input type="text" name="url" class="form-control" placeholder="Url ...">
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Simbol</label>
                                                <input type="text" name="simbol" class="form-control" placeholder="Str Simbol ...">
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Submit</label>
                                                <button type="submit" name="action" value="add" class="form-control btn btn-primary">TAMBAHKAN</button>
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
                            <div style="width:100%; margin-left: auto; margin-right: auto;">

                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th class="hijau">NO</th>
                                            <th class="biru">HALAMAN</th>
                                            <th class="biru">URL</th>
                                            <th class="biru">SIMBOL</th>
                                            <th class="biru" style="width: 15%;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $arr_id      = explode('-', $halamans['id']);
                                            $arr_halaman = explode('-', $halamans['halaman']);
                                            $arr_url     = explode('-', $halamans['url']);
                                            $arr_simbol  = explode(';', $halamans['simbol']);
                                            $no_halaman  = 1;
                                        ?>
                                        @for($i = 0; $i < count($arr_halaman); $i++)
                                        <form action="{{ url('admin/updatehalamans') }}" method="post">
                                            {{ csrf_field() }} 
                                            <tr>
                                                <input type="hidden" name="id" value="{{ $arr_id[$i] }}">
                                                <td>{{ $no_halaman }}</td>
                                                <td><input type="text" name="halaman" class="form-control" value="{{ $arr_halaman[$i] }}"></td>
                                                <td><input type="text" name="url" class="form-control" value="{{ $arr_url[$i] }}"></td>
                                                <td><input type="text" name="simbol" class="form-control" value="{{ $arr_simbol[$i] }}"></td>
                                                <td>
                                                    <button type="submit" class="btn btn-success">UPDATE</button>
                                                    <a href="deletehalamans/{{ $arr_id[$i] }}" class="btn btn-danger">DELETE</button>
                                                </td>
                                            </tr>   
                                        </form>
                                        <?php $no_halaman++; ?>
                                        @endfor
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