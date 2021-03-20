<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Simpanan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                    <li class="breadcrumb-item active">Data Simpanan</li>
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
                        <button type="button" class="btn btn-primary" onclick="modalSimpanan()">
                            Tambah Simpanan
                        </button>
                        <button type="button" class="btn btn-warning" onclick="modalWajib()">
                            Bayar wajib
                        </button>
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
                                <input type="search" class="form-control" placeholder="Nomor Anggota" name="nomor_anggota" id="nomor_anggota" onsearch="reloadAjax()">
                            </div>
                            <div class="col-4">
                                <input type="search" class="form-control" placeholder="Nama Anggota" name="nama_anggota" id="nama_anggota" onsearch="reloadAjax()">
                            </div>
                            <!-- <div class="col-4">
                                <select class="form-control select2" name="status_anggota" id="status_anggota">
                                    <option value="">Pilih Status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="keluar">Keluar</option>
                                </select>
                            </div> -->
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
                                        <th>Data Anggota</th>
                                        <!-- <th>Nama</th> -->
                                        <th>Pokok</th>
                                        <th>Wajib</th>
                                        <th>Sukarela</th>
                                        <th>Angsuran</th>
                                        <th>Jasa</th>
                                        <th>Jumlah Setor</th>
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


<div class="modal fade" id="modalSimpanan" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Simpanan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_simpanan" method="post" action="#">
                    <div class="row">
                        <div class="col-6">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Tanggal Masuk :</label>
                                    <div class="input-group date" id="tgl_masuk" data-target-input="nearest">
                                        <input type="text" class="form-control" data-target="#tgl_masuk" name="tgl_masuk" value="<?php echo date('d/m/y'); ?>" disabled />
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nomor Anggota :</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" class="form-control nomorAnggotaSearch" disabled>
                                        <input type="hidden" class="form-control nomorAnggota">
                                        <div class="input-group-append">
                                            <div class="input-group-text" onclick="getDataAnggota()"><i class="fa fa-search"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="data-anggota">
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- /.modal -->

<div class="modal fade" id="modalWajib" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Bayar Wajib</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_bayar_wajib" method="post" action="#">
                    <div class="row">
                        <div class="col-5">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nomor Anggota :</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" class="form-control nomorAnggotaSearch" disabled>
                                        <input type="hidden" class="form-control nomorAnggota" name="id_anggota">
                                        <div class="input-group-append">
                                            <div class="input-group-text" onclick="getDataAnggota()"><i class="fa fa-search"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Jumlah Bulan :</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" class="form-control bulan" name="bulan" value="3">
                                        <input type="hidden" class="form-control nilai_wajib" value="<?php echo $wajib; ?>" name="nilai_wajib">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Jumlah Setor :</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" class="form-control uang jml_setor" disabled>
                                        <input type="hidden" class="form-control jml_setor" name="setor">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">&nbsp;</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <button type="submit" class="btn btn-primary btn-block" id="loadBtn">Simpan</button>
                                    </div>
                                </div>
                            </div>
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
                        <!-- <div class="col-4">
                            <select class="form-control select2" name="status_anggota" id="status_anggota">
                                <option value="">Pilih Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="keluar">Keluar</option>
                            </select>
                        </div> -->
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