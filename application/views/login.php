<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <link rel="shortcut icon" href="../logo_kop.gif">

    <title>Login Koperasi Simpan Pinjam Family</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/login/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>/assets/login/css/login.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/login/css/animate-custom.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url(); ?>/assets/login/js/jquery.min.js"></script>

</head>

<body>
    <div class="container" id="login-block">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">

                <div class="login-box clearfix animated flipInY">
                    <div class="login-logo">
                        <a href="#"><img class="img-responsive" src="<?php echo base_url(); ?>/assets/img/logo_kop.gif" width="150" height="150" alt="Company Logo" /></a>
                    </div>
                    <hr />
                    <div class="login-form">
                        <form id="formLogin">
                            <span class="loginGagal">Username dan password tidak cocok</span>
                            <!-- <input type="text" name="username" placeholder="Username" class="input-field" autofocus required /> -->
                            <div class="form-group">
                                <input type="text" class="form-control" name="nik" placeholder="NIK">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="Password" />
                            </div>
                            <button id="form_submit" type="submit" class="btn btn-login">Login</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Login box -->
    <footer class="container">
        <p id="footer-text">Copyright &copy; 2021 Koperasi Simpan Pinjam Family Banjaran </p>
    </footer>

    <script>
        window.jQuery || document.write('<script src="<?php echo base_url(); ?>/assets/login/js/jquery-1.9.1.min.js"><\/script>')
    </script>
    <script src="<?php echo base_url(); ?>/assets/login/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/login/js/placeholder-shim.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/login/js/custom.js"></script>
    <script src="<?php echo base_url('assets'); ?>/vendor/AdminLTE-3.0.5/plugins/jquery-validation/jquery.validate.min.js"></script>

    <script>
        var base_url = "<?php echo base_url(); ?>";
        $('.loginGagal').hide();
        $("#formLogin").validate({
            rules: {
                nik: "required",
                password: "required",
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'auth/login',
                    dataType: 'json',
                    data: $("#formLogin").serialize(),
                    success: function(response) {
                        var obj = response;
                        if (obj.code == '200') {
                            window.location.href = base_url + 'home';
                        } else {
                            $('.loginGagal').show();
                        }
                    },
                    error: function() {
                        alert('sistem bermasalah');
                    }
                });
            }
        });
    </script>
</body>

</html>