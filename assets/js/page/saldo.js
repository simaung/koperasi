var table;
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.onload = function() {
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


    table = $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": base_url + 'saldo/get_data_saldo',
            "type": "POST",
            'data': function(data) {
                // data.description = $('#description').val();
            },
        },
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": false,
        "bInfo": true,
        "bAutoWidth": true,
        "processing": true,
        "serverSide": true,
        "oLanguage": {
            "sZeroRecords": "Data tidak ditemukan !"
        },
        'columns': [
            { 'data': 'no' },
            { 'data': 'tanggal' },
            { 'data': 'saldo', className: "text-right" },
        ],
    });

    $('#description').keyup(function() {
        table.ajax.reload();
    });

    $(function() {
        $('#tgl_masuk, #tgl_lahir').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });

};

$("#form_tambah_saldo").validate({
    lang: 'id',
    ignore: [],
    rules: {
        "tanggal": {
            required: true,
        },
        "saldo": {
            required: true,
        },
    },
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        error.appendTo(element.parent("td"));
    },
    submitHandler: function() {
        simpanSaldo();
    }
});

function simpanSaldo() {
    tombol_loading();
    $.ajax({
        type: 'POST',
        url: base_url + 'saldo/tambah_transaksi',
        dataType: 'json',
        data: $("#form_tambah_saldo").serialize(),
        success: function(response) {
            var obj = response;
            if (obj.code == '200') {
                toastr.success(obj.message)
                $('#modalSaldo').modal('hide')
                $('#form_tambah_saldo').trigger("reset");
                table.ajax.reload();
                tombol_reset()
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