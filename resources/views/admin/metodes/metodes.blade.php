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
                            <h3 class="text-success"><strong>DAFTAR METODE</strong></h3>
                        </div>

                        <div class="card-body table-responsive">
                            <div style="width:70%; margin-left: auto; margin-right:auto;">
                                <form action="{{ url('admin/insertmetodes') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>METODE</label>
                                                <input type="text" name="metodes" class="form-control" placeholder="Metode ..." autofocus>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">                                            
                                            <div class="form-group">
                                                <label>PARAMETER</label>
                                                @if(!empty($parameters))
                                                    <select name="parameters_id_s[]" class="select2" multiple="multiple" data-placeholder="-- PILIH PARAMETERS --" style="width: 100%;">
                                                        @for($i = 0; $i < count($parameters['id']); $i++)
                                                            <option value="{{ $parameters['id'][$i] }}">{{ $parameters['simbol'][$i] }}</option>
                                                        @endfor
                                                    </select>
                                                @else
                                                    <a href="{{ url('admin/parameters') }}" class="btn btn-primary form-control"><abbr title="TAMBAH PARAMATER"><i class="fas fa-plus"></i></abbr></a>
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
                                            <th class="hijau" style="width:15%;">NO</th>
                                            <th class="biru" style="width:40%;">METODE</th>
                                            <th class="biru" style="width: 20%;">PARAMETER</th>
                                            <th class="biru" style="width: 20%;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(empty($metodes))
                                            <tr>
                                                <td colspan="5"><h4>BELUM ADA DATA YANG DIINPUTKAN</h4></td>
                                            </tr>
                                        @else
                                            <?php $no_metodes = 1;?>
                                            @for($i = 0; $i < count($metodes['id']); $i++)
                                                <form action="{{ url('admin/updatemetodes')}}" method="post">
                                                {{ csrf_field() }}
                                                    <input type="hidden" name="id" class="form-control" value="{{ $metodes['id'][$i] }}">
                                                    <tr>
                                                        <td>{{ $no_metodes }}</td>
                                                        <td><input name="metode" class="form-control" value="{{ $metodes['metode'][$i] }}" placeholder="{{ $metodes['metode'][$i] }}"></td>
                                                        <td>
                                                            <select name="parameters_id_s[]" class="select2" multiple="multiple" data-placeholder="-- PILIH PARAMETERS --" style="width: 100%;">
                                                            @for($j = 0; $j < count($parameters['id']); $j++)
                                                                @if(in_array($parameters['id'][$j], explode('-', $metodes['parameters_id_s'][$i])))
                                                                    <option value="{{ $parameters['id'][$j] }}" selected>{{ $parameters['simbol'][$j] }}</option>
                                                                @else
                                                                    <option value="{{ $parameters['id'][$j] }}">{{ $parameters['simbol'][$j] }}</option>
                                                                @endif
                                                            @endfor
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-success" type="submit" name="update">UPDATE</button>
                                                            <a href="deletemetodes/{{$metodes['id'][$i]}}" value="add" class="btn btn-danger">DELETE</a>
                                                        </td>
                                                    </tr>
                                                </form>
                                            <?php $no_metodes += 1;?>
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