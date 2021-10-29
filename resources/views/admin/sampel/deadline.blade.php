@include('admin.layout.header')
@if(isset($_SESSION['adminlab']))
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
                        <div class="card-body table-responsive">
                            <div style="margin-left: auto; margin-right: auto;">
                                <table id="data_sampels" class="table table-bordered table-hover text-center" style="width: 110%;">
                                    <thead>
                                        <tr>
                                            <th class="hijau">NO KUPA</th>
                                            <th class="biru">NO LAB</th>
                                            <th class="biru" colspan="2">DEADLINE</th>
                                            <th class="biru">BATCH</th>
                                            <th class="biru">TANGGAL DEADLINE</th>
                                            <th class="biru">TANGGAL MASUK</th>
                                            <th class="biru">STATUS TERAKHIR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($i = 0; $i < count($deadline['sampels_id']); $i++)
                                            <tr>
                                                <td> {{ $deadline['sampels_id'][$i] }}</td>
                                                <td> {{ $deadline['n_lab'][$i] }}</td>
                                                 
                                                    @if($deadline['tanggal_selesai_2'][$i] < 0)
                                                        <td style="background-color: red;"></td>
                                                        <td>Lewati {{ abs($deadline['tanggal_selesai_2'][$i]) }} Hari</td>
                                                    @elseif($deadline['tanggal_selesai_2'][$i] > 0 )
                                                        @if($deadline['tanggal_selesai_2'][$i] == 2 || $deadline['tanggal_selesai_2'][$i] == 3)
                                                            <td style="background-color: yellow;"></td>
                                                            <td class="merah">{{ abs($deadline['tanggal_selesai_2'][$i]) }} Hari Lagi</td>
                                                        @elseif($deadline['tanggal_selesai_2'][$i] >= 4)
                                                            <td style="background-color: grey;"></td>
                                                            <td class="merah">{{ abs($deadline['tanggal_selesai_2'][$i]) }} Hari Lagi</td>                                                            
                                                        @elseif($deadline['tanggal_selesai_2'][$i] == 1)
                                                            <td style="background-color: orange;"></td>
                                                            <td class="merah">{{ abs($deadline['tanggal_selesai_2'][$i]) }} Hari Lagi</td>
                                                        @endif
                                                    @else
                                                        <td style="background-color: red;"></td>
                                                        <td class="merah">Deadline Hari Ini</td>
                                                    @endif
                                                <td> 
                                                    {{ $deadline['batch'][$i] }}
                                                </td>
                                                <td> {{ $deadline['tanggal_selesai'][$i] }}</td>
                                                <td> 
                                                    <?php
                                                        $tanggal_masuk = date('H:i d-m-Y', strtotime(str_replace('/', '-', $deadline['tanggal_masuk'][$i])));
                                                    ?>
                                                    {{ $tanggal_masuk }}
                                                </td>
                                                <td> {{ $deadline['aktivitas'][$i] }}</td>
                                            </tr>
                                        @endfor
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
@else
    @php
        header("Location: " . URL::to('/admin/login?status=Lakukan Login Terlebih Dahulu'), true, 302);
        exit();
    @endphp
@endif
@include('admin.layout.footer')