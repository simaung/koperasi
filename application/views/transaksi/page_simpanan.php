<div class="row">
    <?php
    $sisa_pinjaman = $data_anggota->total_pinjam - $data_anggota->jumlah_angsuran;
    $jasa = $sisa_pinjaman * $data_anggota->bunga / 100;
    ?>
    <input type="hidden" class="form-control" name="pinjam_id" value="<?php echo $data_anggota->pinjam_id; ?>">
    <div class="col-4">
        <div class="col-12">
            <div class="form-group">
                <label for="sisa_pinjaman" class="col-form-label">Sisa Pinjaman :</label>
                <input type="text" class="form-control uang" value="<?php echo $sisa_pinjaman; ?>" disabled>
                <input type="hidden" class="form-control" name="sisa_pinjaman" value="<?php echo $sisa_pinjaman; ?>">
                <input type="hidden" class="form-control" name="id_anggota" value="<?php echo $data_anggota->id; ?>">
                <input type="hidden" class="form-control" id="nama_anggota" value="<?php echo $data_anggota->nama_anggota; ?>">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="col-12">
            <div class="form-group">
                <label for="jasa" class="col-form-label">Jasa :</label>
                <input type="text" class="form-control uang" value="<?php echo $jasa; ?>" disabled>
                <input type="hidden" class="form-control" name="jasa" value="<?php echo $jasa; ?>">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="col-12">
            <div class="form-group">
                <label for="wajib" class="col-form-label">Wajib :</label>
                <input type="text" class="form-control wajib uang" value="<?php echo $wajib; ?>" disabled>
                <input type="hidden" class="form-control wajib" name="wajib" value="<?php echo $wajib; ?>">
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="col-12">
            <div class="form-group">
                <label for="jml_setor" class="col-form-label">Jumlah Setor : </label>
                <input type="text" class="form-control form-control-lg uang" id="jumlah_setor" placeholder=0 style="font-weight:bold;">
                <input type="hidden" class="form-control form-control-lg uang" name="jumlah_setor" id="jumlah_setor_hidden" placeholder=0 style="font-weight:bold;">
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="col-12">
            <div class="form-group">
                <label for="angsuran" class="col-form-label">Angsuran :</label>
                <input type="text" class="form-control form-control-lg uang" id="angsuran" value=0 style="font-weight:bold;" disabled>
                <input type="hidden" class="form-control form-control-lg" name="angsuran" id="angsuran_hidden" value=0 style="font-weight:bold;">
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="col-12">
            <div class="form-group">
                <label for="sukarela" class="col-form-label">Sukarela : </label>
                <input type="text" class="form-control form-control-lg sukarela uang" value=0 disabled>
                <input type="hidden" class="form-control sukarela" name="sukarela" id="sukarela" value=0>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary" id="loadBtn">Simpan</button>
</div>


<script>
    var sisa_pinjaman = <?php echo $sisa_pinjaman; ?>;
    var jasa = <?php echo $jasa; ?>;
    var wajib = <?php echo $wajib; ?>;

    var min_angsuran = jasa + wajib;

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

    if (sisa_pinjaman <= 0) {
        $('label[for="angsuran"]').hide();
        $('#angsuran').prop('hidden', true);
    }

    $('#jumlah_setor').on('input', function() {
        var setor = $("#jumlah_setor").val();
        var setor = setor.replace(/\D/g, '');

        var angsuran = setor - min_angsuran;
        var sukarela = setor - min_angsuran - angsuran;

        if (sisa_pinjaman > 0) {
            if (setor > min_angsuran) {
                $('#angsuran').prop('disabled', false);
                $('#angsuran').val(angsuran);

                $('#angsuran_hidden').val(angsuran);

                var sukarela = setor - min_angsuran - angsuran;
                $('.sukarela').val(sukarela);
            } else {
                $('#angsuran').prop('disabled', true);
                $('#angsuran').val(angsuran);
            }
        } else {
            var sukarela = setor - wajib;
            $('.sukarela').val(sukarela);
        }
        $('#jumlah_setor_hidden').val(setor);
    });

    $('#angsuran').on('input', function() {
        var setor = $("#jumlah_setor").val();
        var angsuran = $("#angsuran").val();

        var setor = setor.replace(/\D/g, '');
        var angsuran = angsuran.replace(/\D/g, '');
        var sukarela = (setor - min_angsuran) - angsuran;

        $('#angsuran_hidden').val(angsuran);
        $('.sukarela').val(sukarela);
    });
</script>