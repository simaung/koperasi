var table;
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

$(document).ready(function() {
    $('.btn-hide').hide();

    table = $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": base_url + 'anggota/get_data_anggota',
            "type": "POST",
            'data': function(data) {
                data.nomor_anggota = $('#nomor_anggota').val();
                data.nama_anggota = $('#nama_anggota').val();
                data.status_anggota = $('#status_anggota').val();

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
            {
                'data': null,
                createdCell: function(td, rowData) {
                    var html = '<a href= "' + base_url + 'anggota/detail/' + rowData.id + '">' + rowData.id + '</a>'
                    $(td).html(html)
                }
            },
            { 'data': 'nama_anggota' },
            { 'data': 'alamat_anggota' },
            { 'data': 'tgl_masuk' },
            { 'data': 'status' },
        ],
    });

    $('#status_anggota').on('change', function() {
        table.ajax.reload();
    });

    $('#nomor_anggota').keyup(function() {
        table.ajax.reload();
    });

    $('#nama_anggota').keyup(function() {
        table.ajax.reload();
    });

    $(function() {
        $('#tgl_masuk, #tgl_lahir').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });
});

function reloadAjax() {
    table.ajax.reload();
}

$.validator.setDefaults({
    submitHandler: function() {
        tombol_loading();
        $.ajax({
            type: 'POST',
            url: base_url + 'anggota/tambah_anggota',
            dataType: 'json',
            data: $("#form_tambah_anggota").serialize(),
            success: function(response) {
                // var obj = $.parseJSON(response);
                var obj = response;
                if (obj.code == '200') {
                    // Toast.fire({
                    //     icon: 'success',
                    //     title: obj.message
                    // });
                    toastr.success(obj.message)
                    $('#modalAnggota').modal('hide')
                    table.ajax.reload();
                    tombol_reset()
                    $('#form_tambah_anggota').trigger("reset");
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
        });
    }
});

$("#form_tambah_anggota").validate({
    lang: 'id',
    rules: {
        tgl_masuk: {
            required: true,
        },
        nama_anggota: {
            required: true,
        },
        alamat: {
            required: true,
        },
        telp: {
            required: true,
        },
        tempat_lahir: {
            required: true,
        },
        tgl_lahir: {
            required: true,
        },
        pekerjaan: {
            required: true,
        },
        simpanan: {
            required: true,
        }
    },
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
});

function pengajuanKeluar(id) {
    var pinjaman = $('.total_pinjaman').val().replace(/\D[^\.]/g, "");;
    if (pinjaman > 0) {
        toastr.error('Proses pengajuan keluar gagal!<br>Anggota masih memiliki pinjaman yang belum lunas.');
    } else {
        toastr.success('Proses pengajuan keluar berhasil!<br>Proses selanjutnya menunggu persetujuan dari ketua.');
    }
}

function editAnggota(id) {
    // preventDefault();
    $('.btn-show').hide();
    $('.btn-hide').show();
    $('.editable').prop("disabled", false);
}

$(".btn-batal").on("click", function() {
    $('.btn-show').show();
    $('.btn-hide').hide();
    $('.editable').prop("disabled", true);
});