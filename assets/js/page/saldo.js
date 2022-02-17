var table;
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.onload = function () {
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
            'data': function (data) {
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
            {
                'data': null,
                className: "text-center",
                createdCell: function (td, rowData) {
                    var html = '<a class="btn btn-warning btn-sm" data-toggle="modal" onclick="updateTotal(' + (rowData.id) + ')">ubah</a> \
                    <a class="btn btn-danger btn-sm" onclick="deleteSaldo(' + (rowData.id) + ')">hapus</a>'
                    $(td).html(html)
                }
            },
        ],
    });

    $('#description').keyup(function () {
        table.ajax.reload();
    });

    $(function () {
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
    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        error.appendTo(element.parent("td"));
    },
    submitHandler: function () {
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
        success: function (response) {
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
        error: function () {
            toastr.error("Mohon maaf sistem sedang dalam perbaikan, silakan hubungi admin terkait masalah ini")
        }
    });
}

function updateTotal(id) {
    console.log(id);
    $('#modalUpdate').modal('show')
    $('#idUpdate').val(id);
}

$("#form_update_saldo").validate({
    lang: 'id',
    ignore: [],
    rules: {
        "saldo": {
            required: true,
        },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        error.appendTo(element.parent("td"));
    },
    submitHandler: function () {
        updateSaldo();
    }
});

function updateSaldo() {
    tombol_loading();
    $.ajax({
        type: 'POST',
        url: base_url + 'saldo/update_transaksi',
        dataType: 'json',
        data: $("#form_update_saldo").serialize(),
        success: function (response) {
            var obj = response;
            if (obj.code == '200') {
                toastr.success(obj.message)
                $('#modalUpdate').modal('hide')
                $('#form_update_saldo').trigger("reset");
                table.ajax.reload();
                tombol_reset()
            } else {
                toastr.error(obj.message)
                tombol_reset()
            }
        },
        error: function () {
            toastr.error("Mohon maaf sistem sedang dalam perbaikan, silakan hubungi admin terkait masalah ini")
        }
    });
}

function deleteSaldo(id) {
    Swal.fire({
        title: 'Apa anda yakin?',
        // text: "Anda yakin ingin menghapus data?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batal!'
    }).then((result) => {
        if (result.value == true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'saldo/delete_transaksi/' + id,
                dataType: 'json',
                success: function (response) {
                    // window.location.href = base_url + 'saldo';
                    var obj = response;
                    if (obj.code == '200') {
                        toastr.success(obj.message)
                        table.ajax.reload();
                        tombol_reset()
                    } else {
                        toastr.error(obj.message)
                        tombol_reset()
                    }
                },
                error: function () { }
            });
        } else {
            $('#loadBtn').show();
        }
    })
}