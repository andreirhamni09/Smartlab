<?php
    $nama_file = '';
?>

@if(isset($_SESSION['adminlab']))
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SMARTLAB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/img/CBI-logo.png') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">


    <!--download-->
    <link href="{{ asset('public/css/css.css') }}" rel="stylesheet">

    <!--download-->
    <script type="text/javascript" src="{{ asset('public/js/loader.js') }}"></script>

    <!--download-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/buttons.dataTables.min.css') }}" />
    <!--download-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery.dataTables.min.css') }}" />


    <style type="text/css">
        .center {
            margin: auto;
            height: 500px;
            width: 70%;
            padding: 10px;
            text-align: center;
        }

        .tengah {
            vertical-align: middle;
        }

        .hijau {
            background-color: #00621A;
            color: white;
        }

        .biru {
            background-color: #001494;
            color: white;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="height: 1000px;">
                                <div class="card-body">
                                    <a class="btn btn-primary float-sm-right text-white" id="print" onclick="printDiv();">PRINT DATA</a>
                                    <div class="row text-center">
                                        <div class="col-md-8" style="margin-left: auto; margin-right: auto; margin-top: auto; margin-bottom: auto;">
                                            @for($i = 0; $i < count($dataqrcode['no_lab']); $i++)
                                            <?php                                                 
                                                $nama_file = $dataqrcode['no_lab'][$i];
                                            ?>
                                            <div class="row" >
                                                <div class="col-md-6" >
                                                    {{ $qrcode[$i] }}
                                                    <br>
                                                    <h2>{{ $dataqrcode['no_lab'][$i] }}</h2>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    {{ $qrcode[$i] }}
                                                    <br>
                                                    <h2>{{ $dataqrcode['no_lab'][$i] }}</h2>
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col-md-6">
                                                    {{ $qrcode[$i] }}
                                                    <br>
                                                    <h2>{{ $dataqrcode['no_lab'][$i] }}</h2>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    {{ $qrcode[$i] }}
                                                    <br>
                                                    <h2>{{ $dataqrcode['no_lab'][$i] }}</h2>
                                                </div>
                                            </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /.container-fluid -->

            </section>
            <!-- /.content -->
        </div>
    </div>

<!-- jQuery -->
<script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/js/demo.js') }}"></script>
<!-- page script -->

<script src="{{ asset('public/js/js_tabel/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('public/js/js_tabel/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/js/js_tabel/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('public/js/js_tabel/buttons.flash.min.js') }}"></script>
<script src="{{ asset('public/js/js_tabel/jszip.min.js') }}"></script>
<script src="{{ asset('public/js/js_tabel/pdfmake.min.js') }}"></script>
<script src="{{ asset('public/js/js_tabel/vfs_fonts.js') }}"></script>
<script src="{{ asset('public/js/js_tabel/buttons.html5.min.js') }}"></script>
<script src="{{ asset('public/js/js_tabel/buttons.print.min.js') }}"></script>


<script src="{{ asset('public/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    document.title = '<?php echo $nama_file; ?>';
    function printDiv() 
    {
        $('#print').attr('hidden', true);
        window.print();
    }
    window.onafterprint = function(){
        alert("Printing completed...");
        $('#print').attr('hidden', false);
    }
</script>
@else
    @php
        header("Location: " . URL::to('/admin/login?status=Lakukan Login Terlebih Dahulu'), true, 302);
        exit();
    @endphp
@endif