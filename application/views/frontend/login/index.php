<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?= base_url('assets/uploads/poltek.ico'); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><img src="<?= base_url('assets/uploads/poltek.png'); ?>" style="margin-bottom:10px"
                    class="img-fluid" width="120" /></a><br />
            <a href="#"><b>LAB HARDWARE</b><br />DIII Teknik Komputer</a>
        </div>
        <!-- /.login-logo -->

        <div class="flash-sukses" data-flashdata="<?= $this->session->flashdata('flash-sukses'); ?>"></div>
        <div class="flash-error" data-flashdata="<?= $this->session->flashdata('flash-error'); ?>"></div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Login</p>

                <form action="" onsubmit="ajax_login(); return false">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_login">
                    <div class="input-group mb-3">
                        <input type="text" id="username" name="username" class="form-control" placeholder="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="social-auth-links text-center mb-3">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                </form>


            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url(); ?>assets/admin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>assets/admin/dist/js/adminlte.min.js"></script>

    <script src="<?= base_url('assets/sweetalert/sweetalert2.js'); ?> "></script>
    <script src="<?= base_url('assets/sweetalert/new_script.js'); ?> "></script>

</body>

</html>

<script>
function ajax_login() {
    let username = $("#username").val();
    let password = $("#password").val();
    let csrfName = $("#csrf_login").attr('name');
    let csrfHash = $("#csrf_login").val();

    var dataJson = {
        [csrfName]: csrfHash,
        username: username,
        password: password
    };

    $.ajax({
        url: "<?= base_url('login/login'); ?>",
        type: "POST",
        data: dataJson,
        dataType: 'json',
        success: function(result) {
            let data = result;
            if (data.status == 'Valid') {

                Swal.fire({
                    title: 'Success',
                    text: 'Login Sukses',
                    icon: 'success'
                }).then((result) => {
                    if (result.value) {
                        setTimeout(function() {
                            if (data.role == 'dosen') {
                                document.location.href =
                                    "<?= base_url('dosen/beranda'); ?>";
                            } else {
                                document.location.href =
                                    "<?= base_url('mahasiswa/beranda'); ?>";
                            }

                        }, 500)
                    }
                });
            } else {
                Swal.fire({
                    title: 'Sorry !!',
                    text: data.status,
                    icon: 'warning'
                });

                $('#nim').val("");
                $('#password').val("");
                $("#csrf_login").val(result.token);
            }
        }
    });
}
</script>