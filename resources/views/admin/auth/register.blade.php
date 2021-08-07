<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LOGIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/img/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/adminlte.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <div class="row">
                    <div class="col-md">
                        <h1 class="login-box-msg text-success">Smart<b>LAB</b>
                            <img src="{{ asset('public/img/CBI-logo.png') }}" style="width: 50px; height:50px; margin-top:-5%; margin-left:-1%;">
                        </h1>
                    </div>
                </div>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select class="form-control">
                            <option value="">Admin</option>
                            <option value="">Analis</option>
                            <option value="">Penyelia</option>
                            <option value="">QC</option>
                            <option value="">Manager</option>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="detail_jawaban" placeholder="Detail Jabatan">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <button type="submit" class="btn btn-success w-100 btn-block" name="login">REGISTER</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/js/adminlte.min.js') }}"></script>
</body>

</html>