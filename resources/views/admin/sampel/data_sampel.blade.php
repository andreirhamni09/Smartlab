@include('admin.layout.header')

@if(session('status'))
@if(session('status') == 'gagal')
<script>
    alert('kosong');
</script>
@endif
@endif

<?php
    $arr_harga = array();
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
                            <form style="width:150%; margin-left: auto; margin-right: auto;" role="form" method="POST" action="{{ url('admin/insertdatasampels') }}">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="">Jenis Sampel</label>
                                            <?php if (!empty($jenissampels)) : ?>
                                                <select id="jenis_sampels_id" name="jenis_sampels_id" class="form-control">
                                                    @for ($i = 0; $i < count($jenissampels['id']); $i++)
                                                        <option value="<?= $jenissampels['id'][$i] ?>"><?= strtoupper($jenissampels['jenis_sampel'][$i]) ?></option>
                                                    @endfor
                                                </select>
                                            <?php else : ?>
                                                <a href="{{ url('admin.jenissampels') }}" class="btn btn-primary"><abbr title="ADD JENIS SAMPEL"><i class="fas fa-plus"></i></abbr></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="">Pelanggan</label>
                                            @if(!empty($pelanggans))
                                            <select name="pelanggans_id" id="" class="form-control">
                                                @for($i = 0; $i < count($pelanggans['id']); $i++) <option value="{{ $pelanggans['id'][$i] }}">{{ strtoupper($pelanggans['nama'][$i]) }} - {{ strtoupper($pelanggans['perusahaan'][$i]) }}</option>
                                                    @endfor
                                            </select>
                                            @else
                                            <a href="{{ url('admin/pelanggans') }}" class="btn btn-primary"><abbr title="TAMBAHKAN PELANGGAN"><i class="fas fa-plus"></i></abbr></a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="">Paket</label>
                                            @if(!empty($pakets))
                                            <select name="pakets_id_s[]" id="pakets_id_s" class="select2" multiple="multiple" data-placeholder="-- PILIH PAKET --" style="width: 100%;">
                                                @for($i = 0; $i < count($pakets['id']); $i++) 
                                                    <option value="{{ $pakets['id'][$i] }}">{{ $pakets['paket'][$i] }}</option>
                                                    <?php
                                                        $arr_harga[$pakets['id'][$i]] = $pakets['harga'][$i];
                                                    ?>
                                                @endfor
                                            </select>
                                            @else
                                            <a href="{{ url('admin/pakets') }}" class="btn btn-primary"><abbr title="TAMBAHKAN PAKET"><i class="fas fa-plus"></i></abbr></a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="">Nomor Surat</label>
                                            <input type="text" name="nomor_surat" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="">Tanggal Masuk</label>
                                            <input type="datetime-local" name="tanggal_masuk" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="">Tanggal Selesai</label>
                                            <input type="number" name="tanggal_selesai" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="">Jumlah Sampel</label>
                                            <input type="number" value="1" id="jumlah_sampel" name="jumlah_sampel" class="form-control">
                                        </div>
                                    </div>
                                    <!-- TOTAL HARGA -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Total Harga (Rp.)</label>
                                            <div class="row">
                                                <div class="col-sm-3" style="margin-right: 0px;">
                                                    <h4>Rp. </h4>
                                                </div>
                                                <div class="col-sm-7" id="total_harga" style="margin-left: -8%;">
                                                    <h4 id="total_harga_detail">0</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="">Batch</label>
                                            <input type="text" name="batch_size" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="">Kondisi Alat</label>
                                            <select name="ketersediaan_alat" class="form-control">
                                                <option value="0">Rusak</option>
                                                <option value="1">Tersedia</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="">Catatan</label>
                                            <input type="text" name="catatan_userlabs" class="form-control">
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
                                            <th class="biru">PAKETS</th>
                                            <th class="biru">JUMLAH SAMPEL</th>
                                            <th class="biru">NOMOR SURAT</th>
                                            <th class="biru">KETERSEDIAAN ALAT</th>
                                            <th class="biru">CATATAN USERLAB</th>
                                            <th class="biru">STATUS</th>
                                            <th class="biru">DETAIL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no_ = 1; ?>
                                        @for($i = 0; $i < count($datasampels['id']); $i++)
                                            <tr>
                                                <td>{{ $no_ }}</td>
                                                <td>{{ $datasampels['tanggal_masuk'][$i] }}</td>
                                                <td>{{ $datasampels['tanggal_selesai'][$i] }}</td>
                                                @if(in_array($datasampels['pelanggans_id'][$i], $pelanggans['id']))
                                                    <td>{{ $pelanggans['nama'][array_search($datasampels['pelanggans_id'][$i], $pelanggans['id'])] }}</td>
                                                    <td>{{ $pelanggans['perusahaan'][array_search($datasampels['pelanggans_id'][$i], $pelanggans['id'])] }}</td>
                                                @endif
                                                @if(in_array($datasampels['jenis_sampels_id'][$i], $jenissampels['id']))
                                                    <td>{{ strtoupper($jenissampels['jenis_sampel'][array_search($datasampels['jenis_sampels_id'][$i], $jenissampels['id'])]) }}</td>
                                                @endif
                                                <td></td>
                                                <td>{{ strtoupper($datasampels['jenis_sampel'][$i]) }}</td>
                                                <td>{{ strtoupper($datasampels['nomor_surat'][$i]) }}</td>
                                                
                                            </tr>
                                        <?php $no_+=1; ?>
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
<script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1ef022ab/dist/jquery.mask.min.js"></script>

<script type="text/javascript">    
    var paket              = <?= json_encode($pakets) ?>;
    var arr_harga          = <?= json_encode($arr_harga) ?>; 
    var parameter_harga    = 0;    
    var harga              = 0; 
    
    function Harga(jumlah_sampel, pakets_id)
    {
        var h_parameter_harga    = 0;

        if($.inArray(pakets_id, paket['id']))
        {
            for (let i = 0; i < pakets_id.length; i++) {
                h_parameter_harga += parseInt(arr_harga[pakets_id[i]]);
            }
        }
        var h_harga          = h_parameter_harga * jumlah_sampel;
        return h_harga;   
    }

    $('#pakets_id_s').change(function(){
        harga   = Harga(parseInt($('#jumlah_sampel').val()), $('#pakets_id_s').val());
        $('#total_harga_detail').remove();
        $('#total_harga').append('<h4 id="total_harga_detail">'+harga+'</h4>');
        $( '#total_harga_detail' ).mask('0.000.000.000', {reverse: true});
    })  
    $('#jumlah_sampel').change(function(){
            jumlah_sampel      = parseInt($('#jumlah_sampel').val())
            if(jumlah_sampel <= 0)
            {                
                alert('TIDAK DAPAT DIISI KURANG DARI 0');
                
                $('#jumlah_sampel').val(1);
            }
            else{
                if($('#pakets_id_s').val().length == 0)
                {
                    alert('PILIH PAKET')
                }
                else
                {

                    harga   = Harga(parseInt($('#jumlah_sampel').val()), $('#pakets_id_s').val())
                    
                    $('#total_harga_detail').remove();
                    $('#total_harga').append('<h4 id="total_harga_detail">'+harga+'</h4>');
                    $( '#total_harga_detail' ).mask('0.000.000.000', {reverse: true});
                }
            }
        })
    $('#jenis_sampels_id').change(function() {
        var status = '';
        var arr_add_opt = [];
        for (let i = 0; i < paket['id'].length; i++) {
            if (paket['jenis_sampels_id'][i] == $('#jenis_sampels_id').val()) {
                $('#pakets_id_s option').each(function() {
                    $(this).remove();
                })
                arr_add_opt.push({
                    id: paket['id'][i],
                    jenis_sampel: paket['paket'][i] + ' (' + paket['jenis_sampel'][i].toUpperCase() + ')'
                });
            } else {
                status = 'TIDAK ADA';
            }
        }
        if (status == 'TIDAK ADA') {
            $('#pakets_id_s option').each(function() {
                $(this).remove();
            })

            $('#total_harga_detail').remove();
            $('#total_harga').append('<h4 id="total_harga_detail">' + 0 + '</h4>');
            $('#total_harga_detail').mask('0.000.000.000', {
                reverse: true
            });
        }

        if (arr_add_opt.length == 0) {
            $('#pakets_id_s').append('<option disabled>TIDAK ADA</option>');
        } else {
            $.each(arr_add_opt, function(key, value) {
                $('#pakets_id_s').append(new Option(value['jenis_sampel'], value['id']));
            })
        }
    });
</script>