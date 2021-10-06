@include('layout.header')
<?php
    if(session('resi')){
        $_SESSION['resi'] = session('resi');
    }
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
    @if(isset($_GET['pelanggan']) OR !empty($_GET['pelanggan']) )
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="text-success"><strong>TRACKING SAMPEL</strong></h3>
                            </div>
                            <div class="card-body table-responsive">
                                <form action="{{ url('/cekresi') }}" style="width: 70%; margin-left: auto; margin-right: auto;" method="post">
                                {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $_GET['pelanggan']['id'] }}">
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <div class="form-group">
                                                <label for="">RESI</label>
                                                @if(isset($_SESSION['resi']))
                                                    <input value="{{ $_SESSION['resi'] }}" type="text" name="resi" class="form-control">
                                                @else
                                                    <input type="text" name="resi" class="form-control">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="form-group">
                                                <label for="">Submit</label>
                                                <button type="submit" class="btn btn-primary form-control">
                                                    <abbr title="CEK RESI"><i class="fas fa-search"></i></abbr>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="text-success"><strong>TRACKING RESULT</strong></h3>
                            </div>                            
                            @if(isset($_GET['tracking']))

                            <div class="card-body table-responsive">
                                 <table id="data_sampels" class="table table-bordered table-hover text-center" style="width: 70%; margin-left:auto; margin-right:auto;">
                                    <thead>
                                        <tr>
                                            <th class="hijau">NO</th>
                                            <th class="biru">WAKTU</th>
                                            <th class="biru">AKTIVITAS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($_GET['tracking']['success'] == 1)
                                            <?php $nomor = 1; ?>
                                            @for($i = 0; $i < count($_GET['tracking']['aktivitas_waktu']); $i++)
                                            <tr>
                                                <td>{{ $nomor }}</td>
                                                <?php
                                                    $time = date('H:i d-m-Y', strtotime($_GET['tracking']['aktivitas_waktu'][$i])); 
                                                ?>
                                                <td>{{ $time }}</td>
                                                <td>{{ $_GET['tracking']['group'][$i] }}</td>
                                            </tr>
                                            @endfor
                                        @else
                                            <tr>
                                                <td colspan="3">{{ $_GET['tracking']['message'] }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


    @else
        @if(isset($_GET['resi']))
            @php
                header("Location: " . URL::to('/?resi='.$_GET['resi'].'&status=Lakukan Login Terlebih Dahulu'), true, 302);
                exit();
            @endphp
        @else
            @php
                header("Location: " . URL::to('/?status=Lakukan Login Terlebih Dahulu'), true, 302);
                exit();
            @endphp
        @endif
    @endif
</div>
@include('layout.footer')