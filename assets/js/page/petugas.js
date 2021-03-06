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
                    var html = '<a href= "' + base_url + 'petugas/detail/' + rowData.id + '">' + rowData.id + '</a>'
                    $(td).html(html)
                }
            },
            { 'data': 'nama' },
            { 'data': 'phone' },
            { 'data': 'tgl_masuk' },
            { 'data': 'level' },
        ],
    });

    // $('#level').on('change', function() {
    //     table.ajax.reload();
    // });

    // $('#nomor_petugas').keyup(function() {
    //     table.ajax.reload();
    // });

    // $('#nama').keyup(function() {
    //     table.ajax.reload();
    // });

    // $(function() {
    //     $('#tgl_masuk, #tgl_lahir').datetimepicker({
    //         format: 'DD/MM/YYYY'
    //     });
    // });
});

// $.validator.setDefaults({
//     submitHandler: function() {
//         tombol_loading();
//         $.ajax({
//             type: 'POST',
//             url: base_url + 'anggota/tambah_anggota',
//             dataType: 'json',
//             data: $("#form_tambah_anggota").serialize(),
//             success: function(response) {
//                 // var obj = $.parseJSON(response);
//                 var obj = response;
//                 if (obj.code == '200') {
//                     // Toast.fire({
//                     //     icon: 'success',
//                     //     title: obj.message
//                     // });
//                     toastr.success(obj.message)
//                     $('#modalAnggota').modal('hide')
//                     table.ajax.reload();
//                     tombol_reset()
//                     $('#form_tambah_anggota').trigger("reset");
//                 } else {
//                     // Toast.fire({
//                     //     icon: 'error',
//                     //     title: obj.message,
//                     // })
//                     toastr.error(obj.message)
//                     tombol_reset()
//                 }
//             },
//             error: function() {
//                 toastr.error("Mohon maaf sistem sedang dalam perbaikan, silakan hubungi admin terkait masalah ini")
//             }
//         });
//     }
// });

// $("#form_tambah_anggota").validate({
//     lang: 'id',
//     rules: {
//         tgl_masuk: {
//             required: true,
//         },
//         nama_anggota: {
//             required: true,
//         },
//         alamat: {
//             required: true,
//         },
//         telp: {
//             required: true,
//         },
//         tempat_lahir: {
//             required: true,
//         },
//         tgl_lahir: {
//             required: true,
//         },
//         pekerjaan: {
//             required: true,
//         },
//         simpanan: {
//             required: true,
//         }
//     },
//     errorElement: 'span',
//     errorPlacement: function(error, element) {
//         error.addClass('invalid-feedback');
//         element.closest('.form-group').append(error);
//     },
// });