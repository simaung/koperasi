<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Pinjaman</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                    <li class="breadcrumb-item active">Pinjaman</li>
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
                        <a href="<?php echo base_url('pinjaman/pengajuan'); ?>" class="btn btn-primary">
                            Tambah Pengajuan
                        </a>
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
                                <input type="search" class="form-control" placeholder="Nomor Anggota" name="nomor_anggota" id="nomor_anggota">
                            </div>
                            <div class="col-4">
                                <input type="search" class="form-control" placeholder="Nama Anggota" name="nama_anggota" id="nama_anggota">
                            </div>
                            <div class="col-4">
                                <select class="form-control select2" name="status_pengajuan" id="status_pengajuan">
                                    <option value="" selected="true" disabled="disabled">Pilih Status Pengajuan</option>
                                    <option value="pending">Pending</option>
                                    <option value="terima">Terima</option>
                                    <option value="tolak">Tolak</option>
                                </select>
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
                                        <th>Tanggal Pengajuan</th>
                                        <th>Nomor Anggota</th>
                                        <th>Nama</th>
                                        <th>Jumlah Pinjaman</th>
                                        <th>Lama Angsuran</th>
                                        <th>Bunga</th>
                                        <th>Tanggal Persetujuan</th>
                                        <th>Status</th>
                                        <th>Ambil Pinjaman</th>
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

<div class="modal fade" id="modalPengajuan" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Pengajuan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="data-pengajuan">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- /.modal -->

<div class="modal fade" id="biayaAdmin" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ambil Pinjaman</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="biaya-admin">Biaya Admin</label>
                <input type="hidden" class="form-control idPengajuan">
                <input type="text" class="form-control uang biayaAdmin" placeholder="0">
                <br>
                <button class="btn btn-success float-right" id="loadBtn" onclick="proses_ambil()">Proses</button>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- /.modal -->