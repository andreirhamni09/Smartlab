@include('admin.layout.header')
<?php
    $arr_akseslevels_id      = explode('-', $akseslevels['id']);
    $arr_akseslevels_jabatan = explode('-', $akseslevels['jabatan']); 
?>
<style>
    .hijau {
        background-color: #00621A;
        color: white;
    }

    .biru {
        background-color: #001494;
        color: white;
    }
</style>
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
                            <h3 class="text-success"><strong>DAFTAR USER LAB</strong></h3>
                        </div>

                        <div class="card-body table-responsive">
                            <div style="width:120%; margin-left: auto; margin-right: auto;">
                                <form action="{{ url('admin/insertlabakuns') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Metode</label>
                                                <select name="metodes_id_s[]" class="select2" multiple="multiple" data-placeholder="-- PILIH METODE --" style="width: 100%;">
                                                @foreach($metodes as $met)
                                                    <option value="{{ $met['id'] }}">{{ strtoupper($met['metode']) }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Level Akses</label>                                                
                                                @if(empty($akseslevels))
                                                <a class="form-control btn btn-success" href="{{ url('admin/akseslevel') }}">Add Akses Level</a>                                                
                                                @else 
                                                    <Select class="form-control" name="akses_levels_id">
                                                        <option selected disabled>--Pilih Level Akses--</option>
                                                        @for($i = 0; $i < count($arr_akseslevels_id); $i++)
                                                            <option value="{{$arr_akseslevels_id[$i]}}">{{ strtoupper($arr_akseslevels_jabatan[$i]) }}</option>
                                                        @endfor
                                                    </Select>                                     
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input type="text" name="nama" class="form-control" placeholder="Nama ...">
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input type="email" name="email" class="form-control" placeholder="E-mail ..." autofocus>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="Password ...">
                                                
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Jabatan</label>
                                                <input type="text" name="jabatan" class="form-control" placeholder="Jabatan ...">
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Status Akun</label>
                                                <Select class="form-control" name="status_akun">
                                                    <option value="1">-- Pilih Status Akun --</option>
                                                    <option value="1">AKTIF</option>
                                                    <option value="0">NONAKTIF</option>
                                                </Select>  
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-group">
                                                <label>Submit</label>
                                                <button type="submit" name="action" value="add" class="form-control btn btn-primary">TAMBAHKAN</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @if(session('insert'))
                                    <script>
                                        alert("{{ session('insert') }}");
                                    </script>
                                @elseif(session('update'))
                                    <script>
                                        alert("{{ session('update') }}");
                                    </script>
                                @elseif(session('delete'))
                                    <script>
                                        alert("{{ session('delete') }}");
                                    </script>
                                @endif
                            </div>
                        </div>
                        


                        <div class="card-body table-responsive">
                            <div style="width:120%; margin-left: auto; margin-right: auto;">

                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th class="hijau">NO</th>
                                            <th class="biru" style="width: 17.5%;">METODE ID</th>
                                            <th class="biru" style="width: 10%;">AKSES LEVEL</th>
                                            <th class="biru">NAMA</th>
                                            <th class="biru">EMAIL</th>
                                            <th class="biru">PASSWORD</th>
                                            <th class="biru">JABATAN</th>
                                            <th class="biru">STATUS AKUN</th>
                                            <th class="biru" style="width: 15%;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- UPDATE DATA USER LAB -->
                                        <?php $no = 1; ?>
                                        @if(empty($labakuns))
                                        <tr>
                                            <td colspan="8">BELUM ADA USERLAB YANG DIINPUTKAN</td>
                                        </tr>
                                        @else
                                            <?php
                                                $arr_labakuns_id                 = explode('-', $labakuns['id']);
                                                $arr_labakuns_metodes_id_s       = explode(';', $labakuns['metodes_id_s']);
                                                $arr_labakuns_akses_levels_id    = explode('-', $labakuns['akses_levels_id']);
                                                $arr_labakuns_akses_level        = explode('-', $labakuns['akses_level']);
                                                $arr_labakuns_nama               = explode('-', $labakuns['nama']);
                                                $arr_labakuns_email              = explode('-', $labakuns['email']);
                                                $arr_labakuns_password           = explode('-', $labakuns['password']);
                                                $arr_labakuns_jabatan            = explode('-', $labakuns['jabatan']);
                                                $arr_labakuns_status_akun        = explode('-', $labakuns['status_akun']);
                                                $no_labakuns                     = 1;
                                            ?>
                                            @for($i = 0; $i < count($arr_labakuns_id); $i++)
                                            <form action="{{ url('admin/updatelabakuns') }}" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $arr_labakuns_id[$i] }}">
                                                <tr>
                                                    <td>{{ $no_labakuns }} </td>
                                                    <!-- METODES ID S -->
                                                    <td>
                                                    <select name="metodes_id_s[]" class="select2" multiple="multiple" data-placeholder="-- PILIH METODE --" style="width: 100%;">
                                                    @foreach($metodes as $met)
                                                        <?php if(in_array($met['id'], $labakuns_met[$i]['id'])):?>
                                                            <option value="{{ $met['id'] }}" selected>{{ strtoupper($met['metode']) }}</option>
                                                        <?php else:?>
                                                            <option value="{{ $met['id'] }}">{{ strtoupper($met['metode']) }}</option>
                                                        <?php endif;?>
                                                    @endforeach
                                                    </select>
                                                    </td>
                                                    <!-- METODES ID S -->
                                                    <!-- AKSES LEVELS -->
                                                    <td>
                                                        <Select class="form-control" name="akses_levels_id">
                                                            <option selected value="{{ $arr_labakuns_akses_levels_id[$i] }}">{{ strtoupper($arr_labakuns_akses_level[$i]) }} </option>
                                                            @for($j = 0; $j < count($arr_akseslevels_id); $j++)
                                                                <option value="{{ $arr_akseslevels_id[$j] }}">{{ strtoupper($arr_akseslevels_jabatan[$j]) }}</option>
                                                            @endfor
                                                        </Select>                                                          
                                                    </td>
                                                    <!-- AKSES LEVELS -->
                                                    <td><input type="text" name="nama" class="form-control" value="{{ $arr_labakuns_nama[$i] }}"> </td>
                                                    <td><input type="email" name="email" class="form-control" value="{{ $arr_labakuns_email[$i] }} "></td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <input type="password" name="password" id="u_hidden_password_{{$no_labakuns}}" class="form-control" value="{{ $arr_labakuns_password[$i] }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button class="btn btn-secondary" id="lihat_{{ $no_labakuns }}" type="button"><abbr title="Lihat Password"><i class="far fa-eye"></i></abbr></button>
                                                            </div>
                                                        </div>
                                                    <td><input type="text" name="jabatan" class="form-control" value="{{ $arr_labakuns_jabatan[$i] }}"></td>
                                                    <td>
                                                        <Select class="form-control" name="status_akun">
                                                            <?php
                                                                $status = '';
                                                                if($arr_labakuns_status_akun[$i] == 0){
                                                                    $status = 'NONAKTIF';
                                                                }
                                                                elseif($arr_labakuns_status_akun[$i] == 1){
                                                                    $status = 'AKTIF';
                                                                }
                                                            ?>
                                                            <option selected value="{{ $arr_labakuns_status_akun[$i] }}">{{ $status }}</option>
                                                            <option value="1">AKTIF</option>
                                                            <option value="0">NONAKTIF</option>
                                                        </Select>  
                                                    </td>
                                                    <td>
                                                        <button type="submit" class="btn btn-success">UPDATE</button>
                                                        <a href="deletelabakuns/{{$arr_labakuns_id[$i]}}" type="submit" class="btn btn-danger">DELETE</a>
                                                    </td>
                                                </tr>
                                            </form>
                                            <?php
                                                $no_labakuns++;
                                            ?>
                                            @endfor
                                        @endif
                                        <!-- UPDATE DATA USER LAB -->
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

<script src="{{ asset('public/js/js_tabel/jquery-3.5.1.js') }}"></script>
<script> 
    $(document).ready(function(){        
        var no      = <?= $no_labakuns ?>; 

        for (let i = 1; i < no; i++) 
        {                                                      
            $('#lihat_'+i+'').click(function(){      
                
                var tipe = $('#u_hidden_password_'+i+'').attr('type');
                if(tipe == 'password')
                {
                    $('#u_hidden_password_'+i+'').attr('type', 'text');
                }
                else{
                    $('#u_hidden_password_'+i+'').attr('type', 'password');
                }
            });
        }
    });
</script>

@include('admin.layout.footer')