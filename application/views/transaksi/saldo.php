<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Saldo</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                    <li class="breadcrumb-item active">Data Saldo</li>
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
                    <div class="card-header border-transparent">
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSaldo">
                                Tambah Saldo
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <input type="search" class="form-control" placeholder="Keterangan" name="description" id="description">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <!-- /.card-header -->
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Jumlah Saldo</th>
                                        <th>Edit</th>
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


<div class="modal fade" id="modalSaldo" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Input Saldo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_saldo">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered" id="tableKas">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jumlah Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group date" id="tgl_masuk" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input tanggal_fmt" data-target="#tgl_masuk" name="tanggal" value="<?php echo date('d/m/y'); ?>" />
                                                <div class="input-group-append" data-target="#tgl_masuk" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><input type="text" name="saldo" class="form-control"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success btn-block" id="loadBtn">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- /.modal -->


<div class="modal fade" id="modalUpdate" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Saldo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_update_saldo">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered" id="tableKas">
                                <thead>
                                    <tr>
                                        <th>Jumlah Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="hidden" name="id" id="idUpdate"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="saldo" class="form-control"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success btn-block" id="loadBtn">Ubah</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>