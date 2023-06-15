<?php
session_start();
require 'fungsi/fungsi.php';

$tas = query("SELECT * FROM tb_barang WHERE kategori='Tas'");
$tenda = query("SELECT * FROM tb_barang WHERE kategori='Tenda'");
$sepatu = query("SELECT * FROM tb_barang WHERE kategori='sepatu'");
$cs = query("SELECT * FROM tb_barang WHERE kategori='Cooking Set'");
$other = query("SELECT * FROM tb_barang WHERE kategori='Other'");

if (isset($_POST["cart"])) {
  // echo ($_POST["quant"][1]);
  if (!isset($_SESSION["login"]) || !isset($_SESSION["user"])) {
    echo "
            <script>
                alert('Silahkan login terlebih dahulu');
            </script>
        ";
    header("Location: login.php");
    return false;
  }

  if (
    addCart(
      $_POST["id_barang"], $_POST["nm_barang"], $_POST["harga_barang"],
      $_POST["ket_barang"], $_POST["foto_barang"], $_POST["quant"][1]
    ) > 0
  ) {
    header('Location: index.php#cart');
  } else {
    echo "
      <script>
        alert ('gagal');
      </script>
    ";
    header('Location: index.php');
  }
}

if (isset($_SESSION["user"])) {
  $userId = $_SESSION["user"];

  $cart = query("SELECT id_rent, nama, ket, foto, jumlah, harga_sewa*jumlah AS sub, SUM(jumlah) AS jml FROM cart WHERE id_user = $userId GROUP BY nama");
  $cekCart = count(query("SELECT * FROM cart WHERE id_user = $userId"));
  $tot = mysqli_query($konek, "SELECT SUM(harga_sewa*jumlah) AS tot FROM cart WHERE id_user = $userId");
  $total = mysqli_fetch_assoc($tot);
  $_SESSION["total"] = $total["tot"];

}

if (isset($_SESSION["total"])) {
  $tot_sewa = $_SESSION["total"];
} else {
  $tot_sewa = "000";
}

if (isset($_POST["rent"])) {
  if (checkout($_POST)) {
    header('Location: send.php');
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>sabana adventure</title>
  <link rel="icon" href="image/logo.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="css/style.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<style>
  .float {
    position: fixed;
    width: 60px;
    height: 60px;
    background-color: #023047;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    box-shadow: 2px 2px 3px #999;
  }

  .fl-icon a:hover {
    color: antiquewhite !important;
  }

  .fl-icon a:focus {
    color: antiquewhite;
  }

  .my-float {
    margin-top: 22px;
  }

  .float .fa {
    transition: all 1s;
  }

  .float:hover .fa {
    transform: rotate(360deg);
  }

  .align-middle {
    place-items: center !important;
  }

  .navbar-nav li.active a {
    color: #e63946 !important;
    background-color: #023047 !important;
  }

  @media screen and (min-width: 601px) {
    th.ctr {
      font-size: 18px !important;
    }

    td.align-middle {
      font-size: 14px !important;
    }

    .modal-dialog {
      position: absolute;
      top: 40%;
      left: 50%;
      transform: translate(-50%, -50%) !important;
    }

    .float {
      bottom: 30px;
      right: 35px;
    }
  }

  /* If the screen size is 600px wide or less, set the font-size of <div> to 30px */
  @media screen and (max-width: 600px) {
    th.ctr {
      font-size: 7px !important;
    }

    td.align-middle {
      font-size: 7px !important;
    }

    .margin-table {
      margin-left: -88px;
    }

    .syrt {
      margin-left: -35px !important;
    }

    .float {
      bottom: 530px;
      right: 30px;
    }
  }
</style>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">
  <div class="fl-icon">
    <a href="#cart" class="float">
      <i class="fa fa-cart-arrow-down my-float"></i>
    </a>
  </div>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">

    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#myPage">
            <img src="image/logo2.png" alt="logo" height="47" style="padding-right: 10px;">
          </a>
          <a class="navbar-brand" style="padding: 4px 2px 0px;" href="#myPage">Sabana<span>.</span>adv</a>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#desc">HOME</a></li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">ALAT
                <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#tas">TAS CARRIER</a></li>
                <li><a href="#tenda">TENDA/DOME</a></li>
                <li><a href="#cs">COOKING SET</a></li>
                <li><a href="#sepatu">SEPATU</a></li>
                <li><a href="#ot">OTHERS</a></li>
              </ul>
            </li>
            <li><a href="#pesan">PEMESANAN</a></li>
            <li><a href="#aboutus">ABOUT</a></li>
            <?php if (isset($_SESSION["login"])): ?>
              <li><a href="logout.php">LOGOUT</a></li>
            <?php else: ?>
              <li><a href="login.php">LOGIN</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="image/1.jpg" alt="" width="1200" height="700">
        <div class="carousel-caption">
        </div>
      </div>

      <div class="item">
        <img src="image/2.jpg" alt="" width="1200" height="700">
        <div class="carousel-caption">
        </div>
      </div>

      <div class="item">
        <img src="image/3.jpg" alt="" width="1200" height="700">
        <div class="carousel-caption">
        </div>
      </div>
    </div>

    <!-- geser foto halaman utama -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <div id="desc" class="container text-center" data-aos="fade-up">
    <h2>SABANA ADVENTURE</h2>
    <p class="sub"><em><b>Simo Arga Buana</b></em></p>
    <p>Sabana Adventure adalah salah satu penyewaan alat outdoor yang berada di Kabupaten Boyolali, tepatnya Simo Trade
      Center (STC) Blok D-20, Pelem, Simo. Atas saran dan masukan dari beberapa teman untuk membuka jasa penyewaan alat
      outdor, akhirnya berdirilah Sabana Adventure di tahun 2015. Kata "Sabana" sendiri mempunyai kepanjangan "Simo Arga
      Buana" dimana Arga bisa diartikan laut dan Buana diartikan sebagai Hutan. Jadi sudah cukup mewakili untuk dunia
      Outdoor. Kemudian pada Mei 2016, akhirnya Sabana Adventure menetapkan basecampnya di STC untuk memudahkan akses
      customer yang membutuhkan peralat outdoor untuk kegiatan pendakian, camping, diklat sar dan lain-lain.
      Seiring berjalannya waktu, Sabana Adventure masih bisa eksis sampai sekarang pun dikarenakan support yang begitu
      luar biasa dari pihak yang tidak bisa kami sebutkan satu per satu. Untuk itu kami mengucapkan terima kasih yang
      dalam kepada Tuhan Yang Maha Esa, Orang Tua, Keluarga, Teman, Sahabat dan pihak lain yang tidak bisa kami sebutkan
      satu per satu.
      Harapan kami semoga kedepannya Sabana Adventure semakin lebih baik dan eksis terus. Aamiin
      <br>
      Salam hangat kami
      <br><br>
      <b>Wahid Setyawan (Owner)</b>
    </p>
    <br>
  </div>


  <!-- halaman tas -->
  <div id="tas" class="bg-5">
    <div class="container">

      <div class="div-header text-center">
        <h2>TAS CARRIER</h2>
        <p class="subj"><i>we prepare your outdoor equipments !</i></p>
      </div>

      <?php foreach ($tas as $rowtas): ?>
        <div class="col-sm-4" style="margin-bottom: 30px;">
          <div class="panel text-center">
            <input type="hidden" name="id_barang" value="<?= $rowtas["id"]; ?>">
            <div class="panel-heading">
              <h5>
                <?= $rowtas["nama"]; ?>
              </h5>
            </div>
            <div class="panel-body" data-toggle="modal" data-target="#myModal"></div>
            <img src="image/<?= $rowtas["foto"]; ?>" class="img-responsive equip" width="300px" alt="Image">
            <div class="panel-footer">
              <h5>
                <?= $rowtas["keterangan"]; ?>
              </h5>
              <h5>Harga Sewa</h5>
              <h5>
                <?= formatRupiah($rowtas["harga_sewa"]); ?> / Hari
              </h5>
              <button class="btn btn-default" data-toggle="modal" data-target="#modalCart<?= $rowtas["id"]; ?>">
                <h6 style=""><i class="fa fa-cart-plus"></i>
                  Sewa</h6>
              </button>
            </div>

            <!-- modal cart -->
            <div class="modal fade" id="modalCart<?= $rowtas["id"]; ?>" tabindex="-1" role="dialog"
              aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="modal-title" id="modalLabel" style="font-size: 20px;">Add to cart</p>
                  </div>
                  <div class="modal-body">
                    <form action="" method="post">
                      <input type="hidden" name="id_barang" value="<?= $rowtas["id"]; ?>">
                      <input type="hidden" name="nm_barang" value="<?= $rowtas["nama"]; ?>">
                      <input type="hidden" name="harga_barang" value="<?= $rowtas["harga_sewa"]; ?>">
                      <input type="hidden" name="ket_barang" value="<?= $rowtas["keterangan"]; ?>">
                      <input type="hidden" name="foto_barang" value="<?= $rowtas["foto"]; ?>">
                      <div class="row">
                        <div class="col-md-3">
                          <img class="img-responsive" src="image/<?= $rowtas["foto"]; ?>" alt="">
                        </div>
                        <div class="col-md-8">
                          <p>
                            <?= $rowtas["nama"]; ?>
                          </p>
                          <p>
                            <?= formatRupiah($rowtas["harga_sewa"]); ?> / Hari
                          </p>

                          <!-- input min plus button -->
                          <div class="input-group">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default btn-number" disabled="disabled"
                                data-type="minus" data-field="quant[1]">
                                <span class="glyphicon glyphicon-minus"></span>
                              </button>
                            </span>
                            <input type="text" name="quant[1]" class="form-control input-number" value="1" min="1"
                              max="50">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default btn-number" data-type="plus"
                                data-field="quant[1]">
                                <span class="glyphicon glyphicon-plus"></span>
                              </button>
                            </span>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" name="cart" class="btn btn-primary"><i class="fa fa-cart-plus"></i> Add to rent
                      cart</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>



  <!-- halaman tenda -->
  <div id="tenda">
    <div class="container">

      <div class="div-header text-center">
        <h2>TENDA / DOME</h2>
        <p class="subj"><i>we prepare your outdoor equipments !</i></p>
      </div>

      <?php foreach ($tenda as $rowtenda): ?>
        <div class="col-sm-4" style="margin-bottom: 30px;">
          <div class="panel text-center">
            <input type="hidden" name="id_barang" value="<?= $rowtenda["id"]; ?>">
            <div class="panel-heading">
              <h5>
                <?= $rowtenda["nama"]; ?>
              </h5>
            </div>
            <div class="panel-body" data-toggle="modal" data-target="#myModal"></div>
            <img src="image/<?= $rowtenda["foto"]; ?>" class="img-responsive equip" width="300px" alt="Image">
            <div class="panel-footer">
              <h5>
                <?= $rowtenda["keterangan"]; ?>
              </h5>
              <h5>Harga Sewa</h5>
              <h5>
                <?= formatRupiah($rowtenda["harga_sewa"]); ?> / Hari
              </h5>
              <button class="btn btn-default" data-toggle="modal" data-target="#modalCart<?= $rowtenda["id"]; ?>">
                <h6 style=""><i class="fa fa-cart-plus"></i>
                  Sewa</h6>
              </button>
            </div>

            <!-- modal cart -->
            <div class="modal fade" id="modalCart<?= $rowtenda["id"]; ?>" tabindex="-1" role="dialog"
              aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="modal-title" id="modalLabel" style="font-size: 20px;">Add to cart</p>
                  </div>
                  <div class="modal-body">
                    <form action="" method="post">
                      <input type="hidden" name="id_barang" value="<?= $rowtenda["id"]; ?>">
                      <input type="hidden" name="nm_barang" value="<?= $rowtenda["nama"]; ?>">
                      <input type="hidden" name="harga_barang" value="<?= $rowtenda["harga_sewa"]; ?>">
                      <input type="hidden" name="ket_barang" value="<?= $rowtenda["keterangan"]; ?>">
                      <input type="hidden" name="foto_barang" value="<?= $rowtenda["foto"]; ?>">
                      <div class="row">
                        <div class="col-md-3">
                          <img class="img-responsive" src="image/<?= $rowtenda["foto"]; ?>" alt="">
                        </div>
                        <div class="col-md-8">
                          <p>
                            <?= $rowtenda["nama"]; ?>
                          </p>
                          <p>
                            <?= formatRupiah($rowtenda["harga_sewa"]); ?> / Hari
                          </p>

                          <!-- input min plus button -->
                          <div class="input-group">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default btn-number" disabled="disabled"
                                data-type="minus" data-field="quant[1]">
                                <span class="glyphicon glyphicon-minus"></span>
                              </button>
                            </span>
                            <input type="text" name="quant[1]" class="form-control input-number" value="1" min="1"
                              max="50">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default btn-number" data-type="plus"
                                data-field="quant[1]">
                                <span class="glyphicon glyphicon-plus"></span>
                              </button>
                            </span>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" name="cart" class="btn btn-primary"><i class="fa fa-cart-plus"></i> Add to rent
                      cart</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>


  <!-- halaman cookingset -->
  <div id="cs" class="bg-5">
    <div class="container">

      <div class="div-header text-center">
        <h2>COOKING SET</h2>
        <p class="subj"><i>we prepare your outdoor equipments !</i></p>
      </div>

      <?php foreach ($cs as $rowcs): ?>
        <div class="col-sm-4" style="margin-bottom: 30px;">
          <div class="panel text-center">
            <input type="hidden" name="id_barang" value="<?= $rowcs["id"]; ?>">
            <div class="panel-heading">
              <h5>
                <?= $rowcs["nama"]; ?>
              </h5>
            </div>
            <div class="panel-body" data-toggle="modal" data-target="#myModal"></div>
            <img src="image/<?= $rowcs["foto"]; ?>" class="img-responsive equip" width="300px" alt="Image">
            <div class="panel-footer">
              <h5>
                <?= $rowcs["keterangan"]; ?>
              </h5>
              <h5>Harga Sewa</h5>
              <h5>
                <?= formatRupiah($rowcs["harga_sewa"]); ?> / Hari
              </h5>
              <button class="btn btn-default" data-toggle="modal" data-target="#modalCart<?= $rowcs["id"]; ?>">
                <h6 style=""><i class="fa fa-cart-plus"></i>
                  Sewa</h6>
              </button>
            </div>

            <!-- modal cart -->
            <div class="modal fade" id="modalCart<?= $rowcs["id"]; ?>" tabindex="-1" role="dialog"
              aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="modal-title" id="modalLabel" style="font-size: 20px;">Add to cart</p>
                  </div>
                  <div class="modal-body">
                    <form action="" method="post">
                      <input type="hidden" name="id_barang" value="<?= $rowcs["id"]; ?>">
                      <input type="hidden" name="nm_barang" value="<?= $rowcs["nama"]; ?>">
                      <input type="hidden" name="harga_barang" value="<?= $rowcs["harga_sewa"]; ?>">
                      <input type="hidden" name="ket_barang" value="<?= $rowcs["keterangan"]; ?>">
                      <input type="hidden" name="foto_barang" value="<?= $rowcs["foto"]; ?>">
                      <div class="row">
                        <div class="col-md-3">
                          <img class="img-responsive" src="image/<?= $rowcs["foto"]; ?>" alt="">
                        </div>
                        <div class="col-md-8">
                          <p>
                            <?= $rowcs["nama"]; ?>
                          </p>
                          <p>
                            <?= formatRupiah($rowcs["harga_sewa"]); ?> / Hari
                          </p>

                          <!-- input min plus button -->
                          <div class="input-group">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default btn-number" disabled="disabled"
                                data-type="minus" data-field="quant[1]">
                                <span class="glyphicon glyphicon-minus"></span>
                              </button>
                            </span>
                            <input type="text" name="quant[1]" class="form-control input-number" value="1" min="1"
                              max="50">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default btn-number" data-type="plus"
                                data-field="quant[1]">
                                <span class="glyphicon glyphicon-plus"></span>
                              </button>
                            </span>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" name="cart" class="btn btn-primary"><i class="fa fa-cart-plus"></i> Add to rent
                      cart</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>





  <!-- halaman sepatu -->
  <div id="sepatu">
    <div class="container">

      <div class="div-header text-center">
        <h2>SEPATU</h2>
        <p class="subj"><i>we prepare your outdoor equipments !</i></p>
      </div>

      <?php foreach ($sepatu as $rowsepatu): ?>
        <div class="col-sm-4" style="margin-bottom: 30px;">
          <div class="panel text-center">
            <input type="hidden" name="id_barang" value="<?= $rowsepatu["id"]; ?>">
            <div class="panel-heading">
              <h5>
                <?= $rowsepatu["nama"]; ?>
              </h5>
            </div>
            <div class="panel-body" data-toggle="modal" data-target="#myModal"></div>
            <img src="image/<?= $rowsepatu["foto"]; ?>" class="img-responsive equip" width="300px" alt="Image">
            <div class="panel-footer">
              <h5>
                <?= $rowsepatu["keterangan"]; ?>
              </h5>
              <h5>Harga Sewa</h5>
              <h5>
                <?= formatRupiah($rowsepatu["harga_sewa"]); ?> / Hari
              </h5>
              <button class="btn btn-default" data-toggle="modal" data-target="#modalCart<?= $rowsepatu["id"]; ?>">
                <h6 style=""><i class="fa fa-cart-plus"></i>
                  Sewa</h6>
              </button>
            </div>

            <!-- modal cart -->
            <div class="modal fade" id="modalCart<?= $rowsepatu["id"]; ?>" tabindex="-1" role="dialog"
              aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="modal-title" id="modalLabel" style="font-size: 20px;">Add to cart</p>
                  </div>
                  <div class="modal-body">
                    <form action="" method="post">
                      <input type="hidden" name="id_barang" value="<?= $rowsepatu["id"]; ?>">
                      <input type="hidden" name="nm_barang" value="<?= $rowsepatu["nama"]; ?>">
                      <input type="hidden" name="harga_barang" value="<?= $rowsepatu["harga_sewa"]; ?>">
                      <input type="hidden" name="ket_barang" value="<?= $rowsepatu["keterangan"]; ?>">
                      <input type="hidden" name="foto_barang" value="<?= $rowsepatu["foto"]; ?>">
                      <div class="row">
                        <div class="col-md-3">
                          <img class="img-responsive" src="image/<?= $rowsepatu["foto"]; ?>" alt="">
                        </div>
                        <div class="col-md-8">
                          <p>
                            <?= $rowsepatu["nama"]; ?>
                          </p>
                          <p>
                            <?= formatRupiah($rowsepatu["harga_sewa"]); ?> / Hari
                          </p>

                          <!-- input min plus button -->
                          <div class="input-group">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default btn-number" disabled="disabled"
                                data-type="minus" data-field="quant[1]">
                                <span class="glyphicon glyphicon-minus"></span>
                              </button>
                            </span>
                            <input type="text" name="quant[1]" class="form-control input-number" value="1" min="1"
                              max="50">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default btn-number" data-type="plus"
                                data-field="quant[1]">
                                <span class="glyphicon glyphicon-plus"></span>
                              </button>
                            </span>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" name="cart" class="btn btn-primary"><i class="fa fa-cart-plus"></i> Add to rent
                      cart</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>




  <!-- halaman lain-lain -->
  <div id="ot" class="bg-5">
    <div class="container">

      <div class="div-header text-center">
        <h2>OTHERS</h2>
        <p class="subj"><i>we prepare your outdoor equipments !</i></p>
      </div>

      <?php foreach ($other as $rowother): ?>
        <div class="col-sm-4" style="margin-bottom: 30px;">
          <div class="panel text-center">
            <input type="hidden" name="id_barang" value="<?= $rowother["id"]; ?>">
            <div class="panel-heading">
              <h5>
                <?= $rowother["nama"]; ?>
              </h5>
            </div>
            <div class="panel-body" data-toggle="modal" data-target="#myModal"></div>
            <img src="image/<?= $rowother["foto"]; ?>" class="img-responsive equip" width="300px" alt="Image">
            <div class="panel-footer">
              <h5>
                <?= $rowother["keterangan"]; ?>
              </h5>
              <h5>Harga Sewa</h5>
              <h5>
                <?= formatRupiah($rowother["harga_sewa"]); ?> / Hari
              </h5>
              <button class="btn btn-default" data-toggle="modal" data-target="#modalCart<?= $rowother["id"]; ?>">
                <h6 style=""><i class="fa fa-cart-plus"></i>
                  Sewa</h6>
              </button>
            </div>

            <!-- modal cart -->
            <div class="modal fade" id="modalCart<?= $rowother["id"]; ?>" tabindex="-1" role="dialog"
              aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="modal-title" id="modalLabel" style="font-size: 20px;">Add to cart</p>
                  </div>
                  <div class="modal-body">
                    <form action="" method="post">
                      <input type="hidden" name="id_barang" value="<?= $rowother["id"]; ?>">
                      <input type="hidden" name="nm_barang" value="<?= $rowother["nama"]; ?>">
                      <input type="hidden" name="harga_barang" value="<?= $rowother["harga_sewa"]; ?>">
                      <input type="hidden" name="ket_barang" value="<?= $rowother["keterangan"]; ?>">
                      <input type="hidden" name="foto_barang" value="<?= $rowother["foto"]; ?>">
                      <div class="row">
                        <div class="col-md-3">
                          <img class="img-responsive" src="image/<?= $rowother["foto"]; ?>" alt="">
                        </div>
                        <div class="col-md-8">
                          <p>
                            <?= $rowother["nama"]; ?>
                          </p>
                          <p>
                            <?= formatRupiah($rowother["harga_sewa"]); ?> / Hari
                          </p>

                          <!-- input min plus button -->
                          <div class="input-group">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default btn-number" disabled="disabled"
                                data-type="minus" data-field="quant[1]">
                                <span class="glyphicon glyphicon-minus"></span>
                              </button>
                            </span>
                            <input type="text" name="quant[1]" class="form-control input-number" value="1" min="1"
                              max="50">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default btn-number" data-type="plus"
                                data-field="quant[1]">
                                <span class="glyphicon glyphicon-plus"></span>
                              </button>
                            </span>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" name="cart" class="btn btn-primary"><i class="fa fa-cart-plus"></i> Add to rent
                      cart</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>




  <!-- halaman pesan -->
  <div id="pesan">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 d-flex align-items-center">
          <div class="text-center">
            <h2 class="syrt">PERSYARATAN</h2>
            <p class="subj"><i>sewa peralatan outdoor</i></p>
          </div><br><br>
          <h6>
            <ul class="syarat text-center" style="list-style-type: none;">
              <li>Wajib meninggalkan identitas diri yang masih berlaku</li>
              <li>Setiap keterlambatan pengembalian tanpa konfirmasi akan dikenakan denda</li>
              <li>Kehilangan atau kerusakan barang di tanggung oleh penyewa</li>
              <li>Diskon 10% (jika biaya sewa lebih dari Rp.100.000)</li>
              <li>Harga sewa dapat berubah sewaktu waktu tanpa ada pemberitahuan terlebih dahulu</li>
            </ul><br><br>
          </h6>
        </div>
      </div>
    </div>
  </div>


  <!-- halaman cart -->
  <div id="cart" class="bg-5">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 d-flex align-items-center">
          <div class="text-center">
            <h2>RENT CART</h2>
            <p class="subj"><i>keranjang sewa</i></p>
          </div><br><br>
          <h6>
            <div class="row justify-content-center">
              <div class="col-auto">
                <div class="table-responsive-md margin-table">
                  <table class="table table-hover">
                    <thead class="thead-dark">
                      <tr>
                        <th class="ctr text-center">NAMA BARANG</th>
                        <th class="ctr text-center">KETERANGAN</th>
                        <th class="ctr text-center">FOTO</th>
                        <th class="ctr text-center">JUMLAH</th>
                        <th class="ctr text-center"><i class="fa fa-pen-to-square"></i></th>
                        <th class="ctr text-center">SUBTOTAL</th>
                      </tr>
                    </thead>
                    <h4 style="margin-top: 50px;">
                      <?php
                      if (isset($_SESSION["user"])) {
                        if ($cekCart == 0) {
                          $info = "Rent cart masih kosong !";
                          echo $info;
                        }
                        $totalSewa = $total["tot"];
                      } else {
                        $totalSewa = false;
                      }

                      if (!isset($_SESSION["login"])):
                        $info2 = "Anda belum login !";
                        echo $info2;
                      else: ?>
                      </h4>
                      <?php foreach ($cart as $rowcart):
                        $jmll = $rowcart["jml"];
                        ?>
                        <tbody>
                          <tr class="text-center">
                            <td class="align-middle">
                              <?= $rowcart["nama"]; ?>
                            </td>
                            <td class="align-middle">
                              <?= $rowcart["ket"]; ?>
                            </td>
                            <td class="align-middle">
                              <img src="image/<?= $rowcart["foto"] ?>" alt="" width="50" height="53">
                            </td>
                            <td class="align-middle">
                              <?= $rowcart["jml"]; ?>
                            </td>
                            <td>
                              <a href="hapus_keranjang.php?id_rent=<?= $rowcart["id_rent"]; ?>"><button type="button"
                                  class="btn btn-outline-secondary"><i class="fa fa-trash-can"></i>
                                </button></a>
                            </td>
                            <td class="align-middle">
                              <?= formatRupiah($rowcart["sub"]); ?>
                            </td>
                          </tr>
                        </tbody>
                      <?php endforeach; ?>
                      <div class="row">

                      </div>
                      <?php
                      endif;
                      ?>
                  </table>
                </div>
                <div class="col-sm-12">
                  <h5 style="float: right; color: #023047; font-size: 25px;">
                    Total
                    <?=
                      formatRupiah($tot_sewa);
                    ?>
                  </h5>
                </div>
                <div class="col-sm-12">
                  <button class="btn btn-success" data-toggle="modal" data-target="#modalCo"
                    style="float: right; margin-top: 20px; padding-top: 12px; padding-bottom: 12px;">CHECKOUT
                    <i class="fa fa-circle-check"></i></button>
                </div>

                <div class="modal fade" id="modalCo" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <p class="modal-title" id="modalLabel" style="font-size: 20px;">Checkout</p>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <form action="" method="post">
                            <div class="form-group col-md-6">
                              <label for="tanggal">TANGGAL AMBIL</label>
                              <input class="form-control" type="date" name="tanggalambil" id="tanggal">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="tanggal">TANGGAL KEMBALI</label>
                              <input class="form-control" type="date" name="tanggalkembali" id="tanggal">
                            </div>
                            <button class="btn btn-success" type="submit" name="rent"
                              style="float: right; margin-top: 20px; padding-top: 12px; padding-bottom: 12px;">RENT
                              <i class="fa fa-paper-plane"></i></button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </h6>
        </div>
      </div>
    </div>
  </div>



  <div id="aboutus">
    <div class="container text-center">
      <div class="div-header">
        <h2>ABOUT</h2>
        <p class="subj"><i>Sabana Adventure</i></p><br><br>
        <div class="row">
          <div class="col-md-6">
            <br>
            <a href="#about" data-toggle="collapse">
              <img src="image/founder.jpg" class="img-circle person" alt="Wahid">
            </a>
            <div id="about" class="collapse">
              <h6 style="font-size: 2vmax;">Wahid Setyawan</h6>
              <p><i>Owner</i></p>
            </div>
            <br><br>
          </div>
          <div class="map-responsive">
            <div class="col-md-6">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.185288614528!2d110.67572131546173!3d-7.444741675426823!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a729adfc3fba1%3A0x2fd359627458a8b4!2sSabana%20Adv!5e0!3m2!1sen!2sid!4v1657676099905!5m2!1sen!2sid"
                style="border:0; width: 25vmax; height: 17vmax;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <footer class="bg-dark text-center text-white">
    <a class="up-arrow" href="#myPage" data-toggle="tooltip" title="TO TOP">
      <span class="glyphicon glyphicon-chevron-up" style="border: 0;"></span>
      <div class="container p-4 pb-0">
        <div class="mb-4">
          <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
              class="fa-brands fa-facebook-f"></i></a>

          <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
              class="fa-brands fa-twitter"></i></a>

          <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
              class="fa-brands fa-google"></i></a>

          <a class="btn btn-outline-light btn-floating m-1" href="https://www.instagram.com/sabanaadv/" role="button"><i
              class="fa-brands fa-instagram"></i></a>
        </div>
        <br>
        <div class="text-center p-3">
          © 2022 Copyright:
          <a class="text-white" href="#">sabanaadv.com</a>
        </div>
      </div>
  </footer>


  <script>
    $(document).ready(function () {
      $('[data-toggle="tooltip"]').tooltip();

      $(".navbar a, .fl-icon a, footer a[href='#myPage']").on('click', function (event) {
        if (this.hash !== "") {

          event.preventDefault();

          var hash = this.hash;

          $('html, body').animate({
            scrollTop: $(hash).offset().top
          }, 1200, function () {

            window.location.hash = hash;
          });
        }
      });
    })
  </script>
  <script src="js/script.js"></script>
</body>

</html>