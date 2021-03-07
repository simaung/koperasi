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
            "url": base_url + 'petugas/get_data_petugas',
            "type": "POST",
            'data': function(data) {
                data.nomor_petugas = $('#nomor_petugas').val();
                data.nama = $('#nama').val();
                data.level = $('#level').val();
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
            {
                'data': null,
                createdCell: function(td, rowData) {
                    var html = '<a href= "' + base_url + 'petugas/detail/' + rowData.nik + '">' + rowData.nik + '</a>'
                    $(td).html(html)
                },
            },
            { 'data': 'nama' },
            // { 'data': 'phone' },
            { 'data': 'tgl_masuk' },
            { 'data': 'level' },
            {
                'data': null,
                className: "text-center",
                createdCell: function(td, rowData) {
                    if (rowData.access_system == '0') {
                        var html = '<button class="btn btn-info btn-sm" onclick="updateAccess(' + rowData.id + ')">Berikan Akses</button>';
                    } else {
                        var html = '<button class="btn btn-danger btn-sm" onclick="updateAccess(' + rowData.id + ')">Cabut Akses</button>';
                    }
                    $(td).html(html)
                },
            },
        ],
    });

    if (authData != 'admin') {
        table.column(5).visible(false);
    }

    $('#level').on('change', function() {
        table.ajax.reload();
    });

    $('#nomor_petugas').keyup(function() {
        table.ajax.reload();
    });

    $('#nama').keyup(function() {
        table.ajax.reload();
    });

    // $(function() {
    //     $('#tgl_masuk, #tgl_lahir').datetimepicker({
    //         format: 'DD/MM/YYYY'
    //     });
    // });
});


$("#form_tambah_petugas").validate({
    lang: 'id',
    rules: {
        tgl_masuk: {
            required: true,
        },
        nik: {
            required: true,
        },
        nama_petugas: {
            required: true,
        },
        level: {
            required: true,
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
            url: base_url + 'petugas/tambah_petugas',
            dataType: 'json',
            data: $("#form_tambah_petugas").serialize(),
            success: function(response) {
                // var obj = $.parseJSON(response);
                var obj = response;
                if (obj.code == '200') {
                    // Toast.fire({
                    //     icon: 'success',
                    //     title: obj.message
                    // });
                    toastr.success(obj.message)
                    $('#modalPetugas').modal('hide')
                    table.ajax.reload();
                    tombol_reset()
                    $('#form_tambah_petugas').trigger("reset");
                } else {
                    // Toast.fire({
                    //     icon: 'error',
                    //     title: obj.message,
                    // })
                    toastr.error(obj.message)
                    tombol_reset()
                }
            },
            error: function() {
                toastr.error("Mohon maaf sistem sedang dalam perbaikan, silakan hubungi admin terkait masalah ini")
            }
        })
    }
});

function updateAccess(id) {
    $('#modalAccess').modal('show')
    $.ajax({
        type: 'POST',
        url: base_url + 'petugas/get_access_system/' + id,
        dataType: 'json',
        success: function(response) {
            $(".modal-access").html(response.view);
        },
        error: function() {
            toastr.error("Mohon maaf sistem sedang dalam perbaikan, silakan hubungi admin terkait masalah ini")
        }
    });
}

function prosesUpdateAccess(id, access_system) {
    var level = $('select[name=level] option').filter(':selected').val()
    $.ajax({
        type: 'POST',
        url: base_url + 'petugas/update_access_system/' + id,
        data: { access_system: access_system, level: level },
        dataType: 'json',
        success: function(response) {
            var obj = response;
            if (obj.code == '200') {
                toastr.success("Update access system berhasil.");
                table.ajax.reload();
                $('#modalAccess').modal('hide')
            } else {
                toastr.error("Update access system gagal.");
            }
        },
        error: function() {
            toastr.error("Mohon maaf sistem sedang dalam perbaikan, silakan hubungi admin terkait masalah ini");
            // $('#modalAccess').modal('show')
        }
    });
}