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
                            <h3 class="text-success"><strong>DATA KUPA</strong></h3>
                        </div>
                        
                        <div class="card-body table-responsive">
                            <div style="width:120%; margin-left: auto; margin-right: auto;">
                                <table class="table table-bordered table-hover text-center" style="width: 150%;">
                                    <thead>
                                        <tr>
                                            <th class="biru">NOMOR SURAT</th>
                                            <th class="hijau">TRACKING</th>
                                            <th class="biru">TANGGAL MASUK</th>
                                            <th class="hijau" style="width: 10%;">TANGGAL SELESAI (Hari)</th>
                                            <th class="biru" style="width: 15%;">NAMA PELANGGAN</th>
                                            <th class="hijau">PERUSAHAAN</th>
                                            <th class="biru">JENIS SAMPEL</th>
                                            <th class="hijau">PAKET</th>
                                            <th class="biru">JUMLAH SAMPEL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(empty($datasampels))
                                            <tr>
                                                <td colspan="9">DATA TIDAK DITEMUKAN</td>
                                            </tr>
                                        @else
                                            @for($i = 0; $i < count($datasampels['id']); $i++)
                                                <tr>
                                                    <td>{{ $datasampels['nomor_surat'][$i] }}</td>
                                                    <td><a href="{{ url('admin/tracking/'.$datasampels['id'][$i]) }}" class="btn btn-success">TRACKING</a></td>
                                                    <td>{{ $datasampels['tanggal_masuk'][$i] }}</td>
                                                    <?php
                                                        $tanggal_masuk      = strtotime(str_replace('/', '-', $datasampels['tanggal_masuk'][$i]));
                                                        $v_tanggal_masuk    = date('d-m-Y H:i', $tanggal_masuk); 
                                                        
                                                        $t_selesai          = $datasampels['tanggal_selesai'][$i].' days';

                                                        $date=date_create($v_tanggal_masuk);
                                                        date_add($date, date_interval_create_from_date_string($t_selesai));
                                                        $selesai = date_format($date, "d-m-Y");
                                                    ?>
                                                    <td>{{ $selesai }} ({{ $datasampels['tanggal_selesai'][$i] }} Hari)</td>
                                                    @if(in_array($datasampels['pelanggans_id'][$i], $pelanggans['id']))
                                                        <td>{{ $pelanggans['nama'][array_search($datasampels['pelanggans_id'][$i], $pelanggans['id'])] }}</td>
                                                        <td>{{ $pelanggans['perusahaan'][array_search($datasampels['pelanggans_id'][$i], $pelanggans['id'])] }}</td>
                                                    @endif
                                                    <td>{{ strtoupper($datasampels['jenis_sampel'][$i]) }}</td>
                                                    <td>
                                                    <?php $sampelPakets = '';?>
                                                        @for($j = 0; $j < count($pakets['id']); $j++)
                                                            @if(in_array($pakets['id'][$j], explode('-', $datasampels['pakets_id_s'][$i])))
                                                                <?php $sampelPakets .= $pakets['paket'][$j].'-'; ?>
                                                            @endif
                                                        @endfor
                                                        <?php $sampelPakets = substr($sampelPakets, 0,-1);?>
                                                        {{ $sampelPakets }}
                                                    </td>
                                                    <td>{{ $datasampels['jumlah_sampel'][$i] }} </td>
                                                </tr>
                                            @endfor
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="text-success"><strong>HASIL ANALISA</strong></h3>
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

                        <div class="card-body table-responsive">
                            <div class="col-md-12">
                                <table id="hasil_analisis" style="width:110%;" class="table table-bordered table-hover text-center">
                                    <form action="{{ url('admin/crud_hasilanalisis') }}" method="post">
                                        {{ csrf_field() }}
                                        <thead>
                                            <tr>
                                                <th colspan="4" class="hijau">IDENTITAS</th>
                                                <th colspan="10" class="biru">PARAMETER</th>
                                                <th rowspan="2" class="hijau" style="vertical-align: middle;">STATUS</th>
                                                <th rowspan="2" class="hijau" style="vertical-align: middle;">RETRY</th>
                                            </tr> 
                                            <tr>
                                                <th class="hijau" style="vertical-align: middle;">NOMOR</th>
                                                <th class="hijau" style="vertical-align: middle;">NOMOR LAB</th>
                                                <th class="hijau" style="vertical-align: middle;">KODE CONTOH</th>
                                                <th class="hijau" style="vertical-align: middle;">NOMOR KUPA</th>
                                                <th class="biru" style="vertical-align: middle;">N</th>
                                                <th class="biru" style="vertical-align: middle;">P</th>
                                                <th class="biru" style="vertical-align: middle;">K</th>
                                                <th class="biru" style="vertical-align: middle;">Mg</th>
                                                <th class="biru" style="vertical-align: middle;">Ca</th>
                                                <th class="biru" style="vertical-align: middle;">B</th>
                                                <th class="biru" style="vertical-align: middle;">Cu</th>
                                                <th class="biru" style="vertical-align: middle;">Zn</th>
                                                <th class="biru" style="vertical-align: middle;">Fe</th>
                                                <th class="biru" style="vertical-align: middle;">Mn</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                </table>
                            </div>
                        </div>    
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-sm-right">SUBMIT</button>
                        </div>         
                        </form>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


@include('admin.layout.footer')


<script>
    $(document).ready(function(){
        $('#hasil_analisis').DataTable({
            "paging":   false,
        });        
	})
</script>