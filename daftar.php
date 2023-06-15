<?php
session_start();
require 'fungsi/fungsi.php';

if (isset($_POST["reg"])) {
    if (daftar($_POST) > 0) {
        $berhasil = true;
    } else {
        $gagal = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>halaman login</title>
    <link rel="icon" href="image/logo.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="login-dark text-center">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 text-center" style="margin-top: 35px;">
                <?php if (isset($berhasil)): ?>
                    <div class="alert alert-success" role="alert">
                        Username dan password terdaftar, silahkan <a href="login.php"
                            style="color: #e63946 !important;">login</a>
                    </div>
                <?php elseif (isset($gagal)): ?>
                    <div class="alert alert-danger" role="alert">
                        Data tidak berhasil terdaftar !
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <form name="formlogin" action="" method="post">
            <img src="./image/logo2.png" class="icon" alt="..."><br>
            <p class="navbar-brand jud" style="padding: 0px 47px 0px;">Sabana<span>.</span>adv</p>
            <div class="form-group"><input class="form-control" type="text" name="nama" placeholder="Nama">
            </div>
            <div class="form-group"><input class="form-control" type="text" name="no_hp" placeholder="Nomor HP">
            </div>
            <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username">
            </div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password">
            </div>
            <div class="form-group"><input class="form-control" type="password" name="passwordConfirm"
                    placeholder="Konfirmasi password">
            </div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="reg">
                    <h6 class="log">DAFTAR</h6>
                </button></div>
            <h6 style="color: antiquewhite; margin-top: 28px !important;">sudah punya akun ? <a href="login.php"
                    style="color: #e63946 !important;">login</a></h6>
        </form>
    </div>

    <footer class="text-center">
        <div class="text-center p-3">
            © 2022 Copyright:
            <a class="text-white" href="#">sabanaadv.com</a>
        </div>
    </footer>

    <script>
        function login() {
            var email = document.forms["formlogin"]["emaill"];
            var pass = document.forms["formlogin"]["password"];

            // if (email.value == "") {
            //     window.alert("Masukkan email anda !");
            //     email.focus();
            //     return false;
            // }
            // if (email.value == "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/") {
            //     window.alert("Masukkan email yang valid !");
            //     email.focus();
            //     return false;
            // }
            if (pass.value == "") {
                window.alert("Masukkan password anda !");
                pass.focus();
                return false;
            }
            return true;
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>