@include('admin.layout.header')

@if(session('status'))
    @if(session('status') == 'gagal')
    <script>
        alert('kosong');
    </script>
    @endif
@endif


<?php
    $arr_id_parameter           = array();
    $arr_parameter              = array(); 
    $arr_harga                  = array();    

    # JENIS SAMPEL
    $arr_jenis_sampel           = array();
    $arr_opt_jenis_sampel       = array();
    $arr_id_jenis_sample_par    = array();
?>

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
                            <h3 class="text-success"><strong>INPUT SAMPEL</strong></h3>
                        </div>
                        <div class="card-body table-responsive">
                            <form role="form" method="POST" action="{{ url('admin/crud_inputsampel') }}">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <!-- TANGGAL MASUK -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tanggal Masuk</label>
                                                <input type="datetime-local" class="form-control" name="tanggal_masuk">
                                                @if(session('error_insert'))
                                                    @if ($errors->has('tanggal_masuk'))
                                                    <span class="text-danger">{{ $errors->first('tanggal_masuk') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <!-- TANGGAL MASUK -->

                                        <!-- TANGGAL SELESAI -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Target Selesai (Hari)</label>
                                                <input type="number" name="target_selesai" id="" class="form-control">
                                                @if(session('error_insert'))
                                                    @if ($errors->has('target_selesai'))
                                                    <span class="text-danger">{{ $errors->first('target_selesai') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <!-- TANGGAL SELESAI -->

                                        <!-- NOMOR SURAT -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">No. Surat</label>
                                                <input type="teks" name="nomor_surat" class="form-control" placeholder="Nomor Surat">
                                                @if(session('error_insert'))
                                                    @if ($errors->has('nomor_surat'))
                                                    <span class="text-danger">{{ $errors->first('nomor_surat') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <!-- NOMOR SURAT -->
                                    </div>

                                    <div class="row">   
                                        <!-- ID - NAMA - PERUSAHAAN -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Nama Pelanggan</label>
                                                @if(count($pelanggan) == 0)
                                                <a href="{{ url('admin/pelanggan') }}" class="btn btn-success form-control">INPUTKAN PELANGGAN</a>
                                                @else
                                                <select name="pelanggan_id" class="form-control select2" style="width: 100%;">
                                                    <option selected disabled>-- NAMA PELANGGAN DAN PERUSAHAAN --</option>
                                                        @foreach($pelanggan as $dpelanggan)
                                                        <option value="{{ $dpelanggan->id }}">{{ $dpelanggan->nama }} - {{ $dpelanggan->perusahaan }}</option>
                                                        @endforeach
                                                </select>
                                                @if(session('error_insert'))
                                                    @if ($errors->has('pelanggan_id'))
                                                    <span class="text-danger">{{ $errors->first('pelanggan_id') }}</span>
                                                    @endif
                                                @endif

                                                @endif
                                            </div>
                                        </div>
                                        <!-- ID - NAMA - PERUSAHAAN -->

                                        <!-- JENIS SAMPEL -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Jenis Sampel</label>
                                                <select class="form-control" name="jenis_sampel" id="jenis_sampel">
                                                    <option disabled selected>--Jenis Sampel--</option>
                                                    @foreach($jenis_sampel as $jenis_sampels)
                                                        <option value="{{ $jenis_sampels->id }}">{{ strtoupper($jenis_sampels->jenis_sampel) }}</option>
                                                    @endforeach
                                                </select>
                                                @if(session('error_insert'))
                                                    @if ($errors->has('jenis_sampel'))
                                                    <span class="text-danger">{{ $errors->first('jenis_sampel') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <!-- JENIS SAMPEL -->

                                        <!-- PARAMETER -->
                                        <div class="col-md-4" id="addpar">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Parameter</label>
                                                @if(count($parameter) == 0)
                                                    <a href="{{ url('admin/parameter') }}" class="btn btn-success form-control">INPUTKAN PARAMETER</a>
                                                @else
                                                    <select id="parameter" name="parameter[]" class="select2" multiple="multiple" data-placeholder="-- PARAMETER --" style="width: 100%;">
                                                        @foreach($parameter as $parameters)
                                                            <option class="optselparameter" value="{{ $parameters->id }}">{{ $parameters->parameter }} ({{ strtoupper($parameters->jenis_sampel) }})</option>                                                        
                                                            <?php
                                                                array_push($arr_id_parameter, $parameters->id);                                                            
                                                                array_push($arr_harga, $parameters->harga);
                                                                $arr_parameter[$parameters->id] = $parameters->parameter;
                                                                $arr_harga[$parameters->id] = $parameters->harga;

                                                                // array_push($arr_id_jenis_sample_par, $parameters->parameter);
                                                                $arr_id_jenis_sample_par['daun'] = $parameters->parameter;
                                                            ?>
                                                        @endforeach
                                                    </select>
                                                    @if(session('error_insert'))
                                                        @if ($errors->has('parameter'))
                                                        <span class="text-danger">{{ $errors->first('parameter') }}</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <!-- PARAMETER -->
                                    </div>

                                    <div class="row">        
                                        <!-- JUMLAH -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Jumlah Sampel</label>
                                                <input type="number" id="jumlah" value="1" name="jumlah_sampel" class="form-control" placeholder="Jumlah Sampel">
                                                @if(session('error_insert'))
                                                    @if ($errors->has('jumlah_sampel'))
                                                    <span class="text-danger">{{ $errors->first('jumlah_sampel') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <!-- JUMLAH -->

                                        <!-- TOTAL HARGA -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Total Harga (Rp.)</label>
                                                <div class="row">                              
                                                    <div class="col-sm-2" style="margin-right: 0px;">
                                                        <h4>Rp.</h4>
                                                    </div>
                                                    <div class="col-sm-10" id="total_harga" style="margin-left: -8%;">
                                                        <h4 id="total_harga_detail"></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- TOTAL HARGA -->
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            
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
                        </div>
                        <div class="card-footer">
                            <button name="action" value="add" type="submit" class="btn btn-success float-sm-right">TAMBAHKAN</button>
                           
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body table-responsive">
                            <div style="width:120%; margin-left: auto; margin-right: auto;">
                                <table id="data_sampels" class="table table-bordered table-hover text-center" style="width: 150%;">
                                    <thead>
                                        <tr>
                                            <th class="hijau">NOMOR</th>
                                            <th class="biru">TANGGAL MASUK</th>
                                            <th class="biru" style="width: 10%;">TANGGAL SELESAI (Hari)</th>
                                            <th class="biru" style="width: 15%;">NAMA PELANGGAN</th>
                                            <th class="biru">PERUSAHAAN</th>
                                            <th class="biru">JENIS SAMPEL</th>
                                            <th class="biru">PARAMETER</th>
                                            <th class="biru">JUMLAH SAMPEL</th>
                                            <th class="biru">NOMOR SURAT</th>
                                            <th class="biru">TERKINI</th>
                                            <th class="biru">DETAIL</th>
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
                                                <td>{{ $loop->iteration }}</td>
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
                                                <td>{{ $data_sampels->nomor_surat }}</td>
                                                <!-- NOMOR SURAT -->

                                                <!-- TERKINI -->
                                                <td>
                                                    <a class="btn btn-primary" href="{{ url('admin/tracking/'.$data_sampels->id.'') }}">TRACKING</a>
                                                </td>
                                                <!-- TERKINI -->

                                                <!-- DETAIL -->
                                                <td><a class="btn btn-success" href="{{ url('admin/hasilanalisis/'.$data_sampels->id.'') }}">LIHAT DETAIL</a></td>
                                                <!-- DETAIL -->
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

        </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->
</div>
@include('admin.layout.footer')
<script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1ef022ab/dist/jquery.mask.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
        var arr_id_parameter   = <?= json_encode($arr_id_parameter) ?>;
        var arr_harga          = <?= json_encode($arr_harga) ?>; 
        var arr_parameter      = <?= json_encode($arr_parameter) ?>;

        var parameter_id       = '';
        var parameter_harga    = 0;       
            
        var jumlah_sampel      = 0;
        var harga              = 0;
        
        function Harga(jumlah_sampel, parameter_id)
        {
            var h_parameter_harga    = 0;
            
            for (let i = 0; i < parameter_id.length; i++) {
                h_parameter_harga += parseInt(arr_harga[parameter_id[i]]);
            }  
            var h_harga          = h_parameter_harga * jumlah_sampel;
            return h_harga;  
        }

        $('#parameter').change(function(){

            harga   = Harga(parseInt($('#jumlah').val()), $('#parameter').val())

            $('#total_harga_detail').remove();
            $('#total_harga').append('<h4 id="total_harga_detail">'+harga+'</h4>');
            $( '#total_harga_detail' ).mask('0.000.000.000', {reverse: true});

            console.log($('#parameter').val());
        })

        $('#jumlah').change(function(){
            jumlah_sampel      = parseInt($('#jumlah').val())
            if(jumlah_sampel <= 0)
            {                
                alert('TIDAK DAPAT DIISI KURANG DARI 0');
                
                $('#jumlah').val(1);
            }
            else{
                if($('#parameter').val().length == 0)
                {
                    alert('PILIH PARAMETER')
                }
                else
                {

                    harga   = Harga(parseInt($('#jumlah').val()), $('#parameter').val())
                    
                    $('#total_harga_detail').remove();
                    $('#total_harga').append('<h4 id="total_harga_detail">'+harga+'</h4>');
                    $( '#total_harga_detail' ).mask('0.000.000.000', {reverse: true});
                }
            }
        })

        var jenis_sampel                = <?= json_encode($arr_jenis_sampel) ?>; 
        var jenis_sampel_opt            = <?= json_encode($arr_opt_jenis_sampel) ?>;
        var arr_id_jenis_sample_par     = <?= json_encode($arr_id_jenis_sample_par) ?>;
        var parameter                   = <?= json_encode($parameter) ?>;
        

        $('#jenis_sampel').change(function(){
            var status          = '';
            var arr_add_opt     = [];
            for(var i = 0; i < parameter.length; i++)
            {
                if(parameter[i]['id_jenis_sampel'] == $('#jenis_sampel').val())
                {
                    $('#parameter option').each(function(){
                        $(this).remove();
                    })
                    arr_add_opt.push({
                        id : parameter[i]['id'],
                        jenis_sampel    : parameter[i]['parameter'] + ' (' + parameter[i]['jenis_sampel'].toUpperCase() + ')'
                    });
                }
                else{
                    status = 'TIDAK ADA';
                }
            }
            if(status == 'TIDAK ADA')
            {
                $('#parameter option').each(function(){
                    $(this).remove();
                })

                $('#total_harga_detail').remove();
                $('#total_harga').append('<h4 id="total_harga_detail">'+0+'</h4>');
                $('#total_harga_detail' ).mask('0.000.000.000', {reverse: true});
                
            }  

            if(arr_add_opt.length == 0)
            {
                $('#parameter').append('<option disabled>TIDAK ADA</option>');
            }
            else{
                $.each(arr_add_opt, function(key, value){
                    $('#parameter').append(new Option(value['jenis_sampel'], value['id']));
                })
            }

            // arr_add_opt.each(function(key, value){
            //     // $('#parameter').append(new Option(value, key));
            // })
        });

        $('#data_sampels').DataTable({
            "order": [[ 1, "desc" ]],
            "paging" :false
        });        
	})

    
</script>