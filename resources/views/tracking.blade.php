<?php
 session_start();
 
 if(session('resi')){
    $_SESSION['resi'] = session('resi');
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="SHORTCUT ICON" href="{{ asset('public/img/CBI-logo.png') }}">

    <title>TRACKING</title>
</head>

<body style="background-color:#349549;">

    <style>
        .br-radius {
            border: 5px;
            border-radius: 10px;
            s
        }
    </style>
    @if(isset($_GET['pelanggan']) OR !empty($_GET['pelanggan']) )
    <div id="login">
        <div class="container" style="margin-top:5%; margin-bottom:5%;">
            <div class="row justify-content-center">
                <div class="col-sm-5">
                    <div class="card">
                        <div class="row justify-content-center">
                            <div class="col-sm-10 mt-5 text-center">
                                <img src="{{ asset('public/img/LOGO-SRS.png') }}" alt="" height="80" class="mb-4" />
                                <form action="{{ url('/cekresi') }}" method="post">
                                {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $_GET['pelanggan']['id'] }}">
                                    
                                    <div class="mb-2">
                                        <label for="exampleFormControlInput1" class="form-label">Masukkan Nomor Resi</label>
                                        @if(isset($_SESSION['resi']))                                               
                                            <input value="{{ urldecode($_SESSION['resi']) }}" type="text" name="resi" class="form-control" placeholder="Masukan Resi ...">
                                        @else
                                            <input type="text" name="resi" class="form-control" placeholder="Masukan Resi ...">
                                        @endif
                                    </div>
                                    <button class="w-30 btn btn-lg mb-2" style="background-color:#349549; color:white;" type="submit">Cek Resi</button>
                                </form>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm-3 mb-5">
                                <img src="{{ asset('public/img/KAN.png') }}" alt="" height="50" class="mt-4" />
                            </div>
                            <div class="col-sm-3 mb-5">
                                <img src="{{ asset('public/img/Logo-CBI.png') }}" alt="" height="50" class="mt-4" />
                            </div>
                            <div class="col-sm-3 mb-5">
                                <img src="{{ asset('public/img/Logo-SSS.png') }}" alt="" height="50" class="mt-4" />
                            </div>
                        </div>

                        <div class="row justify-content-center text-center">
                            <div class="col-md-12">
                                <img src="img/LOGO-SRS.png" alt="" height="80" class="" />
                            </div>
                        </div>
                        <div class="my-3 p-3 bg-body rounded shadow-sm">
                            <small class="d-block text-right mt-3 mb-2">
                                <a href="{{ url('logout') }}">LOGOUT</a>
                            </small>
                        </div>
                         
                        @if(isset($_GET['tracking']))
                            <div class="row justify-content-center text-center">
                                <div class="col-md-12">
                                    <h2>Tracking</h2>
                                </div>
                            </div>
                            <div class="my-3 p-3 bg-body rounded shadow-sm">
                                <h6 class="border-bottom pb-2 mb-0">Recent updates</h6>
                                @if($_GET['tracking']['success'] == '1')
                                    @for($i = 0; $i < count($_GET['tracking']['lab_akuns_nama']); $i++)
                                        <?php
                                            $waktu      = $_GET['tracking']['aktivitas_waktu'][$i];
                                            $date       = date_create($waktu);
                                            $waktu      = date_format($date, 'H:i:s d-m-Y');
                                        ?>
                                        <div class="d-flex text-muted pt-3">
                                            <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
                                                <title>Placeholder</title>
                                                <rect width="100%" height="100%" fill="#e83e8c" /><text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text>
                                            </svg>

                                            <p class="pb-3 mb-0 small lh-sm border-bottom ml-2">
                                                <strong class="d-block text-gray-dark">Telah sampai ke tahap {{ $_GET['tracking']['group'][$i] }}</strong>
                                                {{ $waktu }}
                                            </p>
                                        </div>
                                    @endfor
                                @else
                                    <div class="d-flex text-muted pt-3">
                                        <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
                                            <title>Placeholder</title>
                                            <rect width="100%" height="100%" fill="#e83e8c" /><text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text>
                                        </svg>

                                        <p class="pb-3 mb-0 small lh-sm border-bottom ml-2">
                                            <strong class="d-block text-gray-dark">{{ $_GET['tracking']['message'] }}</strong>
                                        </p>
                                    </div>
                                @endif
                            </div>                        
                        @endif
                    </div>
                </div>
            </div>
        </div>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</body>

</html>