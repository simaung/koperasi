<div class="row">
    <?php if ($data_anggota->total_pinjam - $data_anggota->jumlah_angsuran > 0) { ?>
        <div class="col-6">
            <div class="col-12">
                <form class="form-horizontal" id="form_tambah_pengajuan" method="post" action="#">
                    <div class="card-body">
                        <input type="hidden" id="id_anggota" value="<?php echo $data_anggota->id; ?>">
                        <input type="hidden" id="id_pinjam" value="<?php echo $data_anggota->pinjam_id; ?>">
                        <input type="hidden" id="sisa_pinjaman" value="<?php echo $data_anggota->total_pinjam - $data_anggota->jumlah_angsuran; ?>">
                        <input type="hidden" id="tabungan" value="<?php echo (int)$data_anggota->total_tabungan; ?>">
                        <input type="hidden" id="sukarela" value="<?php echo (int)$data_anggota->sukarela; ?>">
                        <input type="hidden" id="jasa" value="<?php echo $data_anggota->jasa; ?>">

                        <div class="form-group row">
                            <label class="col-4 col-form-label text-danger">Sisa Pinjaman</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang text-danger" value="<?php echo rp($data_anggota->total_pinjam - $data_anggota->jumlah_angsuran); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Total Simpanan</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang" value="<?php echo rp($data_anggota->total_tabungan); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Total Pokok</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang" value="<?php echo rp($data_anggota->pokok); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Total Wajib</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang" value="<?php echo rp($data_anggota->wajib); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Total Sukarela</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang" value="<?php echo rp($data_anggota->sukarela); ?>" disabled>
                            </div>
                        </div>
                        <button type="button" class="btn btn-warning float-right" id="loadBtn" onclick="lunasinDariSimpanan()">Lunasin dari simpanan</button>
                    </div>
                </form>
                <div class="col-12" id="hitung"></div>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-6">
            <div class="col-12">
                <form class="form-horizontal" id="form_tambah_pengajuan" method="post" action="#">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Total Simpanan</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang" id="total_tabungan" value="<?php echo rp($data_anggota->total_tabungan); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Maksimum Pinjaman</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang" value="<?php echo ($data_anggota->total_tabungan * 3); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Bunga perbulan</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg" value="3%" style="text-align:right" disabled>
                                <input type="hidden" name="bunga" class="form-control form-control-lg" value="3" style="text-align:right">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Total Pinjaman</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang" id="change_total_pinjaman" value="0">
                                <input type="hidden" id="maksimum_pinjaman" value="<?php echo ($data_anggota->total_tabungan * 3); ?>">
                                <input type="hidden" class="form-control" id="total_pinjaman" name="total_pinjaman" value="0" required>
                                <input type="hidden" class="form-control" name="id_anggota" value="<?php echo $data_anggota->id; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Lama Angsuran</label>
                            <div class="col-8">
                                <select name="lama_angsuran" class="form-control">
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?> bulan</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right" id="loadBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
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
</div>

<script>
    $(".uang").inputmask('decimal', {
        'alias': 'numeric',
        'groupSeparator': '.',
        'autoGroup': true,
        'digits': 2,
        'radixPoint': ",",
        'digitsOptional': true,
        'allowMinus': true,
        'placeholder': '0'
    });

    $('#change_total_pinjaman').on('input', function() {
        $("#total_pinjaman").val($(this).val().replace(/\D/g, ''));
    });

    $("#form_tambah_pengajuan").validate({
        lang: 'id',
        ignore: [],
        rules: {
            total_pinjaman: {
                required: true,
                max: <?php echo ($data_anggota->total_tabungan * 3); ?>,
                min: 50000
            },
        },
        messages: {

        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        submitHandler: function(form) {
            tombol_loading();
            $.ajax({
                type: 'POST',
                url: base_url + 'pinjaman/tambah_pinjaman',
                dataType: 'json',
                data: $("#form_tambah_pengajuan").serialize(),
                success: function(response) {
                    var obj = response;
                    if (obj.code == '200') {
                        toastr.success(obj.message)
                        window.location.href = base_url + 'pinjaman';
                        // table.ajax.reload();
                        // tombol_reset()
                        // $('#form_tambah_pengajuan').trigger("reset");
                    } else {
                        toastr.error(obj.message)
                        tombol_reset()
                    }
                },
                error: function() {
                    toastr.error("Mohon maaf sistem sedang dalam perbaikan, silakan hubungi admin terkait masalah ini")
                }
            });
        },
    });
</script>