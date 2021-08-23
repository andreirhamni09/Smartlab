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
                                <form action="{{ url('admin/insertparameters') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Simbol</label>
                                                <input type="text" name="simbol" class="form-control" placeholder="Simbol ..." autofocus>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">                                            
                                            <div class="form-group">
                                                <label>Nama Unsur</label>
                                                <input type="text" name="nama_unsur" class="form-control" placeholder="Nama Unsur ...">
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
                                            <th class="biru" style="width:20%;">SIMBOL</th>
                                            <th class="biru" style="width: 40%;">NAMA UNSUR</th>
                                            <th class="biru" style="width: 20%;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(empty($parameters))
                                            <tr>
                                                <td colspan="5"><h4>BELUM ADA DATA YANG DIINPUTKAN</h4></td>
                                            </tr>
                                        @else
                                            <?php
                                                $arr_parameters_id          = explode('-', $parameters['id']);
                                                $arr_parameters_simbol      = explode('-', $parameters['simbol']);
                                                $arr_parameters_nama_unsur  = explode('-', $parameters['nama_unsur']);
                                                $no_parameters              = 1;
                                            ?>
                                            @for($i = 0; $i < count($arr_parameters_id); $i++)                                                
                                                <form action="{{ url('admin/updateparameters')}}" method="post" >
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id" class="form-control" value="{{ $arr_parameters_id[$i] }}" placeholder="{{ $arr_parameters_id[$i] }}">
                                                    <tr>
                                                        <td>{{ $no_parameters }}</td>
                                                        <td><input name="simbol" class="form-control" value="{{ $arr_parameters_simbol[$i] }}" placeholder="{{ $arr_parameters_simbol[$i] }}"></td>
                                                        <td><input name="nama_unsur" class="form-control" value="{{ $arr_parameters_nama_unsur[$i] }}" placeholder="{{ $arr_parameters_nama_unsur[$i] }}"></td>
                                                        <td style="width: 40%;">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <button class="btn btn-primary" type="submit" name="update">UPDATE</button>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <a href="deleteparameters/{{$arr_parameters_id[$i]}}" value="add" class="btn btn-danger">DELETE</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </form>
                                            <?php $no_parameters++; ?>
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