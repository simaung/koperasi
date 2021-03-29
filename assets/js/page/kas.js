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
            "url": base_url + 'kas/get_data_kas',
            "type": "POST",
            'data': function(data) {
                data.description = $('#description').val();
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
            { 'data': 'tgl_entry' },
            { 'data': 'description' },
            { 'data': 'debet', className: "text-right" },
            { 'data': 'kredit', className: "text-right" },
        ],
    });

    $('#description').keyup(function() {
        table.ajax.reload();
    });

};

function tambahTransaksi() {
    var html = '';
    html += '<tr id="inputFormRow">';
    html += '<td><input type="text" name="description[]" class="form-control"></td>';
    html += '<td><input type="text" name="debet[]" class="form-control uang" placeholder="0"></td>';
    html += '<td><input type="text" name="kredit[]" class="form-control uang" placeholder="0"></td>';
    html += '<td class="text-center"><button id="removeRow" type="button" class="btn btn-danger">-</button></td>';
    html += '</tr>';
    $('#tableKas').append(html);

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
}

$(document).on('click', '#removeRow', function() {
    $(this).closest('#inputFormRow').remove();
});

$("#form_tambah_kas").validate({
    lang: 'id',
    ignore: [],
    rules: {
        "description[]": {
            required: true,
        },
    },
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        error.appendTo(element.parent("td"));
    },
    submitHandler: function() {
        simpanTransaksiKas();
    }
});

function simpanTransaksiKas() {
    tombol_loading();
    $.ajax({
        type: 'POST',
        url: base_url + 'kas/tambah_transaksi',
        dataType: 'json',
        data: $("#form_tambah_kas").serialize(),
        success: function(response) {
            var obj = response;
            if (obj.code == '200') {
                toastr.success(obj.message)
                $('#modalKas').modal('hide')
                $('#inputFormRow').remove();
                $('#form_tambah_kas').trigger("reset");
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