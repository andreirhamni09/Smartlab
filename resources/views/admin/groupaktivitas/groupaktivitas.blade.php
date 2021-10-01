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
                            <h3 class="text-success"><strong>DAFTAR GRUP AKTIVITAS</strong></h3>
                        </div>

                        <div class="card-body table-responsive">
                            <div style="width:30%; margin-left: auto; margin-right:auto;">
                                <form action="{{ url('admin/insertgroupaktivitas') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>NAMA GRUP AKTIVITAS</label>
                                                <input type="text" name="group" class="form-control" placeholder="Nama Grup Aktivitas ..." autofocus>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
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
                            <div style="width:50%; margin-left: auto; margin-right: auto;">
                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th class="hijau" style="width:10%;">NO</th>
                                            <th class="biru" style="width: 25%;">NAMA GROUP AKTIVITAS</th>
                                            <th class="biru" style="width: 30%;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($groupaktivitas['success'] == 0)
                                            <tr>
                                                <td colspan="5"><h4>BELUM ADA DATA YANG DIINPUTKAN</h4></td>
                                            </tr>
                                        @else
                                            <?php $no = 1;?>
                                            @for($i = 0; $i < count($arrgroupaktivitas['id']); $i++)
                                                <form action="{{ url('admin/updategroupaktivitas') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id" value="{{ $arrgroupaktivitas['id'][$i] }}">
                                                    <tr>
                                                        <td>{{ $no }}</td>
                                                        <td><input type="text" name="group" class="form-control" value="{{ $arrgroupaktivitas['group'][$i] }}"></td>
                                                        <td>
                                                            <button class="btn btn-success" type="submit">UPDATE</button>
                                                            <a class="btn btn-danger" href="deletegroupaktivitas/{{ $arrgroupaktivitas['id'][$i] }}">DELETE</a>
                                                        </td>
                                                    </tr>
                                                </form>
                                            <?php $no+=1;?>
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
    $(function(){
        
    });
</script>