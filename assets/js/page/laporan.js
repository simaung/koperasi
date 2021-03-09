$(document).ready(function() {
    function hideRpt() {
        $('.rptAnggota').addClass('d-none');
        $('.rptSimpanan').addClass('d-none');
        $('.rptPinjaman').addClass('d-none');
    }
    $('#pilihLaporan').on("change", function() {
        hideRpt();
        opt = $(this).val();
        if (opt == 'anggota') {
            $('.rptAnggota').removeClass('d-none');
        } else if (opt == 'simpanan') {
            $('.rptSimpanan').removeClass('d-none');
        } else if (opt == 'pinjaman') {
            $('.rptPinjaman').removeClass('d-none');
        }
    });


});