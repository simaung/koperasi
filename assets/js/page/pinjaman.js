var table;
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

$(document).ready(function() {
    $('data-pinjaman').html('baru');

    table = $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": base_url + 'pinjaman/get_data_pinjaman',
            "type": "POST",
            'data': function(data) {
                data.nomor_anggota = $('#nomor_anggota').val();
                data.nama_anggota = $('#nama_anggota').val();
                data.status_pengajuan = $('#status_pengajuan').val();

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
            { 'data': 'tgl_entry' },
            {
                'data': null,
                createdCell: function(td, rowData) {
                    var html = '<a href= "' + base_url + 'anggota/detail/' + rowData.anggota_id + '">' + rowData.anggota_id + '</a>'
                    $(td).html(html)
                }
            },
            { 'data': 'nama_anggota' },
            { 'data': 'total_pinjam', className: "text-right" },
            { 'data': 'lama_angsuran', className: "text-right" },
            { 'data': 'bunga', className: "text-right" },
            { 'data': 'tgl_persetujuan' },
            {
                'data': null,
                className: "text-center",
                createdCell: function(td, rowData) {
                    if (rowData.status_pengajuan == 'pending') {
                        var html = '<a class="btn btn-warning" data-toggle="modal" onclick="getDataPengajuan(' + rowData.id + ')"><i class="ion-eye"></i></a>'
                    } else if (rowData.status_pengajuan == 'tolak') {
                        var html = '<p class="text-danger">' + rowData.status_pengajuan + '</p>'
                    } else if (rowData.status_pengajuan == 'terima') {
                        var html = '<p class="text-success">' + rowData.status_pengajuan + '</p>'
                    }
                    $(td).html(html)
                }
            },
            {
                'data': null,
                className: "text-center",
                createdCell: function(td, rowData) {
                    if (rowData.status_ambil == 'pending' && rowData.status_pengajuan == 'terima') {
                        var html = '<a class="btn btn-success" data-toggle="modal" onclick="ambil_pinjaman(' + rowData.id + ')"><i class="ion-checkmark"></i></a>'
                    } else if (rowData.status_pengajuan == 'pending') {
                        var html = '-'
                    } else {
                        var html = '<p class="text-success">Sudah</p>'
                    }
                    $(td).html(html)
                }
            },
        ],
    });

    $('#status_pengajuan').on('change', function() {
        table.ajax.reload();
    });

    $('#nomor_anggota').keyup(function() {
        table.ajax.reload();
    });

    $('#nama_anggota').keyup(function() {
        table.ajax.reload();
    });

    table_anggota = $('#table-anggota').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": base_url + 'anggota/get_data_anggota/aktif',
            "type": "POST",
            'data': function(data) {
                data.nomor_anggota = $('#nomorAnggota').val();
                data.nama_anggota = $('#namaAnggota').val();
                data.status_anggota = $('#statusAnggota').val();

            },
        },
        "bPaginate": true,
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
        url: base_url + 'pinjaman/get_data_anggota/' + id,
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

function getDataPengajuan(id) {
    $('#modalPengajuan').modal('show')
    $.ajax({
        type: 'POST',
        url: base_url + 'pinjaman/get_data_pengajuan/' + id,
        dataType: 'json',
        success: function(response) {
            $("#data-pengajuan").html(response.view);
        },
        error: function() {
            $("#data-pengajuan").html('<a>papa</a>');
        }
    });
}

function approvePengajuan(status, id) {
    total_pinjaman = $('#total_pinjaman').val();
    total_pinjaman = total_pinjaman.replace(/\D+/g, '');
    $.ajax({
        type: 'POST',
        url: base_url + 'pinjaman/approve_pengajuan/',
        data: { status: status, id: id, total_pinjaman: total_pinjaman },
        dataType: 'json',
        success: function(response) {
            // $('#modalPengajuan').modal('hide')
            window.location.href = base_url + 'pinjaman';
        },
        error: function() {}
    });
}

function ambil_pinjaman(id) {
    $('#biayaAdmin').modal('show')
    $('.idPengajuan').val(id);
}

function proses_ambil() {
    var id = $('.idPengajuan').val();
    var provisi = $('.biayaAdmin').val();
    provisi = provisi.replace(/\D+/g, '');

    $.ajax({
        type: 'POST',
        url: base_url + 'pinjaman/ambil_pinjaman/',
        data: { id: id, provisi: provisi },
        dataType: 'json',
        success: function(response) {
            var obj = response;
            toastr.success(obj.message)
            window.location.href = base_url + 'pinjaman';
        },
        error: function(response) {
            toastr.error("Mohon maaf sistem sedang dalam perbaikan, silakan hubungi admin terkait masalah ini")
        }
    });
}

function lunasinDariSimpanan() {
    $('#loadBtn').hide();
    var id_anggota = $('#id_anggota').val();
    var id_pinjam = $('#id_pinjam').val();
    var pinjaman = parseInt($('#sisa_pinjaman').val());
    var tabungan = parseInt($('#tabungan').val());
    var sukarela = parseInt($('#sukarela').val());
    var jasa = parseInt($('#jasa').val());

    if (tabungan <= pinjaman) {
        kurang = pinjaman - tabungan;
        total = kurang + jasa;
        status = 'keluar';

        totalKurang = formatRibuan(kurang);
        totalJasa = formatRibuan(jasa);
        totalBayar = formatRibuan(total);

        result = '<div class="alert alert-danger alert-dismissible">' +
            'Pelunasan dengan simpanan, otomatis akan menonaktifkan keanggotaan anda!' +
            '</div>' +
            '<div class="form-group row">' +
            '<label class="col-4 col-form-label">Kekurangan Bayar</label>' +
            '<div class="col-8">' +
            '<input type="text" class="form-control form-control-lg text-right" value="' + totalKurang + '" disabled>' +
            '</div>' +
            '</div>' +
            '<div class="form-group row">' +
            '<label class="col-4 col-form-label">Jasa</label>' +
            '<div class="col-8">' +
            '<input type="text" class="form-control form-control-lg text-right" value="' + totalJasa + '" disabled>' +
            '</div>' +
            '</div>' +
            '<div class="form-group row">' +
            '<label class="col-4 col-form-label">Total Tambah Bayar</label>' +
            '<div class="col-8">' +
            '<input type="text" class="form-control form-control-lg text-right" value="' + totalBayar + '" disabled>' +
            '</div>' +
            '</div>' +
            '<button type="button" class="btn btn-warning float-right" id="loadBtn" onclick="prosesLunas(' + id_anggota + ',' + id_pinjam + ', \'' + status + '\' ,' + kurang + ',' + jasa + ',' + total + ',' + tabungan + ')">Proses</button>'
        $("#hitung").html(result);
    } else if (sukarela >= (pinjaman + jasa)) {
        status = 'aktif';

        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Anda yakin ingin melunasi pinjaman dengan saldo sukarela?",
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
                    url: base_url + 'pinjaman/pelunasan_pinjaman/',
                    data: { id_anggota: id_anggota, id_pinjam: id_pinjam, status: status, sukarela: sukarela, jasa: jasa, pinjaman: pinjaman },
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = base_url + 'pinjaman';
                    },
                    error: function() {}
                });
            } else {
                $('#loadBtn').show();
            }
        })
    }
}

function formatRibuan(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++)
        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
}

function prosesLunas(id_anggota, id_pinjam, status, kurang, jasa, total, tabungan) {
    Swal.fire({
        title: 'Apa anda yakin?',
        text: "Dengan melunasi pinjaman dengan seluruh tabungan, otomatis keanggotaaan di nonaktifkan!",
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
                url: base_url + 'pinjaman/pelunasan_pinjaman/',
                data: { id_anggota: id_anggota, id_pinjam: id_pinjam, status: status, kurang: kurang, jasa: jasa, total: total, tabungan: tabungan },
                dataType: 'json',
                success: function(response) {
                    window.location.href = base_url + 'pinjaman';
                },
                error: function() {}
            });
        }
    })

}