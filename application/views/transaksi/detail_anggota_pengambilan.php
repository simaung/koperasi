<div class="row">
    <?php if ($data_anggota->total_pinjam - $data_anggota->jumlah_angsuran > 0) { ?>
        <div class="col-6">
            <div class="col-12">
                <form class="form-horizontal" id="form_pengambilan" method="post" action="#">
                    <?php
                    $total_bayar_pinjaman =  $data_anggota->jasa + ($data_anggota->total_pinjam - $data_anggota->jumlah_angsuran);
                    $sisa_simpanan_sukarela = $data_anggota->sukarela - $total_bayar_pinjaman;
                    $sisa_total_simpanan = $data_anggota->total_tabungan - $total_bayar_pinjaman;
                    ?>

                    <div class="card-body">
                        <input type="hidden" id="id_anggota" value="<?php echo $data_anggota->id; ?>">
                        <input type="hidden" id="id_pinjam" value="<?php echo $data_anggota->pinjam_id; ?>">
                        <input type="hidden" id="sisa_pinjaman" value="<?php echo $data_anggota->total_pinjam - $data_anggota->jumlah_angsuran; ?>">
                        <input type="hidden" id="tabungan" value="<?php echo (int)$data_anggota->total_tabungan; ?>">
                        <input type="hidden" id="sukarela" value="<?php echo (int)$data_anggota->sukarela; ?>">
                        <input type="hidden" id="jasa" value="<?php echo $data_anggota->jasa; ?>">
                        <input type="hidden" id="sisa_simpanan_sukarela" value="<?php echo $sisa_simpanan_sukarela; ?>">
                        <input type="hidden" id="sisa_total_simpanan" value="<?php echo $sisa_total_simpanan; ?>">

                        <div class="form-group row">
                            <label class="col-4 col-form-label text-danger">Sisa Pinjaman</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang text-danger" value="<?php echo rp($data_anggota->total_pinjam - $data_anggota->jumlah_angsuran); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label text-danger">Jasa</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang text-danger" value="<?php echo rp($data_anggota->jasa); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label text-danger">Total Bayar Pinjaman</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang text-danger" value="<?php echo rp($total_bayar_pinjaman); ?>" disabled>
                            </div>
                        </div>
                        <hr>
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
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Total Simpanan</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang" value="<?php echo rp($data_anggota->total_tabungan); ?>" disabled>
                            </div>
                        </div>
                        <hr>
                        <?php if ($sisa_total_simpanan <= 0) { ?>
                            <div class="form-group row">
                                <label class="col-4 col-form-label text-danger">Kurang Bayar</label>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-lg uang text-danger" value="<?php echo rp($total_bayar_pinjaman - $data_anggota->total_tabungan); ?>" disabled>
                                </div>
                            </div>
                            <button type="button" class="btn btn-warning btn-block" id="loadBtn" onclick="lunasinDariSimpanan()">Lunasin pinjaman bayar kekurangan dan keluar dari keanggotaan</button>
                        <?php } else { ?>
                            <span class="text-danger">maksimum ambil simpanan sukarela <b>Rp. <?php echo rp($sisa_simpanan_sukarela); ?></b></span><br>
                            <span class="text-danger">maksimum ambil total simpanan <b>Rp. <?php echo rp($sisa_total_simpanan); ?></b> (keanggotaan otomatis nonaktif)</span>
                            <br>
                            <br>
                            <div class="form-group row">
                                <label class="col-4 col-form-label">Total Pengambilan</label>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-lg uang" id="total_pengambilan" value="0">
                                </div>
                            </div>
                            <button type="button" class="btn btn-warning btn-block" id="loadBtn" onclick="lunasinDariSimpanan()">Lunasin pinjaman dan ambil simpanan</button>
                        <?php } ?>
                    </div>
                </form>
                <div class="col-12" id="hitung"></div>
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
    <?php } else { ?>
        <div class="col-6">
            <div class="col-12">
                <form class="form-horizontal" id="form_pengambilan" method="post" action="#">
                    <div class="card-body">
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
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Total Simpanan</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang" value="<?php echo rp($data_anggota->total_tabungan); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Total Pengambilan</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang" id="change_total_pengambilan" value="0">
                                <input type="hidden" class="form-control" id="total_pengambilan" name="total_pengambilan" value="0" required>
                                <input type="hidden" class="form-control" id="total_simpanan" name="total_simpanan" value="<?php echo $data_anggota->total_tabungan; ?>">
                                <input type="hidden" class="form-control" name="id_anggota" value="<?php echo $data_anggota->id; ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" id="loadBtn">Ambil Simpanan</button>
                    </div>
                </form>
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
    <?php } ?>
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

    $('#change_total_pengambilan').on('input', function() {
        $("#total_pengambilan").val($(this).val().replace(/\D/g, ''));
    });

    $("#form_pengambilan").validate({
        lang: 'id',
        ignore: [],
        rules: {
            total_pengambilan: {
                required: true,
                max: <?php echo ($data_anggota->total_tabungan); ?>,
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
            total_simpanan = Math.floor($('#total_simpanan').val());
            total_pengambilan = $('#total_pengambilan').val();

            if (total_pengambilan == total_simpanan) {
                Swal.fire({
                    title: 'Apa anda yakin?',
                    text: "Dengan mengambil semua tabungan, otomatis keanggotaaan di nonaktifkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!',
                    cancelButtonText: 'Batal!'
                }).then((result) => {
                    if (result.value == true) {
                        proses_pengambilan();
                    }
                })
            } else {
                proses_pengambilan();
            }
        },
    });


    function proses_pengambilan() {
        tombol_loading();
        $.ajax({
            type: 'POST',
            url: base_url + 'pengambilan/tambah_pengambilan',
            dataType: 'json',
            data: $("#form_pengambilan").serialize(),
            success: function(response) {
                var obj = response;
                if (obj.code == '200') {
                    toastr.success(obj.message)
                    window.location.href = base_url + 'pengambilan';
                } else {
                    toastr.error(obj.message)
                    tombol_reset()
                }
            },
            error: function() {
                toastr.error("Mohon maaf sistem sedang dalam perbaikan, silakan hubungi admin terkait masalah ini")
            }
        });
    }
</script>