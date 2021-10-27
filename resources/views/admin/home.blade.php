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
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="text-success">SELAMAT DATANG</h3>
                        </div>
                        
                        <div class="card-body table-responsive">
                            <h4>ANDRE SEPTIO IRHAMNI WICAKSANA</h4>
                            <div class="row justify-content-center">
                                <div class="col-md-4" style="margin-left:auto; margin-right: auto;">
                                    <img  src="{{ asset('public/img/LOGO-SRS.png') }}" height="100" class="mt-4 w-100"/>                           
                                </div> 
                                <div class="col-md-4" style="margin-left:auto; margin-right: auto;">
                                    <img  src="{{ asset('public/img/KAN.png') }}" height="100" class="mt-4 w-100"/>                           
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-2" style="margin-left:auto; margin-right: auto;">
                                    <img  src="{{ asset('public/img/LOGO-CBI.png') }}"  height="75"  class="mt-4 w-100" />                           
                                </div> 
                                <div class="col-md-2" style="margin-left:auto; margin-right: auto;">
                                    <img  src="{{ asset('public/img/LOGO-SSS.png') }}"  height="75"  class="mt-4 w-100" />                           
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
@include('admin.layout.footer')