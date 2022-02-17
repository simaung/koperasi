$(document).ready(function () {
    $('.reservation').daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY',
            cancelLabel: 'Clear'
        }
    });

    $('.reservation').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('.reservation').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    table_anggota = $('#table-anggota').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": base_url + 'anggota/get_data_anggota/aktif',
            "type": "POST",
            'data': function (data) {
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
            createdCell: function (td, rowData) {
                var html = '<button type="button" class="btn btn-xs btn-primary" onclick="getAnggota(' + rowData.id + ')">' +
                    '<i class="ion-checkmark"></i>' +
                    '</button>';
                $(td).html(html)
            },
        }
        ],
    });

    $('#nomorAnggota').keyup(function () {
        table_anggota.ajax.reload();
    });

    $('#namaAnggota').keyup(function () {
        table_anggota.ajax.reload();
    });

    function hideRpt() {
        $('.rptAnggota').addClass('d-none');
        $('.rptTransaksi').addClass('d-none');
        $('.rptSimpanan').addClass('d-none');
        $('.rptPinjaman').addClass('d-none');
        $('.rptKasKeuangan').addClass('d-none');
    }
    $('#pilihLaporan').on("change", function () {
        hideRpt();
        opt = $(this).val();
        if (opt == 'anggota') {
            $('.rptAnggota').removeClass('d-none');
        } else if (opt == 'transaksi') {
            $('.rptTransaksi').removeClass('d-none');
        } else if (opt == 'simpanan') {
            $('.rptSimpanan').removeClass('d-none');
        } else if (opt == 'pinjaman') {
            $('.rptPinjaman').removeClass('d-none');
        } else if (opt == 'kas') {
            $('.rptKasKeuangan').removeClass('d-none');
        }
    });

    $('.btnClear').on('click', function () {
        $('.nomorAnggotaSearch').val('');
        $('.id_anggota').val('');
        $('#modalAnggota').modal('hide')
    });
});

function getDataAnggota() {
    table_anggota.ajax.reload();
    $('#modalAnggota').modal('show')
}

function getAnggota(id) {
    // $(".id_anggota").val(id);
    // $('#modalAnggota').modal('hide')

    $.ajax({
        type: 'POST',
        url: base_url + 'simpanan/get_data_anggota/' + id,
        dataType: 'json',
        success: function (response) {
            // $("#data-anggota").html(response.view);
            $('#modalAnggota').modal('hide')
            $('.nomorAnggotaSearch').val(id + ' - ' + response.nama);
            $('#nomorAnggota').val('');
            $('.id_anggota').val(id);
        },
        error: function () {
            // $("#data-anggota").html('<a>papa</a>');
        }
    });
}