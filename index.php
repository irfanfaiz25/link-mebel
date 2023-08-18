<?php
session_start();
require 'fungsi/fungsi.php';
if (isset($_SESSION["login"])) {
  $ses_id = $_SESSION["user"];

  $wait_confirm = query("SELECT no_trans, id_user, id_produk, nama, ket, foto, tgl_transaksi, pembayaran,SUM(jumlah) AS jumlah_order, SUM(harga*jumlah) AS total, COUNT(id_produk) AS jumlah_produk, bukti_bayar, nama_penerima, no_hp, alamat, ket_reject, proses_status FROM transaksi_item WHERE id_user='$ses_id' AND (proses_status='waiting for payment' OR proses_status='payment rejected' OR proses_status='payment confirmation' OR proses_status='repayment') GROUP BY no_trans ORDER BY no_trans DESC");

  $on_process = query("SELECT no_trans, id_user, id_produk, nama, ket, foto, tgl_transaksi, pembayaran,SUM(jumlah) AS jumlah_order, SUM(harga*jumlah) AS total, COUNT(id_produk) AS jumlah_produk, bukti_bayar, nama_penerima, no_hp, alamat, ket_reject, proses_status, ekspedisi, no_resi FROM transaksi_item WHERE id_user='$ses_id' AND (proses_status='on process' OR proses_status='on delivery') GROUP BY no_trans ORDER BY no_trans DESC");
}

$meja = query("SELECT * FROM tb_produk WHERE kategori='Meja'");
$kursi = query("SELECT * FROM tb_produk WHERE kategori='Kursi'");
$slider = query("SELECT * FROM tb_produk ORDER BY id_produk LIMIT 6");

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
      $_POST["id_barang"],
      $_POST["nm_barang"],
      $_POST["harga_barang"],
      $_POST["ket_barang"],
      $_POST["foto_barang"],
      $_POST["quant"][1]
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

  $cart = query("SELECT id_cart, nama, ket, foto, jumlah, harga*jumlah AS sub, SUM(jumlah) AS jml FROM cart WHERE id_user = $userId GROUP BY nama");
  $cekCart = count(query("SELECT * FROM cart WHERE id_user = $userId"));
  $tot = mysqli_query($konek, "SELECT SUM(harga*jumlah) AS tot FROM cart WHERE id_user = $userId");
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
    header('Location: index.php#cart');
  }
}

if (isset($_POST["btn-payment"])) {
  if (updatePayment($_POST)) {
    header('Location: index.php#cart');
  } else {
    echo "
      <script>
        alert('gagal');
      </script>
    ";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Link Meubel</title>
  <link rel="icon" href="image/logo-title.png">
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

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" />

  <!-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> -->
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

</head>


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
            <img src="image/logo-meubel.png" alt="logo" height="30" style="margin: 2px; margin-top: 8px;">
          </a>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#desc">HOME</a></li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">KATEGORI
                <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#meja">Meja</a></li>
                <li><a href="#kursi">Kursi</a></li>
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

  <div id="desc" class="bg-5">
    <div class="container text-center" data-aos="fade-up">
      <h2>LINK MEUBEL</h2>
      <p class="sub"><em><b>Jepara Van Java</b></em></p>
      <p>Link Meubel merupakan CV. yang bergerak di bidang penjualan furniture atau perlengkapan rumah seperti kursi,
        meja, dan lemari yang berada di Kabupaten Jepara. Atas pengalaman dan pengetahuan yang telah di dapatkan,
        akhirnya berdirilah Link Meubel pada tahun 1998. Kata “Link” diambil dari bahasa inggris yg berarti “hubungan”
        yang mana diharapkan mendapatkan hubungan antara penjual dan pembeli. Seiring berjalannya waktu, Link Meubel
        mash bisa eksis sampai sekarang pun dikarenakan support yang begitu luar biasa dari pihak yang tidak bisa kami
        sebutkan satu per satu. Untuk itu kami mengucapkan terima kasih yang dalam kepada Tuhan Yang Maha Esa, Orang
        Tua, Keluarga, Teman, Sahabat dan pihak lain yang tidak bisa kami sebutkan satu per satu. Harapan kami semoga
        kedepannya Link Meubel semakin lebih baik dan eksis terus. Aamiin
        <br>
        Best Regards
        <br><br>
        <b>Nandang Budi (Owner)</b>
      </p>
      <br>
    </div>
  </div>

  <div id="slider" class="mt-0">
    <div class="container">

      <div class="div-header text-center">
        <h2>OUR PRODUCT</h2>
        <p class="subj"><i>we prepare your lovely house equipments &#10084;</i></p>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="carousel carousel-showmanymoveone slide" id="carouselABC">
            <div class="carousel-inner">
              <div class="item active">
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="card">
                    <img class="card-img-top img-fluid img-responsive" src="image/meja1.png" alt="Card image cap">
                    <div class="card-body">
                      <h6 class="card-title">Haafi</h6>
                      <p class="card-text">This is a longer card with supporting text below as a natural.</p>
                      <p class="card-text"><small class="text-muted">IDR 460,000</small></p>
                    </div>
                  </div>
                </div>
              </div>
              <?php
              foreach ($slider as $row):
                ?>
                <div class="item">
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="card">
                      <img class="card-img-top img-fluid img-responsive" src="image/<?= $row["foto"]; ?>"
                        alt="Card image cap">
                      <div class="card-body">
                        <h6 class="card-title">
                          <?= $row["nama"] ?>
                        </h6>
                        <p class="card-text">This is a longer card with supporting text below as a natural.</p>
                        <p class="card-text"><small class="text-muted">IDR
                            <?= number_format($row["harga"]); ?>
                          </small></p>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
              endforeach;
              ?>
            </div>
            <a class="left carousel-control" href="#carouselABC" data-slide="prev"><i
                class="glyphicon glyphicon-chevron-left"></i></a>
            <a class="right carousel-control" href="#carouselABC" data-slide="next"><i
                class="glyphicon glyphicon-chevron-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- halaman meja -->
  <div id="meja" class="bg-5">
    <div class="container">

      <div class="div-header text-center">
        <h2>MEJA (Table)</h2>
        <p class="subj"><i>we prepare your lovely house equipments &#10084;</i></p>
      </div>

      <?php foreach ($meja as $rowmeja): ?>
        <div class="col-sm-4" style="margin-bottom: 30px;">
          <div class="panel text-center">
            <input type="hidden" name="id_barang" value="<?= $rowmeja["id_produk"]; ?>">
            <div class="panel-heading">
              <h5>
                <?= $rowmeja["nama"]; ?>
              </h5>
            </div>
            <div class="panel-body" data-toggle="modal" data-target="#myModal"></div>
            <img src="image/<?= $rowmeja["foto"]; ?>" class="img-responsive equip" width="300px" alt="Image">
            <div class="panel-footer">
              <h5>Harga</h5>
              <h5>
                IDR
                <?= number_format($rowmeja["harga"]); ?>
              </h5>
              <button class="btn btn-xs btn-default" data-toggle="modal"
                data-target="#modalCart<?= $rowmeja["id_produk"]; ?>">
                <h6><i class="fa fa-cart-plus"></i>
                  ADD</h6>
              </button>
            </div>

            <!-- modal cart -->
            <div class="modal fade" id="modalCart<?= $rowmeja["id_produk"]; ?>" tabindex="-1" role="dialog"
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
                      <input type="hidden" name="id_barang" value="<?= $rowmeja["id_produk"]; ?>">
                      <input type="hidden" name="nm_barang" value="<?= $rowmeja["nama"]; ?>">
                      <input type="hidden" name="harga_barang" value="<?= $rowmeja["harga"]; ?>">
                      <input type="hidden" name="foto_barang" value="<?= $rowmeja["foto"]; ?>">
                      <div class="row">
                        <div class="col-md-3">
                          <img class="img-responsive" src="image/<?= $rowmeja["foto"]; ?>" alt="">
                        </div>
                        <div class="col-md-8">
                          <p>
                            <?= $rowmeja["nama"]; ?>
                          </p>
                          <p>
                            IDR
                            <?= number_format($rowmeja["harga"]); ?>
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
                        <div class="col-md-12">
                          <label for="notes">Notes (jika ada)</label>
                          <textarea class="form-control" type="text" name="ket_barang" id="notes"
                            placeholder="Notes, Ex: 'Custom ukuran 2M x 3M ya pak'"></textarea>
                        </div>
                      </div>

                  </div>
                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                    <button type="submit" name="cart" class="btn btn-primary"><i class="fa fa-cart-plus"></i> Add to
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



  <!-- halaman kursi -->
  <div id="kursi">
    <div class="container">

      <div class="div-header text-center">
        <h2>KURSI (Bench)</h2>
        <p class="subj"><i>we prepare your lovely house equipments &#10084;</i></p>
      </div>

      <?php foreach ($kursi as $rowkursi): ?>
        <div class="col-sm-4" style="margin-bottom: 30px;">
          <div class="panel text-center">
            <input type="hidden" name="id_barang" value="<?= $rowkursi["id_produk"]; ?>">
            <div class="panel-heading">
              <h5>
                <?= $rowkursi["nama"]; ?>
              </h5>
            </div>
            <div class="panel-body" data-toggle="modal" data-target="#myModal"></div>
            <img src="image/<?= $rowkursi["foto"]; ?>" class="img-responsive equip" width="300px" alt="Image">
            <div class="panel-footer">
              <h5>Harga</h5>
              <h5>
                <?= formatRupiah($rowkursi["harga"]); ?>
              </h5>
              <button class="btn btn-xs btn-default" data-toggle="modal"
                data-target="#modalCart<?= $rowkursi["id_produk"]; ?>">
                <h6><i class="fa fa-cart-plus"></i>
                  ADD</h6>
              </button>
            </div>

            <!-- modal cart -->
            <div class="modal fade" id="modalCart<?= $rowkursi["id_produk"]; ?>" tabindex="-1" role="dialog"
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
                      <input type="hidden" name="id_barang" value="<?= $rowkursi["id_produk"]; ?>">
                      <input type="hidden" name="nm_barang" value="<?= $rowkursi["nama"]; ?>">
                      <input type="hidden" name="harga_barang" value="<?= $rowkursi["harga"]; ?>">
                      <input type="hidden" name="foto_barang" value="<?= $rowkursi["foto"]; ?>">
                      <div class="row">
                        <div class="col-md-3">
                          <img class="img-responsive" src="image/<?= $rowkursi["foto"]; ?>" alt="">
                        </div>
                        <div class="col-md-8">
                          <p>
                            <?= $rowkursi["nama"]; ?>
                          </p>
                          <p>
                            <?= formatRupiah($rowkursi["harga"]); ?>
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
                        <div class="col-md-12">
                          <label for="notes" style="color: black;">Notes (jika ada)</label>
                          <textarea class="form-control" type="text" name="ket_barang" id="notes"
                            placeholder="Notes, Ex: 'Custom ukuran 2M x 3M ya pak'"></textarea>
                        </div>
                      </div>

                  </div>
                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                    <button type="submit" name="cart" class="btn btn-primary"><i class="fa fa-cart-plus"></i> Add to
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
  <div id="pesan" class="bg-5">
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
  <div id="cart">
    <div class="container">

      <div class="text-center">
        <h2>PRODUCT ORDERS</h2>
        <p class="subj"><i>pemesanan produk</i></p>
      </div><br><br>

      <div class="demo">
        <div role="tabpanel">

          <!-- Nav tabs -->
          <ul class="nav nav-tabs nav-justified nav-tabs-dropdown" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab"
                data-toggle="tab">CART
                <span class="badge">2</span>
              </a></li>
            <li role="presentation"><a href="#about" aria-controls="about" role="tab" data-toggle="tab">PAYMENT
                <span class="badge badge-warning">2</span>
              </a></li>
            <li role="presentation"><a href="#products" aria-controls="products" role="tab" data-toggle="tab">ON PROCESS
                <span class="badge badge-success">2</span>
              </a></li>
            <li role="presentation"><a href="#services" aria-controls="services" role="tab" data-toggle="tab">HISTORY
                <span class="badge badge-inverse">2</span>
              </a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
              <div class="row">
                <div class="col-sm-12 d-flex align-items-center">

                  <h6 style="font-size: 90%;">
                    <div class="row justify-content-center">
                      <div class="col-auto">
                        <div class="table-responsive-md margin-table">
                          <table id="tabel-cart" class="table table-hover">
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
                                  $info = "Cart masih kosong !";
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
                                <!-- <tbody> -->
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
                                    <a href="hapus_keranjang.php?id_cart=<?= $rowcart["id_cart"]; ?>"><button type="button"
                                        class="btn btn-outline-secondary"><i class="fa fa-trash-can"></i>
                                      </button></a>
                                  </td>
                                  <td class="align-middle">
                                    <?= formatRupiah($rowcart["sub"]); ?>
                                  </td>
                                </tr>
                                <!-- </tbody> -->
                              <?php endforeach; ?>
                              <div class="row">

                              </div>
                              <?php
                              endif;
                              ?>
                          </table>
                        </div>
                        <div class="col-sm-12">
                          <h5 style="float: right; color: #343a40; font-size: 25px;">
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

                        <!-- checkout modals -->
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
                                    <div class="col-md-12">
                                      <label for="nama_penerima">Nama Penerima</label>
                                      <input type="text" id="nama_penerima" name="nama_penerima" class="form-control"
                                        style="width: 498px;">

                                      <label for="no_hp" class="label-data">No HP Penerima</label>
                                      <input type="number" id="no_hp" name="no_hp" class="form-control"
                                        style="width: 498px;">

                                      <label for="alamat" class="label-data">Alamat Penerima</label>
                                      <textarea type="text" id="alamat" name="alamat" class="form-control"></textarea>
                                    </div>

                                    <div class="col-md-12 payment">
                                      <label for="payment">Pembayaran</label>
                                      <div class="row pembayaran">

                                        <div class="radio-inline">
                                          <input class="radio" type="radio" name="pembayaran" id="pembayaran1"
                                            value="dana">
                                          <label for="pembayaran1">
                                            <img src="image/payment-logo/dana.png" height="20" alt="payment-dana">
                                          </label>
                                        </div>

                                        <div class="radio-inline">
                                          <input class="radio" type="radio" name="pembayaran" id="pembayaran2"
                                            value="ovo">
                                          <label for="pembayaran2">
                                            <img src="image/payment-logo/ovo.png" height="20" alt="payment-ovo">
                                          </label>
                                        </div>

                                        <div class="radio-inline">
                                          <input class="radio" type="radio" name="pembayaran" id="pembayaran3"
                                            value="gopay">
                                          <label for="pembayaran3">
                                            <img src="image/payment-logo/gopay.png" height="20" width="80"
                                              alt="payment-gopay">
                                          </label>
                                        </div>

                                        <div class="radio-inline">
                                          <input class="radio" type="radio" name="pembayaran" id="pembayaran4"
                                            value="bca">
                                          <label for="pembayaran4">
                                            <img src="image/payment-logo/bca.png" height="20" alt="payment-bca">
                                          </label>
                                        </div>

                                        <div class="radio-inline">
                                          <input class="radio" type="radio" name="pembayaran" id="pembayaran5"
                                            value="cod">
                                          <label for="pembayaran5">
                                            <img src="image/payment-logo/cod.png" height="20" alt="payment-cod">
                                          </label>
                                        </div>

                                      </div>
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

            <!-- tab payment order -->
            <div role="tabpanel" class="tab-pane" id="about">
              <?php
              if (isset($_SESSION["login"])):
                foreach ($wait_confirm as $row):
                  ?>
                  <div class="card custom-card">
                    <div class="custom-card-content">
                      <div class="row">
                        <div class="col-md-4 wait-field">
                          <h5 class="card-no">
                            <?= $row["no_trans"]; ?>
                          </h5>
                          <h5>Total</h5>
                          <h5>
                            <?= $row["jumlah_produk"] ?> Produk,
                            <?= $row["jumlah_order"]; ?> Item
                          </h5>
                        </div>
                        <div class="col-md-5 wait-field wait-ping">
                          <?php
                          if ($row["bukti_bayar"] == "" && $row["proses_status"] != "payment rejected"):
                            ?>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="heartbeat"></div>
                                <div class="dot"></div>
                              </div>
                              <div class="col-md-10">
                                <span>
                                  <h5 class="pay-delay">
                                    menunggu pembayaran
                                  </h5>
                                </span>
                              </div>
                            </div>
                          <?php elseif ($row["bukti_bayar"] != "" && $row["proses_status"] != "payment rejected"): ?>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="heartbeat-success"></div>
                                <div class="dot-success"></div>
                              </div>
                              <div class="col-md-10">
                                <span>
                                  <h5 class="pay-confirm">
                                    menunggu konfirmasi admin
                                  </h5>
                                </span>
                              </div>
                            </div>
                          <?php elseif ($row["proses_status"] == "payment rejected"): ?>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="heartbeat-reject"></div>
                                <div class="dot-reject"></div>
                              </div>
                              <div class="col-md-10">
                                <span>
                                  <h5 class="pay-reject">
                                    order di tolak, silahkan cek keterangan dibawah
                                  </h5>
                                </span>
                              </div>
                              <div class="row text-center btn-check">
                                <button class="btn btn-warning btn-sm" type="button" data-toggle="modal"
                                  data-target="#ketReject<?= $row["no_trans"]; ?>"><strong>Check <i
                                      class="fa fa-chevron-down"></i></strong></button>
                              </div>
                            </div>
                          <?php endif; ?>
                        </div>
                        <div class="col-md-3 detail-card">
                          <a href="" data-toggle="modal" data-target="#detailOrder<?= $row["no_trans"]; ?>">
                            <h5 class="wait-details">
                              details <i class="fa fa-chevron-right"></i>
                            </h5>
                          </a>
                          <h5 class="wait-harga">
                            IDR
                            <?= number_format($row["total"]); ?>
                          </h5>
                          <a href="hapus_trans.php?no_trans=<?= $row["no_trans"]; ?>">
                            <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                          </a>
                          <button class="btn btn-warning btn-sm" type="button" data-toggle="modal"
                            data-target="#pay<?= $row["no_trans"]; ?>"><strong>Pay</strong></button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- modal detail orderan  -->
                  <div class="modal fade" id="detailOrder<?= $row["no_trans"]; ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          <p class="modal-title" id="modalLabel" style="font-size: 20px;">Detail Order</p>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="card custom-card-data">
                              <div class="custom-card-content">
                                <div class="row">
                                  <div class="col-md-6 wait-field">
                                    <h5 style="font-size: 26px;">
                                      Data Pengiriman
                                    </h5>
                                    <h5>
                                      Nama Penerima :
                                      <?= $row["nama_penerima"]; ?>
                                    </h5>
                                    <h5>
                                      No HP Penerima :
                                      <?= $row["no_hp"]; ?>
                                    </h5>
                                  </div>
                                  <div class="col-md-6">
                                    <h5 class="wait-harga-modal col-alamat" style="font-size: 26px;">
                                      Alamat Penerima :
                                    </h5>
                                    <h5 class="field-modal col-alamat">
                                      <?= $row["alamat"]; ?>
                                    </h5>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php
                            $no_trans = $row["no_trans"];
                            $detail = query("SELECT * FROM transaksi_item WHERE no_trans='$no_trans'");
                            foreach ($detail as $data) {
                              ?>
                              <div class="card custom-card">
                                <div class="custom-card-content">
                                  <div class="row">
                                    <div class="col-md-2">
                                      <img src="image/<?= $data["foto"]; ?>" width="100" class="wait-image" alt="">
                                    </div>
                                    <div class="col-md-7 wait-field">
                                      <h5>
                                        <?= $data["no_trans"]; ?>
                                      </h5>
                                      <h5 style="font-size: 26px;">
                                        <?= $data["nama"]; ?>
                                      </h5>
                                      <h5>
                                        <?= $data["ket"]; ?>
                                      </h5>
                                    </div>
                                    <div class="col-md-3">
                                      <h5 class="wait-harga-modal">
                                        IDR
                                        <?= number_format($data["harga"]); ?>
                                      </h5>
                                      <h5 class="field-modal">Jumlah</h5>
                                      <h5 class="field-modal">
                                        <?= $data["jumlah"]; ?> Item
                                      </h5>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <?php
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- modal upload bukti bayar -->
                  <div class="modal fade" id="pay<?= $row["no_trans"]; ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          <p class="modal-title" id="modalLabel" style="font-size: 20px;">Payment</p>
                        </div>
                        <div class="modal-body">
                          <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="no_trans" value="<?= $row["no_trans"]; ?>">
                            <div class="row">
                              <div class="col-md-4">
                                <h6 style="font-size: 15px;">
                                  Metode pembayaran :
                                </h6>
                                <img src="image/payment-logo/<?= $row["pembayaran"]; ?>.png" height="35" alt="payment">
                              </div>
                              <div class="col-md-8">
                                <h6 class="payment-notes">Silahkan melakukan pemabayaran ke nomor/rekening tujuan
                                  berikut :</h6>
                                <h6 class="payment-notes">
                                  <?php
                                  if ($row["pembayaran"] != "bca") {
                                    echo strtoupper($row["pembayaran"]) . " 085156963417 <br> a/n Nandang Budi";
                                  } elseif ($row["pembayaran"] == "bca") {
                                    echo "BCA 10123487 a/n Nandang Budi";
                                  }
                                  ?>
                                </h6>
                              </div>
                            </div>
                            <div class="row" style="margin-top: 2rem;">
                              <div class="col-md-8">
                                <label for="bayar">Unggah bukti pembayaran</label>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-8">
                                <input class="form-control" type="file" name="foto" id="bayar" style="width:auto;">
                              </div>
                              <div class="col-md-4" style="text-align: end;">
                                <button type="submit" class="btn btn-success"
                                  name="btn-payment"><strong>Pay</strong></button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- modal keterangan reject -->
                  <div class="modal fade" id="ketReject<?= $row["no_trans"]; ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-body">
                          <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="modal"
                              aria-label="Close">&times;</span></button>
                            <div class="alert-icon">
                              <i class="fa fa-warning"></i>
                            </div>
                            <div class="alert-text">
                              <h5>Keterangan reject</h5>
                              <ul>
                                <p>
                                  <?= $row["ket_reject"]; ?>
                                </p>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php
                endforeach;
              endif;
              ?>

            </div>
            <!-- end tab payment order -->

            <!-- tab on process order -->
            <div role="tabpanel" class="tab-pane" id="products">
              <?php
              if (isset($_SESSION["login"])):
                foreach ($on_process as $row):
                  ?>
                  <div class="card custom-card-onprocess">
                    <div class="custom-card-content">
                      <div class="row">
                        <div class="col-md-4 wait-field">
                          <h5 class="card-no">
                            <?= $row["no_trans"]; ?>
                          </h5>
                          <h5>Total</h5>
                          <h5>
                            <?= $row["jumlah_produk"] ?> Produk,
                            <?= $row["jumlah_order"]; ?> Item
                          </h5>
                        </div>
                        <div class="col-md-5 wait-field wait-ping">
                          <?php
                          if ($row["proses_status"] == "on process"):
                            ?>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="heartbeat"></div>
                                <div class="dot"></div>
                              </div>
                              <div class="col-md-10">
                                <span>
                                  <h5 class="pay-delay">
                                    admin sedang mempersiapkan pengiriman produk
                                  </h5>
                                </span>
                              </div>
                            </div>
                          <?php elseif ($row["proses_status"] == "on delivery"): ?>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="heartbeat-success"></div>
                                <div class="dot-success"></div>
                              </div>
                              <div class="col-md-10">
                                <span>
                                  <h5 class="pay-confirm">
                                    produk sedang dikirim, untuk detail pengiriman silahkan klik tombol dibawah
                                  </h5>
                                </span>
                              </div>
                              <div class="row text-center btn-deliv">
                                <button class="btn btn-warning btn-sm" type="button" data-toggle="modal"
                                  data-target="#detailDeliv<?= $row["no_trans"]; ?>"><strong>Cek Pengiriman <i
                                      class="fa fa-chevron-down"></i></strong></button>
                              </div>
                            </div>
                          <?php endif; ?>
                        </div>
                        <div class="col-md-3 detail-card">
                          <a href="" data-toggle="modal" data-target="#detailOrder<?= $row["no_trans"]; ?>">
                            <h5 class="wait-details">
                              details <i class="fa fa-chevron-right"></i>
                            </h5>
                          </a>
                          <h5 class="wait-harga">
                            IDR
                            <?= number_format($row["total"]); ?>
                          </h5>
                          <button class="btn btn-success btn-sm" type="button" data-toggle="modal"
                            data-target="#done<?= $row["no_trans"]; ?>"><strong>Done</strong></button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- modal detail pengiriman -->
                  <div class="modal fade" id="detailDeliv<?= $row["no_trans"]; ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-body">
                          <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="modal"
                              aria-label="Close">&times;</span></button>
                            <div class="alert-icon">
                              <i class="glyphicon glyphicon-info-sign"></i>
                            </div>
                            <div class="alert-text">
                              <div class="row">
                                <table class="table table-bordered">
                                  <thead class="thead-dark">
                                    <tr>
                                      <th colspan="2" class="text-center align-middle">
                                        <h5 style="font-size: 16px;">Detail Pengiriman</h5>
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        Nama Penerima
                                      </td>
                                      <td>
                                        <?= $row["nama_penerima"]; ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        Alamat
                                      </td>
                                      <td>
                                        <?= $row["alamat"]; ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        No. HP
                                      </td>
                                      <td>
                                        <?= $row["no_hp"]; ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        Ekspedisi
                                      </td>
                                      <td>
                                        <?= $row["ekspedisi"]; ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        No. Resi
                                      </td>
                                      <td>
                                        <?= $row["no_resi"]; ?>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- modal konfirmasi pesanan selesai -->
                  <div class="modal fade" id="done<?= $row["no_trans"]; ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-12 text-center">
                              <img src="image/payment-logo/deliv.png" width="250" alt="">
                            </div>
                          </div>
                          <div class="row" style="margin-top: 40px;">
                            <div class="col-md-12 text-center">
                              <h6 style="font-size: 25px;">Apakah anda yakin mengakhiri transaksi ini ?</h6>
                              <h6 style="font-size: 14px; padding-top: 1rem;">Periksa kembali produk anda, terimakasih</h6>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 btn-cancel">
                              <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal"
                                aria-label="Close"><strong>CANCEL </strong><i class="fa fa-circle-xmark"></i></button>
                            </div>
                            <div class="col-md-6 btn-end">
                              <button type="button" class="btn btn-success btn-lg"><strong>SELESAI </strong><i
                                  class="fa fa-circle-check"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- modal detail onprocess  -->
                  <div class="modal fade" id="detailOrder<?= $row["no_trans"]; ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          <p class="modal-title" id="modalLabel" style="font-size: 20px;">Detail Order</p>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="card custom-card-data">
                              <div class="custom-card-content">
                                <div class="row">
                                  <div class="col-md-6 wait-field">
                                    <h5 style="font-size: 26px;">
                                      Data Pengiriman
                                    </h5>
                                    <h5>
                                      Nama Penerima :
                                      <?= $row["nama_penerima"]; ?>
                                    </h5>
                                    <h5>
                                      No HP Penerima :
                                      <?= $row["no_hp"]; ?>
                                    </h5>
                                  </div>
                                  <div class="col-md-6">
                                    <h5 class="wait-harga-modal col-alamat" style="font-size: 26px;">
                                      Alamat Penerima :
                                    </h5>
                                    <h5 class="field-modal col-alamat">
                                      <?= $row["alamat"]; ?>
                                    </h5>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php
                            $no_trans = $row["no_trans"];
                            $detail = query("SELECT * FROM transaksi_item WHERE no_trans='$no_trans'");
                            foreach ($detail as $data) {
                              ?>
                              <div class="card custom-card">
                                <div class="custom-card-content">
                                  <div class="row">
                                    <div class="col-md-2">
                                      <img src="image/<?= $data["foto"]; ?>" width="100" class="wait-image" alt="">
                                    </div>
                                    <div class="col-md-7 wait-field">
                                      <h5>
                                        <?= $data["no_trans"]; ?>
                                      </h5>
                                      <h5 style="font-size: 26px;">
                                        <?= $data["nama"]; ?>
                                      </h5>
                                      <h5>
                                        <?= $data["ket"]; ?>
                                      </h5>
                                    </div>
                                    <div class="col-md-3">
                                      <h5 class="wait-harga-modal">
                                        IDR
                                        <?= number_format($data["harga"]); ?>
                                      </h5>
                                      <h5 class="field-modal">Jumlah</h5>
                                      <h5 class="field-modal">
                                        <?= $data["jumlah"]; ?> Item
                                      </h5>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <?php
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php
                endforeach;
              endif;
              ?>
            </div>
            <!-- end tab on process order -->

            <div role="tabpanel" class="tab-pane" id="services">
              rendis iste neque totam autem quam ratione odio culpa ex consectetur sit, facere sed, asperiores, deleniti
              dicta magnam ad.</div>
          </div>
        </div>
      </div>

    </div>
  </div>



  <div id="aboutus" class="bg-5">
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
          © 2023 Copyright:
          <a class="text-white" href="#">linkmeubel.com</a>
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