@include('layout.header')
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
    @if(isset($_GET['pelanggan']))
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
                                    <input type="hidden" name="email" value="{{ $_GET['pelanggan']['email'] }}">
                                    <input type="hidden" name="nama" value="{{ $_GET['pelanggan']['nama'] }}">
                                    <input type="hidden" name="perusahaan" value="{{ $_GET['pelanggan']['perusahaan'] }}">
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <div class="form-group">
                                                <label for="">RESI</label>
                                                <input type="text" name="resi" class="form-control">
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
                            <div class="card-body table-responsive">
                                 <table id="data_sampels" class="table table-bordered table-hover text-center" style="width: 70%; margin-left:auto; margin-right:auto;">
                                    <thead>
                                        <tr>
                                            <th class="hijau">WAKTU</th>
                                            <th class="biru">AKTIVITAS</th>
                                            <th class="biru">PETUGAS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($_GET['tracking']))
                                            <tr>
                                                <td colspan="3">DATA DITEMUKAN</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="3">SILAHKAN MASUKAN RESI</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


    @else
        @php
            header("Location: " . URL::to('/?status=Lakukan Login Terlebih Dahulu'), true, 302);
            exit();
        @endphp
    @endif
</div>
@include('layout.footer')