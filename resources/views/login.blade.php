<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="SHORTCUT ICON" href="{{ asset('public/img/CBI-logo.png') }}">

    <title>LOGIN</title>
  </head>
  <body style="background-color:#349549;">

  <style>
   .br-radius {
     border: 5px;
     border-radius: 10px;
   }
    </style>

    <div id="login">        
    @if(isset($_GET['status']))
        <script>
            var status = <?= json_encode($_GET['status']) ?>;
            alert(status);
        </script>
    @endif
        <div class="container text-center" style="margin-top:5%; margin-bottom:5%;">
            <div class="row justify-content-center">
                <div class="col-sm-5">
                    <div class="card">
                        <div class="row justify-content-center">
                            <div class="col-sm-10 mt-5">
                            <form action="{{ url('/login_p') }}" method="post">
                            {{ csrf_field() }}
                                @if(isset($_GET['resi']))
                                    <input type="hidden" name="resi" value="{{ urlencode($_GET['resi']) }}">
                                @endif
                                <img src="{{ asset('public/img/LOGO-SRS.png') }}" alt="" height="80" class="mb-4"/>

                                <div class="form-floating">
                                  <input type="email" name="email" class="form-control mb-2 text-center" id="floatingInput" placeholder="name@email.com">
                                </div>
                                <div class="form-floating">
                                  <input type="password" name="password" class="form-control mb-2 text-center" id="floatingPassword" placeholder="password">
                                </div>
                                <button class="w-100 btn btn-lg mb-2" style="background-color:#349549; color:white;" type="submit">Sign in </button>
                                <br/>
                                    <a id="lupalogin" style="color:#349549;" class="lupapassword">Lupa Password?</a>
                                <br/>
                                <h1></h1>
                            </form>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm-3 mb-5">
                                <img src="{{ asset('public/img/KAN.png') }}" alt="" height="50" class="mt-4"/>
                            </div>
                            <div class="col-sm-3 mb-5">
                                <img src="{{ asset('public/img/Logo-CBI.png') }}" alt="" height="50" class="mt-4"/>
                            </div>
                            <div class="col-sm-3 mb-5">
                                <img src="{{ asset('public/img/Logo-SSS.png') }}" alt="" height="50"  class="mt-4"/>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    
  </body>
</html>

<script>
  jQuery(document).ready(function($) {
    if (window.history && window.history.pushState) {
      window.history.pushState('forward', null, './#');
      $(window).on('popstate', function() {
        window.location.href = "{{ URL::to('/')}} ";
      });
    }
  });
</script>