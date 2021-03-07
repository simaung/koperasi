<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Petugas</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                    <li class="breadcrumb-item active">Data Petugas</li>
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
                <!-- TABLE: DATA PETUGAS -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <?php if ($this->authData['level'] == 'admin') { ?>
                            <a href="javascript:void(0)" class="btn btn-sm btn-primary float-left" data-toggle="modal" data-target="#modalPetugas">Tambah Petugas</a>
                        <?php } ?>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <input type="search" class="form-control" placeholder="Nomor Petugas" name="nomor_anggota" id="nomor_petugas">
                            </div>
                            <div class="col-4">
                                <input type="search" class="form-control" placeholder="Nama Anggota" name="nama" id="nama">
                            </div>
                            <div class="col-4">
                                <select class="form-control select2" name="status_anggota" id="level">
                                    <option value="">Pilih Status</option>
                                    <option value="admin">Admin</option>
                                    <option value="operator">Operator</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Petugas</th>
                                        <th>Nama</th>
                                        <!-- <th>Phone</th> -->
                                        <th>Tanggal Masuk</th>
                                        <th>Level</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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


<div class="modal fade" id="modalPetugas" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Data Petugas Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_petugas" method="post" action="#">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Tanggal Masuk :</label>
                                    <div class="input-group date" id="tgl_masuk" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input tanggal_fmt" data-target="#tgl_masuk" name="tgl_masuk" value="<?php echo date('d/m/Y'); ?>" />
                                        <div class="input-group-append" data-target="#tgl_masuk" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="namaAnggota" class="col-form-label">NIK : </label>
                                    <input type="text" class="form-control" name="nik">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="namaAnggota" class="col-form-label">Nama : </label>
                                    <input type="text" class="form-control" name="nama_petugas">
                                </div>
                            </div>
                            <!-- <div class="col-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nomor Telepon :</label>
                                    <input type="text" class="form-control" name="telp" data-inputmask="'mask': ['9999-9999-999[99]']" data-mask>
                                </div>
                            </div> -->
                            <!-- <div class="col-12">
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Level : </label>
                                    <select name="level" class="form-control" id="level">
                                        <option value="operator">Operator</option>
                                        <option value="operator">Admin</option>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div class="col-12">
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label mt-4">Access System : </label>
                                    <div class="form-group clearfix mt-2">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="radioPrimary1" name="access_system" value="0" checked>
                                            <label for="radioPrimary1">
                                                Tidak
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="radioPrimary2" name="access_system" value="1">
                                            <label for="radioPrimary2">
                                                Ya
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="loadBtn">Simpan</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalAccess" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Akses sistem</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-access">
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>