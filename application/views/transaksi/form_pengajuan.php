<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Form Pengajuan Pinjaman</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                    <li class="breadcrumb-item active"><a href="<?php echo base_url('pinjaman'); ?>">Pinjaman</a></li>
                    <li class="breadcrumb-item active">Form Pengajuan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-12">
                <!-- TABLE: DATA ANGGOTA -->
                <div class="card">
                    <div class="col-6">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nomor Anggota :</label>
                                <div class="input-group date" data-target-input="nearest">
                                    <input type="text" class="form-control" id="nomorAnggotaSearch" disabled>
                                    <div class="input-group-append">
                                        <div class="input-group-text" onclick="getDataAnggota()"><i class="fa fa-search"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="data-anggota">
                        </div>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->


<div class="modal fade" id="modalAnggota" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Data Anggota</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <input type="search" class="form-control" placeholder="Nomor Anggota" name="nomor_anggota" id="nomorAnggota">
                        </div>
                        <div class="col-6">
                            <input type="search" class="form-control" placeholder="Nama Anggota" name="nama_anggota" id="namaAnggota">
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-hover" id="table-anggota" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Anggota</th>
                            <th>Nama</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- /.modal -->