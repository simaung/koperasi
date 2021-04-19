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
            "url": base_url + 'pengambilan/get_data_pengambilan',
            "type": "POST",
            'data': function(data) {
                data.nomor_anggota = $('#nomor_anggota').val();
                data.nama_anggota = $('#nama_anggota').val();

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
            { 'data': 'tgl_ambil' },
            {
                'data': null,
                createdCell: function(td, rowData) {
                    var html = '<a href= "' + base_url + 'anggota/detail/' + rowData.anggota_id + '">' + rowData.anggota_id + '</a>'
                    $(td).html(html)
                }
            },
            { 'data': 'nama_anggota' },
            { 'data': 'total_ambil', className: "text-right" },
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
        url: base_url + 'pengambilan/get_data_anggota/' + id,
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
    $.ajax({
        type: 'POST',
        url: base_url + 'pinjaman/ambil_pinjaman/',
        data: { id: id },
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
    // $('#loadBtn').hide();
    var id_anggota = $('#id_anggota').val();
    var id_pinjam = $('#id_pinjam').val();
    var pinjaman = parseInt($('#sisa_pinjaman').val());
    var tabungan = parseInt($('#tabungan').val());
    var sukarela = parseInt($('#sukarela').val());
    var jasa = parseInt($('#jasa').val());
    var sisa_simpanan_sukarela = parseInt($('#sisa_simpanan_sukarela').val());
    var sisa_total_simpanan = parseInt($('#sisa_total_simpanan').val());

    if (tabungan <= (pinjaman + jasa)) {
        status = 'keluar';
        Swal.fire({
                title: 'Apa anda yakin?',
                text: "Anda yakin ingin melunasi pinjaman dengan tabungan serta keluar dari keanggotaan?",
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
                        url: base_url + 'pengambilan/pelunasan_pinjaman/',
                        data: { id_anggota: id_anggota, id_pinjam: id_pinjam, status: status, pinjaman: pinjaman, jasa: jasa, sukarela: sukarela, tabungan: tabungan },
                        dataType: 'json',
                        success: function(response) {
                            window.location.href = base_url + 'pengambilan';
                        },
                        error: function() {}
                    });
                } else {
                    $('#loadBtn').show();
                }
            })
            // kurang = pinjaman - tabungan;
            // total = kurang + jasa;
            // status = 'keluar';

        // totalKurang = formatRibuan(kurang);
        // totalJasa = formatRibuan(jasa);
        // totalBayar = formatRibuan(total);
    } else if (sukarela >= (pinjaman + jasa)) {
        var total_ambil = parseInt($('#total_pengambilan').val().replace(/\D+/g, ''));
        if (total_ambil <= sisa_simpanan_sukarela) {
            status = 'sukarela';
            Swal.fire({
                title: 'Apa anda yakin?',
                text: "Anda yakin ingin melunasi pinjaman dengan saldo sukarela? lalu ambil simpanan sebesar Rp. " + total_ambil,
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
                        url: base_url + 'pengambilan/pelunasan_pinjaman/',
                        data: { id_anggota: id_anggota, id_pinjam: id_pinjam, status: status, sisa_simpanan_sukarela: sisa_simpanan_sukarela, pinjaman: pinjaman, jasa: jasa, total_ambil: total_ambil },
                        dataType: 'json',
                        success: function(response) {
                            window.location.href = base_url + 'pengambilan';
                        },
                        error: function() {}
                    });
                } else {
                    $('#loadBtn').show();
                }
            })
        } else if (total_ambil > sisa_simpanan_sukarela && total_ambil < sisa_total_simpanan) {
            console.log('gagal proses');
        } else if (total_ambil > sisa_total_simpanan) {
            console.log('pengambilan melebihi simpanan');
        } else {
            console.log('keluar anggota');
        }
        result = '';
        $("#hitung").html(result);
    }
}

function formatRibuan(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++)
        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
}