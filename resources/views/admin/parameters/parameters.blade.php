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
                            <h3 class="text-success"><strong>DAFTAR PARAMETER</strong></h3>
                        </div>

                        <div class="card-body table-responsive">
                            <div style="width:70%; margin-left: auto; margin-right:auto;">
                                <form action="{{ url('admin/crud_parameter') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Parameter</label>
                                                <input type="text" name="parameter" class="form-control" placeholder="Parameter ..." autofocus>
                                                @if(session('error_insert'))
                                                    @if ($errors->has('parameter'))
                                                    <span class="text-danger">{{ $errors->first('parameter') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-3">                                            
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
                                                @if(session('error_insert'))
                                                    @if ($errors->has('harga'))
                                                    <span class="text-danger">{{ $errors->first('harga') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3">                                            
                                            <div class="form-group">
                                                <label>Jenis Sampel</label>
                                                <select class="form-control" name="jenis_sampel">
                                                    <option disabled selected>--PILIH JANIS SAMPEL--</option>
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
                                            <th class="hijau">NO</th>
                                            <th class="biru" style="width:40%;">PARAMETER</th>
                                            <th class="biru" style="width: 27%;">HARGA</th>
                                            <th class="biru" style="width: 15%;">JENIS SAMPEL</th>
                                            <th class="biru "style="width: 18%;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($parameter) == 0)
                                            <tr>
                                                <td colspan="5"><h4>BELUM ADA DATA YANG DIINPUTKAN</h4></td>
                                            </tr>
                                        @else
                                            @foreach($parameter as $parameters)
                                            <form action="{{ url('admin/crud_parameter') }}" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="u_id" value="{{ $parameters->id }}">
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="u_jenis_analisis_{{ $parameters->id }}" value="{{ $parameters->parameter }}">
                                                        @if(session('error_update'))
                                                            @if ($errors->has('u_jenis_analisis_'.$parameters->id.''))
                                                            <span class="text-danger">{{ $errors->first('u_jenis_analisis_'.$parameters->id.'') }}</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <label for="">Rp.</label>
                                                            </div>                                                    
                                                            <div class="col-sm-10">
                                                                <input class="form-control harga" type="text" name="u_harga_{{ $parameters->id }}" value="{{ $parameters->harga }}">
                                                            </div>
                                                        </div>
                                                        @if(session('error_update'))
                                                            @if ($errors->has('u_harga_'.$parameters->id.''))
                                                            <span class="text-danger">{{ $errors->first('u_harga_'.$parameters->id.'') }}</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="u_id_jenis_sampels_{{ $parameters->id }}">
                                                            <option selected value="{{ $parameters->id_jenis_sampel }}">{{ strtoupper($parameters->jenis_sampel) }}</option>
                                                            @foreach($jenis_sampel as $jenis_sampels)
                                                                <option value="{{ $jenis_sampels->id }}">{{ strtoupper($jenis_sampels->jenis_sampel) }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if(session('error_update'))
                                                            @if ($errors->has('id_jenis_sampel'.$parameters->id.''))
                                                            <span class="text-danger">{{ $errors->first('id_jenis_sampel'.$parameters->id.'') }}</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="row" style="margin-left: auto; margin-right:auto;">
                                                            <div class="col-sm-6">
                                                                <button class="btn btn-success" name="action" value="update"><abbr title="UPDATE"><i class="fas fa-redo"></i></abbr></button>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <button class="btn btn-danger" name="action" value="delete"><abbr title="DELETE"><i class="fas fa-trash"></i></abbr></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </form>
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
	    $( '#rupiah' ).mask('0.000.000.000', {reverse: true});
	    $( '.harga' ).mask('0.000.000.000', {reverse: true});
	})
</script>