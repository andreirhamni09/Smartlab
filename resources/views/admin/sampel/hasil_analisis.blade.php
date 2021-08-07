@include('admin.layout.header')

@if(count($parameter) == 0)
@else
    @foreach($parameter as $parameters)
        <?php
            $arr_parameter[$parameters->id] = $parameters->parameter;
        ?>
    @endforeach
@endif
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
                                            <th class="hijau">PARAMETER</th>
                                            <th class="biru">JUMLAH SAMPEL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($data_sampel) == 0)
                                            <tr>
                                                <td colspan="11">DATA SAMPEL BELUM ADA YANG DIINPUTKAN</td>
                                            </tr>
                                        @else
                                            @foreach($data_sampel as $data_sampels)                                            
                                            <tr>
                                                <!-- NOMOR SURAT -->
                                                <td>{{ $data_sampels->nomor_surat }}</td>
                                                <!-- NOMOR SURAT -->

                                                <!-- TERKINI -->
                                                <td>
                                                    <a class="btn btn-primary" href="{{ url('admin/tracking/'.$data_sampels->id.'') }}">TRACKING</a>
                                                </td>
                                                <!-- TERKINI -->
                                                
                                                <!-- TANGGAL MASUK -->
                                                <?php
                                                    $tanggal_masuk      = strtotime($data_sampels->tanggal_masuk);
                                                    $v_tanggal_masuk    = date('d-m-Y H:i', $tanggal_masuk); 
                                                    
                                                    $t_selesai          = $data_sampels->tanggal_selesai.' days';

                                                    $date=date_create($v_tanggal_masuk);
                                                    date_add($date, date_interval_create_from_date_string($t_selesai));
                                                    $selesai = date_format($date, "d-m-Y");
                                                ?>
                                                <td>{{ $v_tanggal_masuk }}</td>
                                                <!-- TANGGAL MASUK -->


                                                <!-- TARGET SELESAI -->
                                                <td>{{ $data_sampels->tanggal_selesai }} Hari / {{ $selesai }}</td>
                                                <!-- TARGET SELESAI -->

                                                <!-- NAMA PELANGGAN -->
                                                <td>{{ $data_sampels->pelanggan_nama }}</td>
                                                <!-- NAMA PELANGGAN -->

                                                <!-- PERUSAHAAAN -->
                                                <td>{{ $data_sampels->pelanggan_perusahaan }}</td>
                                                <!-- PERUSAHAAN -->

                                                <!-- JENIS SAMPEL -->
                                                <td>{{ strtoupper($data_sampels->jenis_sampel) }}</td>
                                                <!-- JENIS SAMPEL -->

                                                <!-- PARAMETER -->
                                                <?php 
                                                    $d_paramater    = explode('-', $data_sampels->id_parameter);
                                                    $s_parameter    = ''; 
                                                    $j_parameter    = count($d_paramater) - 1;
                                                ?>
                                                <td>
                                                    @if(count($d_paramater) == 0)
                                                    @else
                                                        @for($i = 0; $i < count($d_paramater); $i++)
                                                            @if($i == $j_parameter)
                                                                {{ $arr_parameter[$d_paramater[$i]] }}
                                                            @else
                                                                {{ $arr_parameter[$d_paramater[$i]] }},
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </td>
                                                <!-- PARAMETER -->

                                                <!-- JUMLAH SAMPEL -->
                                                <td>{{ $data_sampels->jumlah_sampel }}</td>
                                                <!-- JUMLAH SAMPEL -->

                                                <!-- NOMOR SURAT -->
                                                <!-- NOMOR SURAT -->
                                            </tr>
                                            @endforeach
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
                                        <input type="hidden" name="id_kupa" value="{{ $kupa }}">
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
                                            @foreach($hasil_analisis as $d_hasil_analisis)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $d_hasil_analisis->tahun }}{{$d_hasil_analisis->simbol}}.{{$d_hasil_analisis->no_lab}} </td>
                                                <td><input type="text" name="kode_contoh[]" class="form-control" value="{{ $d_hasil_analisis->kode_contoh }}"></td>
                                                <td>{{$d_hasil_analisis->id_kupa}}</td>
                                                <td>{{$d_hasil_analisis->N}}</td>
                                                <td>{{$d_hasil_analisis->P}}</td>
                                                <td>{{$d_hasil_analisis->K}}</td>
                                                <td>{{$d_hasil_analisis->Mg}}</td>
                                                <td>{{$d_hasil_analisis->Ca}}</td>
                                                <td>{{$d_hasil_analisis->B}}</td>
                                                <td>{{$d_hasil_analisis->Cu}}</td>
                                                <td>{{$d_hasil_analisis->Zn}}</td>
                                                <td>{{$d_hasil_analisis->Fe}}</td>
                                                <td>{{$d_hasil_analisis->Mn}}</td>
                                                <td>
                                                    @if($d_hasil_analisis->status == 0)
                                                        DRAFT
                                                    @elseif($d_hasil_analisis->status == 1)
                                                        FINAL
                                                    @else
                                                        DATA ERROR
                                                    @endif
                                                </td>
                                                <td>{{ $d_hasil_analisis->retry }}</td>
                                            </tr>
                                            @endforeach
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