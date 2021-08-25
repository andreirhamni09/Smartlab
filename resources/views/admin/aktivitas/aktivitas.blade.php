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
                            <h3 class="text-success"><strong>DAFTAR AKTIVITAS</strong></h3>
                        </div>

                        <div class="card-body table-responsive">
                            <div style="width:50%; margin-left: auto; margin-right: auto;">
                                <form action="{{ url('admin/insertaktivitas') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Aktivitas</label>
                                                <input type="text" name="aktivitas" class="form-control" placeholder="Aktivitas ...">
                                            </div>
                                        </div>
                                        <div class="col-sm">
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
                            <div style="width:50%; margin-left: auto; margin-right: auto;">
                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th class="hijau">NO</th>
                                            <th class="biru">AKTIVITAS</th>
                                            <th class="biru">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- UPDATE DATA USER LAB -->
                                        @if(empty($aktivitas))
                                            <tr>
                                                <td colspan="9">BELUM ADA PELANGGAN YANG DIINSERTKAN</td>
                                            </tr>
                                        @else
                                            <?php
                                                $arr_aktivitas_id       = explode('-', $aktivitas['id']);
                                                $arr_aktivitas_akt      = explode('-', $aktivitas['aktivitas']);
                                                $no_aktivitas           = 1;
                                            ?>
                                            @for($i = 0; $i < count($arr_aktivitas_id); $i++)
                                                <form action="{{ url('admin/updateaktivitas') }}" method="POST">
                                                {{ csrf_field() }}
                                                    <tr>
                                                        <input type="hidden" name="id" value="{{ $arr_aktivitas_id[$i] }}">
                                                        <td>{{ $no_aktivitas }}</td>
                                                        <td><input type="text" class="form-control" name="aktivitas" value="{{ $arr_aktivitas_akt[$i] }}"></td>
                                                        
                                                        <td>
                                                            <button type="submit" class="btn btn-success">UPDATE</button>
                                                            <a href="deleteaktivitas/{{$arr_aktivitas_id[$i]}}" class="btn btn-danger">DELETE</a>
                                                        </td>
                                                    </tr>
                                                </form>

                                                <?php
                                                  $no_aktivitas++;  
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
@include('admin.layout.footer')