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
    @if(!empty($pelanggan))
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="text-success"><strong>TRACKING SAMPEL</strong></h3>
                        </div>
                        <div class="card-body table-responsive">
                            <form action="{{ url('/cekresi') }}" method="post">
                            {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-10">
                                        
                                    </div>
                                    <div class="col-sm-2">

                                    </div>
                                </div>
                            </form>
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