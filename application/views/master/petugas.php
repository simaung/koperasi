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
                            <a href="javascript:void(0)" class="btn btn-sm btn-primary float-left">Tambah Petugas</a>
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
                                    <option value="administrator">Administrator</option>
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
                                        <th>Phone</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Level</th>
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