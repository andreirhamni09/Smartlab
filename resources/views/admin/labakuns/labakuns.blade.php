@include('admin.layout.header')
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
                                                @if(empty($metodes))
                                                    <a href="p{{ url('admin/metodes') }}" class="form-control btn btn-primary">INSERT METODE</a>
                                                @else
                                                    <select name="metodes_id_s[]" class="select2" multiple="multiple" data-placeholder="-- PILIH METODE --" style="width: 100%;">
                                                        @for($i = 0; $i < count($metodes['id']); $i++)
                                                            <option value="{{ $metodes['id'][$i] }}">{{ $metodes['metode'][$i] }}</option>
                                                        @endfor
                                                    </select>
                                                @endif
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
                                                        @for($i = 0; $i < count($akseslevels['id']); $i++)
                                                            <option value="{{ $akseslevels['id'][$i] }}">{{ strtoupper($akseslevels['jabatan'][$i]) }}</option>
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
                                            <th class="biru" style="width: 17.5%;">METODE</th>
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
                                        <?php $no = 1; ?>
                                        @if(empty($labakuns))
                                            <tr>
                                                <td colspan="8"><h3>BELUM ADA USERLAB YANG DIINPUTKAN</h3></td>
                                            </tr>
                                        @else
                                            @for($i = 0; $i < count($labakuns['id']); $i++)
                                            <form action="{{ url('admin/updatelabakuns') }}" method="post">
                                                {{ csrf_field() }}
                                                <tr>
                                                    <input type="hidden" name="id" value="{{ $labakuns['id'][$i] }}">
                                                    <td>{{ $no }}</td>
                                                    <td>
                                                        <select name="metodes_id_s[]" class="select2" multiple="multiple" data-placeholder="-- PILIH METODE --" style="width: 100%;">
                                                            
                                                            @for($j = 0; $j < count($metodes['id']); $j++)
                                                                @if(in_array($metodes['id'][$j], explode('-', $labakuns['metodes_id_s'][$i])))
                                                                    <option value="{{ $metodes['id'][$j] }}" selected>{{ $metodes['metode'][$j] }}</option>
                                                                @else
                                                                    <option value="{{ $metodes['id'][$j] }}">{{ $metodes['metode'][$j] }}</option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="akses_levels_id">
                                                            @for($j = 0; $j < count($akseslevels['id']); $j++)
                                                                @if($labakuns['akses_levels_id'][$i] == $akseslevels['id'][$j])
                                                                    <option selected value="{{ $akseslevels['id'][$j] }}">{{ strtoupper($akseslevels['jabatan'][$j]) }} </option>
                                                                @else
                                                                    <option value="{{ $akseslevels['id'][$j] }}">{{ strtoupper($akseslevels['jabatan'][$j]) }} </option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="nama" class="form-control" value="{{ $labakuns['nama'][$i] }}">
                                                    </td>
                                                    <td>
                                                        <input type="email" name="email" class="form-control" value="{{ $labakuns['email'][$i] }}">
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <input type="password" name="password" id="u_hidden_password_{{ $no }}" class="form-control" value="{{ $labakuns['password'][$i] }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button class="btn btn-secondary" id="lihat_{{ $no }}" type="button"><abbr title="Lihat Password"><i class="far fa-eye"></i></abbr></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="jabatan" class="form-control" value="{{ $labakuns['jabatan'][$i] }}">
                                                    </td>                                                    
                                                    <td>
                                                        <select class="form-control" name="status_akun">
                                                            <?php
                                                                $status = '';
                                                                if($labakuns['status_akun'][$i] == 0){
                                                                    $status = 'NONAKTIF';
                                                                }
                                                                elseif($labakuns['status_akun'][$i] == 1){
                                                                    $status = 'AKTIF';
                                                                }
                                                            ?>
                                                            <option selected value="{{ $labakuns['status_akun'][$i] }}">{{ $status }}</option>
                                                            <option value="1">AKTIF</option>
                                                            <option value="0">NONAKTIF</option>
                                                        </select>  
                                                    </td>                                                    
                                                    <td>
                                                        <button type="submit" class="btn btn-success"><abbr title="UPDATE"><i class="fas fa-redo"></i></abbr></button>
                                                        <a href="deletelabakuns/{{ $labakuns['id'][$i] }}" class="btn btn-danger"><abbr title="UPDATE"><i class="fas fa-trash"></i></abbr></a>
                                                    </td>
                                                </tr>
                                            </form>
                                            <?php $no+=1; ?>
                                            @endfor
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

<script src="{{ asset('public/js/js_tabel/jquery-3.5.1.js') }}"></script>
<script> 
    $(document).ready(function(){        
        var no      = <?= $no ?>; 

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