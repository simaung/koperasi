<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Anggota</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('anggota'); ?>">Data Anggota</a></li>
                    <li class="breadcrumb-item active">Detail Anggota</li>
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
            <div class="col-12">

                <?php if ($anggota->status == 'keluar') { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-ban"></i> Anggota nonaktif!</h5>
                        Anggota ini sudah keluar dari keanggotaan.
                    </div>
                <?php } ?>

                <div class="form-group float-right btn-show">
                    <?php if ($anggota->status != 'keluar') { ?>
                        <button class="btn btn-sm btn-danger" onclick="pengajuanKeluar(<?php echo $anggota->id; ?>)">Pengajuan Keluar</button>
                    <?php } ?>

                    <button class="btn btn-sm btn-info" onclick="editAnggota(<?php echo $anggota->id; ?>)">Edit Anggota</button>
                </div>
                <div class="form-group float-right btn-hide">
                    <button class="btn btn-sm btn-danger btn-batal">Batal</button>
                    <button class="btn btn-sm btn-info" onclick="editAnggota(<?php echo $anggota->id; ?>)">Simpan perubahan</button>
                </div>
            </div>
            <div class="col-6">
                <div class="col-12">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tanggal Masuk :</label>
                        <div class="input-group date" id="tgl_masuk" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input tanggal_fmt editable" data-target="#tgl_masuk" name="tgl_masuk" value="<?php echo tgl_indo_simple($anggota->tgl_masuk); ?>" disabled />
                            <div class="input-group-append" data-target="#tgl_masuk" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="namaAnggota" class="col-form-label">Nama Lengkap : </label>
                        <input type="text" class="form-control editable" id="namaAnggota" name="nama_anggota" value="<?php echo $anggota->nama_anggota; ?>" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Alamat : </label>
                        <textarea class="form-control editable" name="alamat" disabled><?php echo $anggota->alamat_anggota; ?></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nomor Telepon :</label>
                        <input type="text" class="form-control editable" name="telp" data-inputmask="'mask': ['9999-9999-999[99]']" data-mask value="<?php echo $anggota->telp; ?>" disabled>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="col-12">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tempat Lahir :</label>
                        <input type="text" class="form-control editable" name="tempat_lahir" value="<?php echo ucfirst($anggota->tempat_lahir); ?>" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Tanggal Lahir : </label>
                        <div class="input-group date" id="tgl_lahir" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input tanggal_fmt editable" data-target="#tgl_lahir" name="tgl_lahir" value="<?php echo tgl_indo_simple($anggota->tgl_lahir); ?>" disabled>
                            <div class="input-group-append" data-target="#tgl_lahir" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Pekerjaan : </label>
                        <input type="text" class="form-control editable" name="pekerjaan" value="<?php echo $anggota->pekerjaan; ?>" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label mt-4">Jenis Kelamin : </label>
                        <div class="form-group clearfix mt-2">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="jenis_kelamin" value="L" <?php echo ($anggota->jenis_kelamin == 'L') ? 'checked' : ''; ?>>
                                <label for="radioPrimary1">
                                    Laki-laki
                                </label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary2" name="jenis_kelamin" value="P" <?php echo ($anggota->jenis_kelamin == 'P') ? 'checked' : ''; ?>>
                                <label for="radioPrimary2">
                                    Perempuan
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="col-12">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Jumlah Simpanan : </label>
                        <input type="text" class="form-control uang" name="simpanan" value="<?php echo rp($anggota->total_tabungan); ?>" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Jumlah Pinjaman : </label>
                        <input type="text" class="form-control uang total_pinjaman" name="pinjaman" value="<?php echo rp($anggota->total_pinjam - $anggota->jumlah_angsuran); ?>" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>