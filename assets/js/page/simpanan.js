var table;
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

$(document).ready(function() {
    table = $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": base_url + 'simpanan/get_data_simpanan',
            "type": "POST",
            'data': function(data) {
                data.nomor_anggota = $('#nomor_anggota').val();
                data.nama_anggota = $('#nama_anggota').val();
                // data.status_anggota = $('#status_anggota').val();

            },
        },
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": false,
        "bInfo": true,
        "bAutoWidth": true,
        "processing": true,
        "serverSide": true,
        // "dom": 'Bfrtip',
        "oLanguage": {
            "sZeroRecords": "Data tidak ditemukan !"
        },
        // "order": [
        //     [0, "desc"]
        // ],
        'columns': [
            { 'data': 'no' },
            { 'data': 'created_at' },
            {
                'data': null,
                createdCell: function(td, rowData) {
                    var html = '<a href= "' + base_url + 'anggota/detail/' + rowData.anggota_id + '">' + rowData.anggota_id + '</a><br>' + rowData.nama_anggota
                    $(td).html(html)
                }
            },
            {
                'data': 'pokok',
                className: "text-right"
            },
            {
                'data': 'wajib',
                className: "text-right"
            },
            {
                'data': 'sukarela',
                className: "text-right"
            },
            {
                'data': 'jumlah_setor',
                className: "text-right"
            },
        ],
    });

    table_anggota = $('#table-anggota').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": base_url + 'anggota/get_data_anggota',
            "type": "POST",
            'data': function(data) {
                data.nomor_anggota = $('#nomorAnggota').val();
                data.nama_anggota = $('#namaAnggota').val();
                data.status_anggota = $('#statusAnggota').val();

            },
        },
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": true,
        "bAutoWidth": true,
        "processing": true,
        "serverSide": true,
        "oLanguage": {
            "sZeroRecords": "Data tidak ditemukan !"
        },
        'columns': [{
                'data': 'no'
            },
            {
                'data': 'id'
            },
            {
                'data': 'nama_anggota'
            },
            {
                "data": null,
                createdCell: function(td, rowData) {
                    var html = '<button type="button" class="btn btn-xs btn-primary" onclick="getAnggota(' + rowData.id + ')">' +
                        '<i class="ion-checkmark"></i>' +
                        '</button>';
                    $(td).html(html)
                },
            }
        ],
    });

    $('#statusAnggota').on('change', function() {
        table_anggota.ajax.reload();
    });

    $('#nomorAnggota').keyup(function() {
        table_anggota.ajax.reload();
    });

    $('#namaAnggota').keyup(function() {
        table_anggota.ajax.reload();
    });

    $(function() {
        $('#tgl_masuk, #tgl_lahir').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });

});

function getDataAnggota() {
    table_anggota.ajax.reload();
    $('#modalAnggota').modal('show')
}

function getAnggota(id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'simpanan/get_data_anggota/' + id,
        dataType: 'json',
        success: function(response) {
            $("#data-anggota").html(response.view);
            $('#modalAnggota').modal('hide')
            $('#nomorAnggotaSearch').val(id + ' - ' + response.nama);
            $('#nomorAnggota').val('');
        },
        error: function() {
            $("#data-anggota").html('<a>papa</a>');
        }
    });
}

$("#form_tambah_simpanan").validate({
    lang: 'id',
    ignore: [],
    rules: {
        id_anggota: {
            required: true,
        },
        jumlah_setor: {
            required: true,
        },
        wajib: {
            required: true,
        },
        angsuran: {
            required: true,
        },
        sukarela: {
            required: true,
            min: 0
        },
    },
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    submitHandler: function() {
        tombol_loading();
        $.ajax({
            type: 'POST',
            url: base_url + 'simpanan/tambah_simpanan',
            dataType: 'json',
            data: $("#form_tambah_simpanan").serialize(),
            success: function(response) {
                var obj = response;
                if (obj.code == '200') {
                    toastr.success(obj.message)
                    $('#modalSimpanan').modal('hide')
                    table.ajax.reload();
                    tombol_reset()
                    $('#form_tambah_simpanan').trigger("reset");
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
});