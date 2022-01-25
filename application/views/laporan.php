<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                    <li class="breadcrumb-item active">Laporan</li>
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
        <!-- <div class="row"> -->
        <div class="card">
            <div class="card-body">
                <!-- Left col -->
                <div class="col-md-12">
                    <select class="form-control" id="pilihLaporan">
                        <option>-- Pilih Data Laporan -- </option>
                        <option value="anggota"> Laporan Anggota </option>
                        <option value="simpanan"> Laporan Setoran </option>
                        <option value="pinjaman"> Laporan Pinjaman </option>
                        <option value="kas"> Laporan Kas Keuangan </option>
                    </select>
                </div>
            </div>
            <!-- /.col -->
            <!-- </div> -->
            <!-- /.row -->
            <div class="col-md-12 rptAnggota d-none">
                <div class="card-body">
                    <h4>Laporan Anggota</h4>
                    <form action="<?php echo base_url('laporan/anggota'); ?>" method="post" target="_blank">
                        <div class="row">
                            <div class="col-md-3">
                                <select class="form-control" name="status">
                                    <option value="">-- Status Anggota -- </option>
                                    <option value="aktif">Aktif</option>
                                    <option value="keluar">Keluar</option>
                                </select>
                            </div>
                            <!-- <div class="col-md-3">
                                <select class="form-control" name="bulan">
                                    <option value="">-- Bulan -- </option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <?php $tahun = date('Y'); ?>
                            <div class="col-md-3">
                                <select class="form-control" name="tahun">
                                    <option value="">-- Tahun -- </option>
                                    <?php for ($i = 1; $i < 4; $i++) { ?>
                                        <option value="<?php echo $tahun; ?>"><?php echo $tahun; ?></option>
                                    <?php
                                        $tahun -= 1;
                                    }
                                    ?>
                                </select>
                            </div> -->
                            <div class="col-md-3">
                                <input type="hidden" class="id_anggota" name="id_anggota">
                                <button type="submit" name="cetak" value="cetakPdf" class="btn btn-primary"><i class="nav-icon fa fa-print"></i></button>
                                <button type="submit" name="cetak" value="cetakExcel" class="btn btn-success"><i class="nav-icon fa fa-file-excel"></i></button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 rptSimpanan d-none">
            <div class="card-body">
                <h4>Laporan Setoran</h4>
                <form action="<?php echo base_url('laporan/simpanan'); ?>" method="post" target="_blank">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group date" data-target-input="nearest">
                                    <input type="text" class="form-control nomorAnggotaSearch" placeholder="nomor anggota" disabled>
                                    <div class="input-group-append">
                                        <div class="input-group-text" onclick="getDataAnggota()"><i class="fa fa-search"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right reservation" value="" name="periode" autocomplete="off">
                            </div>
                        </div>
                        <!-- <div class="col-md-2">
                            <select class="form-control" name="bulan">
                                <option value="">-- Bulan -- </option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <?php $tahun = date('Y'); ?>
                        <div class="col-md-2">
                            <select class="form-control" name="tahun">
                                <option value="">-- Tahun -- </option>
                                <?php for ($i = 1; $i < 4; $i++) { ?>
                                    <option value="<?php echo $tahun; ?>"><?php echo $tahun; ?></option>
                                <?php
                                    $tahun -= 1;
                                }
                                ?>
                            </select>
                        </div> -->
                        <div class="col-md-2">
                            <input type="hidden" class="id_anggota" name="id_anggota">
                            <button type="submit" name="cetak" value="cetakPdf" class="btn btn-primary"><i class="nav-icon fa fa-print"></i></button>
                            <button type="submit" name="cetak" value="cetakExcel" class="btn btn-success"><i class="nav-icon fa fa-file-excel"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12 rptPinjaman d-none">
            <div class="card-body">
                <h4>Laporan Pinjaman</h4>
                <form action="<?php echo base_url('laporan/pinjaman'); ?>" method="post" target="_blank">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group date" data-target-input="nearest">
                                    <input type="text" class="form-control nomorAnggotaSearch" placeholder="nomor anggota" disabled>
                                    <div class="input-group-append">
                                        <div class="input-group-text" onclick="getDataAnggota()"><i class="fa fa-search"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" name="status_pengajuan">
                                <option value="">-- Status Pengajuan -- </option>
                                <option value="pending">Pending</option>
                                <option value="terima">Terima</option>
                                <option value="tolak">Tolak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" name="status">
                                <option value="">-- Status Pinjaman -- </option>
                                <option value="belum">Belum Lunas</option>
                                <option value="lunas">Lunas</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right reservation" value="" name="periode" autocomplete="off">
                            </div>
                        </div>
                        <!-- <div class="col-md-3">
                            <select class="form-control" name="bulan">
                                <option value="">-- Bulan -- </option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <?php $tahun = date('Y'); ?>
                        <div class="col-md-3">
                            <select class="form-control" name="tahun">
                                <option value="">-- Tahun -- </option>
                                <?php for ($i = 1; $i < 4; $i++) { ?>
                                    <option value="<?php echo $tahun; ?>"><?php echo $tahun; ?></option>
                                <?php
                                    $tahun -= 1;
                                }
                                ?>
                            </select>
                        </div> -->
                        <div class="col-md-2">
                            <input type="hidden" class="id_anggota" name="id_anggota">
                            <button class="btn btn-primary printLaporanPinjaman"><i class="nav-icon fa fa-print"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12 rptKasKeuangan d-none">
            <div class="card-body">
                <h4>Laporan Kas</h4>
                <form action="<?php echo base_url('laporan/kas'); ?>" method="post" target="_blank">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control" name="status">
                                <option value="">-- Status -- </option>
                                <option value="debet">Debet</option>
                                <option value="kredit">Kredit</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right reservation" value="" name="periode" autocomplete="off">
                            </div>
                        </div>
                        <!-- <div class="col-md-2">
                            <select class="form-control" name="bulan">
                                <option value="">-- Bulan -- </option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <?php $tahun = date('Y'); ?>
                        <div class="col-md-2">
                            <select class="form-control" name="tahun">
                                <option value="">-- Tahun -- </option>
                                <?php for ($i = 1; $i < 4; $i++) { ?>
                                    <option value="<?php echo $tahun; ?>"><?php echo $tahun; ?></option>
                                <?php
                                    $tahun -= 1;
                                }
                                ?>
                            </select>
                        </div> -->
                        <div class="col-md-2">
                            <input type="hidden" class="id_anggota" name="id_anggota">
                            <button class="btn btn-primary printLaporanPinjaman"><i class="nav-icon fa fa-print"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                <br>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-danger btn-block btnClear" name="nama_anggota">Clear</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- /.modal -->