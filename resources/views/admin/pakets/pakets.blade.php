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
                                                <label>Jenis Sampel</label>
                                                @if(!empty($jenissampels))
                                                    <select name="jenis_sampels_id" class="form-control">                                                    
                                                        <?php for($i = 0; $i < count($jenissampels['id']); $i++):?>
                                                            <option value="{{ $jenissampels['id'][$i] }}">{{ strtoupper($jenissampels['jenis_sampel'][$i]) }}</option>                                                        
                                                        <?php endfor;?>
                                                    </select>
                                                @else
                                                    <a href="{{ url('admin/jenissampels') }}" class="btn btn-primary form-control"><abbr title="TAMBAHKAN JENIS SAMPEL"><i class="fas fa-plus"></i></abbr></a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-2">                                            
                                            <div class="form-group">
                                                <label>Paket</label>
                                                <input type="text" name="paket" class="form-control" placeholder="Paket ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">                                            
                                            <div class="form-group">
                                                <label>Parameter</label> 
                                                @if(!empty($parameters))                                                    
                                                    <select name="parameters_id_s[]" class="select2" multiple="multiple" data-placeholder="-- PILIH PARAMETERS --" style="width: 100%;">
                                                        @for($i = 0; $i < count($parameters['id']); $i++)
                                                            <option value="{{ $parameters['id'][$i] }}">{{ $parameters['simbol'][$i] }}</option>
                                                        @endfor
                                                    </select>
                                                @else
                                                    <a href="{{ url('admin/parameters') }}" class="btn btn-primary form-control"><abbr title="TAMBAHKAN JENIS SAMPEL"><i class="fas fa-plus"></i></abbr></a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-2">                                            
                                            <div class="form-group">
                                                <label>Metode</label> 
                                                @if(!empty($metodes))                                                    
                                                    <select name="metodes_id_s[]" class="select2" multiple="multiple" data-placeholder="-- PILIH METODE --" style="width: 100%;">
                                                        @for($i = 0; $i < count($metodes['id']); $i++)
                                                            <option value="{{ $metodes['id'][$i] }}">{{ $metodes['metode'][$i] }}</option>
                                                        @endfor
                                                    </select>
                                                @else
                                                    <a href="{{ url('admin/metodes') }}" class="btn btn-primary form-control"><abbr title="TAMBAHKAN JENIS SAMPEL"><i class="fas fa-plus"></i></abbr></a>
                                                @endif                                                
                                            </div>
                                        </div>
                                        <div class="col-sm-2">                                            
                                            <div class="form-group">
                                                <label>Harga (Rp.)</label>
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <label for="" class="float-sm-right">Rp.</label>
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
                                                <button name="action" value="add" class="form-control btn btn-primary"><abbr title="TAMBAHKAN"><i class="fas fa-plus"></i></abbr></button>
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
                                            <th class="hijau" style="width:5%;">NO</th>
                                            <th class="biru"  style="width: 15%;">JENIS SAMPEL</th>
                                            <th class="biru"  style="width: 15%;">PAKET</th>
                                            <th class="biru"  style="width: 15%;">PARAMETER</th>
                                            <th class="biru"  style="width: 15%;">METODE</th>
                                            <th class="biru"  style="width: 17.5%;">HARGA</th>
                                            <th class="biru"  style="width: 13.5%;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(empty($pakets))
                                            <tr>
                                                <td colspan="7"><h4>BELUM ADA DATA YANG DIINPUTKAN</h4></td>
                                            </tr>
                                        @else
                                            <?php
                                                $no_pakets                      = 1;
                                            ?>
                                            @for($i = 0; $i < count($pakets['id']); $i++)
                                            <form action="{{ url('admin/updatepakets') }}" method="post">            
                                                <tr>
                                                    <input type="hidden" name="id" value="{{ $pakets['id'][$i] }}">
                                                    <td>{{ $no_pakets }}</td>
                                                    <td>
                                                        <select name="jenis_sampels_id" id="" class="form-control">
                                                        @for($j = 0; $j < count($jenissampels['id']); $j++)
                                                            @if($pakets['jenis_sampels_id'][$i] == $jenissampels['id'][$j])
                                                                <option selected value="{{ $jenissampels['id'][$j] }}">{{ strtoupper($jenissampels['jenis_sampel'][$j]) }}</option>
                                                            @else
                                                                <option value="{{ $jenissampels['id'][$j] }}">{{ strtoupper($jenissampels['jenis_sampel'][$j]) }}</option>
                                                            @endif
                                                        @endfor    
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="paket" value="{{ $pakets['paket'][$i] }}">
                                                    </td>
                                                    <td>
                                                        <select name="parameters_id_s[]" class="select2" multiple="multiple" data-placeholder="-- PILIH PARAMETERS --" style="width: 100%;">
                                                            @for($j = 0; $j < count($parameters['id']); $j++)
                                                                @if(in_array($parameters['id'][$j], explode('-', $pakets['parameters_id_s'][$i])))
                                                                    <option value="{{ $parameters['id'][$j] }}" selected>{{ $parameters['simbol'][$j] }}</option>
                                                                @else
                                                                    <option value="{{ $parameters['id'][$j] }}">{{ $parameters['simbol'][$j] }}</option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="metodes_id_s[]" class="select2" multiple="multiple" data-placeholder="-- PILIH METODE --" style="width: 100%;">
                                                            @for($j = 0; $j < count($metodes['id']); $j++)
                                                                @if(in_array($metodes['id'][$j], explode('-', $pakets['metodes_id_s'][$i])))
                                                                    <option selected value="{{ $metodes['id'][$j] }}">{{ $metodes['metode'][$j] }}</option>
                                                                @else
                                                                    <option value="{{ $metodes['id'][$j] }}">{{ $metodes['metode'][$j] }}</option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <strong>Rp.</strong>
                                                            </div>
                                                            <div class="col-sm">
                                                                <input value="{{ $pakets['harga'][$i] }}" class="form-control harga" type="text" name="harga">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="submit" class="btn btn-success"><abbr title="UPDATE"><i class="fas fa-redo"></i></abbr></button>
                                                        <a href="" class="btn btn-danger"><abbr title="DELETE"><i class="fas fa-trash"></i></abbr></a>
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