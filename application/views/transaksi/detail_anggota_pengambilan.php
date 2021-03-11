<div class="row">
    <?php if ($data_anggota->total_pinjam - $data_anggota->jumlah_angsuran > 0) { ?>
        <div class="col-12">
            <div class="col-12">
                <h3>Tidak bisa mengambil simpanan</h3>
                <br>
                <h5>Anggota masih memiliki sisa pinjaman sebesar Rp. <?php echo rp($data_anggota->total_pinjam - $data_anggota->jumlah_angsuran); ?></h5>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-6">
            <div class="col-12">
                <form class="form-horizontal" id="form_pengambilan" method="post" action="#">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Total Simpanan</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-lg uang" id="total_tabungan" value="<?php echo rp($data_anggota->total_tabungan); ?>" disabled>
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
                        <button type="submit" class="btn btn-primary float-right" id="loadBtn">Simpan</button>
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