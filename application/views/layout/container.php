<!doctype html>
<html lang="en">

<head>
    <?= $meta ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <!-- <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jqvmap/jqvmap.min.css"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/daterangepicker/daterangepicker.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/toastr/toastr.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/summernote/summernote-bs4.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">


</head>

<body class="hold-transition sidebar-mini layout-fixed text-xs">
    <div class="wrapper">
        <?= $header ?>
        <?= $mainsidebar ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?= $content ?>
        </div>
        <?= $sidebar ?>
        <!-- /.content-wrapper -->
        <!-- <?= $footer ?> -->

    </div>
    <!-- ./wrapper -->


    <!-- jQuery -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <!-- <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
    <!-- jQuery Knob Chart -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- InputMask -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/moment/moment.min.js"></script>
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Select2 -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/select2/js/select2.full.min.js"></script>
    <!-- Toastr -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/dist/js/pages/dashboard.js"></script> -->

    <!-- jQuery Validations -->
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery-validation/jquery.validate.js"></script>
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery-validation/localization/messages_id.min.js"></script>

    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>


    <?php
    if (!empty($js)) { ?>
        <script type="text/javascript">
            var base_url = "<?php echo base_url(); ?>";
            var authData = "<?php echo $this->authData['level']; ?>";


            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            function tombol_loading() {
                $('#loadBtn').prop("disabled", true);
                $('#loadBtn').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                );
            }

            function tombol_reset() {
                $('#loadBtn').prop("disabled", false);
                $('#loadBtn').html(
                    'Simpan'
                );
            }

            $('[data-mask]').inputmask();

            $(".uang").inputmask('decimal', {
                'alias': 'numeric',
                'groupSeparator': '.',
                'autoGroup': true,
                'digits': 2,
                'radixPoint': ",",
                'digitsOptional': true,
                'allowMinus': false,
                'prefix': 'Rp. ',
                'placeholder': '0'
            });

            $(".tanggal_fmt").inputmask('99/99/9999', {
                'placeholder': '*'
            });
        </script>
        <script type="text/javascript" src="<?php echo base_url($js) ?>"></script>
    <?php } ?>
</body>

</html>