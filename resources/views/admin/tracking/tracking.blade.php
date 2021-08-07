@include('admin.layout.header')
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
                            <h3 class="text-success"><strong>TRACKING</strong></h3>
                        </div>
                        
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-hover text-center" style="width: 60%; margin-left: auto; margin-right: auto;">
                                <thead>
                                    <tr>
                                        <th class="hijau">TANGGAL</th>
                                        <th class="biru">AKTIVITAS</th>
                                        <th class="biru">PETUGAS</th>
                                        <th class="biru">JABATAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($tracking_null))
                                        <tr>
                                            <td colspan="4"><h4>{{ $tracking_null }}</h4></td>
                                        </tr>
                                    @elseif(!isset($tracking_null))
                                        @if(count($tracking) == 0)
                                            <tr>
                                                <td colspan="4"><h4>BELUM ADA AKTIVITAS</h4></td>
                                            </tr>
                                        @elseif(count($tracking) !== 0)
                                            @foreach($tracking as $dtracking)
                                                <tr>
                                                    <td>{{ $dtracking->waktu }}</td>
                                                    <td>{{ $dtracking->aktivitas }}</td>
                                                    <td>{{ strtoupper($dtracking->petugas) }}</td>
                                                    <td>{{ strtoupper($dtracking->jabatan) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
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
            @elseif(session('tracking_error'))
                <script>
                    alert("{{ session('tracking_error') }}");
                </script>
            @endif

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


@include('admin.layout.footer')