<div class="row">
    <div class="col-6">
        <div class="col-12">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-4 col-form-label">Total Simpanan</label>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-lg uang" id="total_tabungan" value="<?php echo rp($data_anggota->total_tabungan); ?>" disabled style="text-align:right">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label">Maksimum Pinjaman</label>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-lg uang" value="<?php echo rp($data_anggota->total_tabungan * 3); ?>" disabled style="text-align:right">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label">Bunga perbulan</label>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-lg" value="<?php echo ($pengajuan->bunga); ?>%" style="text-align:right" disabled style="text-align:right">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label">Total Pinjaman</label>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-lg uang" value="<?php echo rp($pengajuan->total_pinjam); ?>" style="text-align:right" id="total_pinjaman">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label">Lama Angsuran</label>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-lg" value="<?php echo ($pengajuan->lama_angsuran); ?> bulan" disabled style="text-align:right">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="col-12">
            <h6>History Simpanan</h6>
            <span class="text-red">* berikut history transaksi simpanan dari maksimum 10x transaksi terakhir</span>
            <table class="table table-bordered table-hover" id="table-anggota" style="width:100%">
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                </tr>
                <?php foreach ($simpanan_anggota as $row) { ?>
                    <tr>
                        <td><?php echo tgl_indo($row->created_at, 'time'); ?></td>
                        <td class="text-right"><?php echo rp($row->jumlah_setor); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="col-12">
            <button class="btn btn-danger" id="loadBtn" onclick="approvePengajuan('tolak',  <?php echo $pengajuan->id; ?>)">Tolak</button>
            <button class="btn btn-primary float-right" id="loadBtn" onclick="approvePengajuan('terima', <?php echo $pengajuan->id; ?>)">Terima</button>
        </div>
    </div>
</div>