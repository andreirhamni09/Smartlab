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
                            <h3 class="text-success"><strong>DAFTAR JENIS SAMPELS</strong></h3>
                        </div>

                        <div class="card-body table-responsive">
                            <div style="width:70%; margin-left: auto; margin-right:auto;">
                                <form action="{{ url('admin/insertjenissampels') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>JENIS SAMPELS</label>
                                                <input type="text" name="jenissampels" class="form-control" placeholder="Jenis Sampel ..." autofocus>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">                                            
                                            <div class="form-group">
                                                <label>Lambang Sampel</label>
                                                <input type="text" name="lambangsampel" class="form-control" placeholder="Lambang sampels ...">
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
                                            <th class="hijau" style="width:10%;">NO</th>
                                            <th class="biru" style="width: 25%;">JENIS SAMPEL</th>
                                            <th class="biru" style="width: 30%;">LAMBANG SAMPEL</th>
                                            <th class="biru" style="width: 30%;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(empty($jenissampels))
                                            <tr>
                                                <td colspan="5"><h4>BELUM ADA DATA YANG DIINPUTKAN</h4></td>
                                            </tr>
                                        @else
                                            <?php
                                                $arr_jenissampels_id            = explode('-', $jenissampels['id']);
                                                $arr_jenissampels_jen           = explode('-', $jenissampels['jenis_sampel']);
                                                $arr_jenissampels_lambang       = explode('-', $jenissampels['lambang_sampel']);
                                                $no_jenissampels              = 1;
                                            ?>            
                                            @for($i = 0; $i < count($arr_jenissampels_id); $i++)                                  
                                                <form action="{{ url('admin/updatejenissampels')}}" method="post" >
                                                    {{ csrf_field() }}    
                                                    <input type="hidden" name="uid" value="{{ $arr_jenissampels_id[$i] }}">        
                                                    <tr>
                                                        <td>
                                                            {{ $no_jenissampels }}
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"  name="ujenissampels" value="{{ $arr_jenissampels_jen[$i] }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="ulambangsampels" value="{{ $arr_jenissampels_lambang[$i] }}" >
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn btn-success" name="update">UPDATE</button>
                                                            <a href="deletejenissampels/{{$arr_jenissampels_id[$i]}}" class="btn btn-danger">DELETE</a>
                                                        </td>
                                                    </tr>                               
                                                </form>
                                                <?php 
                                                    $no_jenissampels++;
                                                ?>
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