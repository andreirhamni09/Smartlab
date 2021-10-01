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
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="hover"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link">Selamat datang!</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link"></a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a href="" class="brand-link">
                <img src="{{ asset('public/img/CBI-logo.png') }}" alt="Covid Tracker" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">SMARTLAB</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- USER LAB -->
                        <li class="nav-item">
                            <a href="https://localhost/slab/Smartlab/admin/labakuns" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    USERLAB
                                </p>
                            </a>
                        </li>
                        <!-- USER LAB -->
                        <li class="nav-item">
                            <a href="https://localhost/slab/Smartlab/admin/pelanggans" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    PELANGGAN
                                </p>
                            </a>
                        </li>
                        <!-- USER LAB -->
                        <li class="nav-item">
                            <a href="https://localhost/slab/Smartlab/admin/pelanggans" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    DAFTAR SAMPEL
                                </p>
                            </a>
                        </li>
                        <!-- USER LAB -->

                        <!-- LOGOUT -->
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="nav-icon fa fa-window-close"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                        <!-- LOGOUT -->

                    </ul>
                </nav>
            </div>
        </aside>

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

            <section id="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="text-success"><strong>DAFTAR PARAMETER</strong></h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <div style="width:70%; margin-left: auto; margin-right:auto;">
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label>Simbol</label>
                                                        <input placeholder="Simbol ..." type="text" name="simbol" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label>Nama Unsur</label>
                                                        <input placeholder="Nama Unsur ..." type="text" name="simbol" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Submit</label>
                                                        <button class="form-control btn btn-primary"><abbr title="TAMBAHKAN"><i class="fas fa-plus"></i></abbr></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <div style="width:70%; margin-left: auto; margin-right:auto;">
                                        <table class="table table-bordered table-hover text-center">
                                            <thead>
                                                <tr>
                                                   <th class="hijau">NO</th>
                                                   <th class="biru">SIMBOL</th>
                                                   <th class="biru">NAMA UNSUR</th>
                                                   <th class="biru">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td><input placeholder="N" value="N" type="text" name="" class="form-control"></td>
                                                    <td><input placeholder="Nitrogen" value="Nitrogen" type="text" name="" class="form-control"></td>
                                                    <td>
                                                        <button class="btn btn-success"><abbr title="UPDATE"><i class="fas fa-redo"></i></abbr></button>
                                                        <button class="btn btn-danger"><abbr title="HAPUS"><i class="fas fa-trash"></i></abbr></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @include('admin.layout.footer')