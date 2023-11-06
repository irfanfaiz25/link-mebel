<?php
session_start();
require 'fungsi/fungsi.php';

if (isset($_SESSION["login"])) {
  header("location: index.php");
}

if (isset($_POST["login"])) {
  $user = $_POST["username"];
  $pass = $_POST["password"];

  $rs = mysqli_query($konek, "SELECT * FROM user WHERE username = '$user'");

  if (mysqli_num_rows($rs) === 1) {
    $row = mysqli_fetch_assoc($rs);
    $id_user = $row["id"];

    if (password_verify($pass, $row["password"])) {
      $_SESSION["login"] = true;
      $_SESSION["user"] = $id_user;

      $device = @$_SERVER['HTTP_USER_AGENT'];
      $ip = @$_SERVER['REMOTE_ADDR'];
      $id_user = $row["id"];
      $nama = $row["nama"];
      $level = $row["level_user"];

      $sql = "INSERT IGNORE INTO user_log VALUES ('','$id_user','$nama','$level','$ip','$device',now())";
      $result = mysqli_query($konek, $sql);

      if ($level == "admin") {
        header("Location: admin/index.php");
        exit;
      } else {
        header("Location: index.php");
        exit;
      }
    }
  }
  $error = true;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>halaman login</title>
  <link rel="icon" href="image/logo-title.png">
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

  <div class="login">
    <div class="login-dark text-center">
      <div class="row">
        <form name="formlogin" action="" method="post">
          <img src="image/logo-meubel.png" class="icon" alt="..."><br>
          <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username"></div>
          <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password">
          </div>
          <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
              Username atau password salah
            </div>
          <?php endif; ?>
          <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="login">
              <h6 class="log">LOGIN</h6>
            </button></div>
          <p style="margin-top: 28px !important;">belum punya akun ? <a href="daftar.php"
              style="color: #e63946 !important; text-decoration: none;">daftar</a></p>
        </form>
      </div>
    </div>
  </div>

  <script>
    function login() {
      var email = document.forms["formlogin"]["emaill"];
      var pass = document.forms["formlogin"]["password"];

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