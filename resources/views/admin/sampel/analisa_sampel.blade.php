@include('admin.layout.header')
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
                            <h3 class="text-success"><strong>ANALISA SAMPEL</strong></h3>
                        </div>
                        
                        <div class="card-body table-responsive">
                            <div style="width:120%; margin-left: auto; margin-right: auto;">
                                <table class="table table-bordered table-hover text-center" style="width: 150%;">
                                    <thead>
                                        <tr>
                                            <th class="hijau">NOMOR LAB</th>
                                            <th class="biru">BATCH</th>
                                            <th class="biru">TRACKING</th>
                                            <th class="biru">TANGGAL MASUK</th>
                                            <th class="biru" style="width: 10%;">TANGGAL SELESAI (Hari)</th>
                                            <th class="biru" style="width: 15%;">NAMA PELANGGAN</th>
                                            <th class="biru">PERUSAHAAN</th>
                                            <th class="biru">JENIS SAMPEL</th>
                                            <th class="biru">PAKET</th>
                                            <th class="biru">JUMLAH SAMPEL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($analisasampel['success'] == '1')
                                            @for($i = 0; $i < count($analisasampel['no_lab']); $i++)
                                                <tr>
                                                    @if(in_array($analisasampel['jenis_sampels_id'][$i], $jenissampels['id']))
                                                    <td>
                                                        {{ $analisasampel['tahun'][$i] }} 
                                                        {{ $jenissampels['lambang_sampel'][array_search($analisasampel['jenis_sampels_id'][$i], $jenissampels['id'])] }}
                                                    .   {{ $analisasampel['no_lab'][$i] }}
                                                    </td>
                                                    @endif
                                                    <td>
                                                        {{ $analisasampel['batch'][$i] }}
                                                    </td>
                                                </tr>
                                            @endfor
                                        @else
                                            <tr>
                                                <td colspan="10">{{ $analisasampel['message'] }}</td>
                                            </tr>
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