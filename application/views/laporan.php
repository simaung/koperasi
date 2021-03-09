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
                        <option value="simpanan"> Laporan Simpanan </option>
                        <option value="pinjaman"> Laporan Pinjaman </option>
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
                            <div class="col-md-3">
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
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary"><i class="nav-icon fa fa-print"></i></button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 rptSimpanan d-none">
            <div class="card-body">
                <h4>Laporan Simpanan</h4>
                <form action="<?php echo base_url('laporan/simpanan'); ?>" method="post" target="_blank">
                    <div class="row">
                        <div class="col-md-3">
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
                                <?php for ($i = 1; $i < 4; $i++) { ?>
                                    <option value="<?php echo $tahun; ?>"><?php echo $tahun; ?></option>
                                <?php
                                    $tahun -= 1;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary"><i class="nav-icon fa fa-print"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12 rptPinjaman d-none">
            <div class="card-body">
                <h4>Laporan Pinjaman</h4>
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-control" id="pilihLaporan">
                            <option>-- Status Pinjaman -- </option>
                            <option value="pending">Pending</option>
                            <option value="terima">Terima</option>
                            <option value="tolak">Tolak</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="pilihLaporan">
                            <option>-- Bulan -- </option>
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
                        <select class="form-control" id="pilihLaporan">
                            <option>-- Tahun -- </option>
                            <?php for ($i = 1; $i < 4; $i++) { ?>
                                <option value="aktif"><?php echo $tahun; ?></option>
                            <?php
                                $tahun -= 1;
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary printLaporanPinjaman"><i class="nav-icon fa fa-print"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->