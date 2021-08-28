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
                            <h3 class="text-success"><strong>DAFTAR PAKET</strong></h3>
                        </div>

                        <div class="card-body table-responsive">
                            <div style="width:80%; margin-left: auto; margin-right:auto;">
                                <form action="{{ url('admin/insertpakets') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Simbol</label>
                                                <select name="jenis_sampels_id" class="form-control">                                                    
                                                    @foreach($jenissampels as $jen)
                                                        <option value="{{ $jen['id'] }}">{{ strtoupper($jen['jenis_sampel']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">                                            
                                            <div class="form-group">
                                                <label>Paket</label>
                                                <input type="text" name="paket" class="form-control" placeholder="Paket ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">                                            
                                            <div class="form-group">
                                                <label>Parameter ID</label> 
                                                <select name="parameters_id_s[]" class="select2" multiple="multiple" data-placeholder="-- PILIH PARAMETERS --" style="width: 100%;">
                                                    @foreach($parameters as $par)
                                                        <option value="{{ $par['id'] }}">{{ strtoupper($par['nama_unsur']) }}</option>                                                        
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm">                                            
                                            <div class="form-group">
                                                <label>Harga (Rp.)</label>
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <label for="">Rp.</label>
                                                    </div>                                                    
                                                    <div class="col-sm-10">
                                                        <input type="text" id="rupiah" name="harga" class="form-control" placeholder="Harga ...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Submit</label>
                                                <button name="action" value="add" class="form-control btn btn-primary">TAMBAHKAN</button>
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
                            <div style="width:70%; margin-left: auto; margin-right: auto;">
                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th class="hijau" style="width:15%;">NO</th>
                                            <th class="biru"  style="width: 20%;">JENIS SAMPEL</th>
                                            <th class="biru"  style="width: 22.5%;">PAKET</th>
                                            <th class="biru"  style="width: 22.5%;">PARAMETER</th>
                                            <th class="biru"  style="width: 22.5%;">HARGA</th>
                                            <th class="biru"  style="width: 20%;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(empty($pakets))
                                            <tr>
                                                <td colspan="5"><h4>BELUM ADA DATA YANG DIINPUTKAN</h4></td>
                                            </tr>
                                        @else
                                            <?php
                                                $arr_pakets_id                  = explode('-', $pakets['id']);
                                                $arr_pakets_jenis_sampels_id    = explode('-', $pakets['jenis_sampels_id']);
                                                $arr_pakets_jenis_sampel        = explode('-', $pakets['jenis_sampel']);
                                                $arr_pakets_paket               = explode('-', $pakets['paket']);

                                                $arr_pakets_parameters_id_s     = explode(';', $pakets['parameters_id_s']);
                                                $arr_pakets_parameters          = array();

                                                $arr_pakets_harga               = explode('-', $pakets['harga']);
                                                $no_pakets                      = 1;
                                            ?>
                                            @for($i = 0; $i < count($arr_pakets_id); $i++)                                                
                                                <form action="{{ url('admin/updatepakets')}}" method="post" >
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id" class="form-control" value="{{ $arr_pakets_id[$i] }}" placeholder="{{ $arr_pakets_id[$i] }}">
                                                    <tr>
                                                        <td>{{ $no_pakets }}</td>
                                                        <td>
                                                            <select name="jenis_sampels_id" class="form-control" data-placeholder="-- PILIH JENIS SAMPELS --">
                                                                <option value="{{ $arr_pakets_jenis_sampels_id[$i] }}" selected>{{ strtoupper($arr_pakets_jenis_sampel[$i]) }}</option>
                                                                @foreach($jenissampels as $jen)
                                                                    <option value="{{ $jen['id'] }}">{{ strtoupper($jen['jenis_sampel']) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                            
                                                        <td>
                                                            <input type="text" name="paket" class="form-control" value="{{ $arr_pakets_paket[$i] }}">
                                                        </td>

                                                        <td>
                                                        <select name="parameters_id_s[]" class="select2" multiple="multiple" data-placeholder="-- PILIH PARAMETERS --" style="width: 100%;">
                                                            
                                                            @foreach($parameters as $par)
                                                                <?php for ($j = 0; $j < count($arr_paket_par[$i]['id']); $j++):?>
                                                                    <?php if($arr_paket_par[$i]['id'][$j] == $par['id']):?>
                                                                        <option value="{{ $par['id'] }}" selected>{{ strtoupper($par['nama_unsur']) }}</option>  
                                                                    <?php else:?>
                                                                        <option value="{{ $par['id'] }}">{{ strtoupper($par['nama_unsur']) }}</option>
                                                                    <?php endif;?>                                                              
                                                                <?php endfor;?>
                                                            @endforeach
                                                        </select>
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-sm-2">
                                                                    <label for="">Rp.</label>
                                                                </div>                                                    
                                                                <div class="col-sm-10">
                                                                    <input class="form-control harga" type="text" name="harga" value="{{ $arr_pakets_harga[$i] }}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-primary" type="submit" name="update">UPDATE</button>
                                                            <a href="deletepakets/{{$arr_pakets_id[$i]}}" value="add" class="btn btn-danger">DELETE</a>
                                                        </td>
                                                    </tr>
                                                </form>
                                            <?php $no_pakets++; ?>
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
<script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1ef022ab/dist/jquery.mask.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
	    $( '#rupiah' ).mask('0.000.000.000', {reverse: true});
	    $( '.harga' ).mask('0.000.000.000', {reverse: true});
	})
</script>