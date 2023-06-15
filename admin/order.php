<?php
require '../fungsi/fungsi.php';

if (isset($_POST["add"])) {
    if (tambah($_POST)) {
        header('Location: barang.php');
    } else {
        echo "
					<script>
						alert('data tidak berhasil ditambahkan');
						document.location.href = 'barang.php';
					</script>
					";
    }
}


if (isset($_POST["edit"])) {
    if (ubah($_POST)) {
        header('Location: barang.php');
    } else {
        echo "
						<script>
							alert('data tidak berhasil di ubah');
							document.location.href = 'barang.php';
						</script>
						";
    }
}

$jmlData = 5;

$totalData = count(query("SELECT * FROM transaksi_user"));
$jumlahHalaman = ceil($totalData / $jmlData);
$halamanAktif = (isset($_GET["hal"])) ? $_GET["hal"] : 1;
$awalData = ($jmlData * $halamanAktif) - $jmlData;

$trans = query("SELECT * FROM transaksi_user LIMIT $awalData, $jmlData");

if (isset($_POST["btnCari"])) {
    $trans = cariData($_POST["pencarian"]);
} elseif (isset($_POST["btnReset"])) {
    $trans;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/style.css">

    <title>Sabana.adv Admin</title>
    <link rel="icon" href="../image/logo.png">

    <style>
        #main-content {
            transition: 0.4s;
            /* height: 1800px !important; */
        }

        body {
            background-color: #eee;
        }

        .card-body {
            color: #100F0F !important;
        }

        h1 {
            color: #023047 !important;
        }

        .nav-link:hover {
            background-color: #7B8FA1 !important;
        }

        .nav-link .fa {
            transition: all 1s;
        }

        .nav-link:hover .fa {
            transform: rotate(360deg);
        }

        .mar {
            margin: 5px 10px 5px !important;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }

        .margin-log {
            margin-top: 280px !important;
        }

        .navbar-brand {
            color: #ffffff !important;
            padding-top: 0px;
            padding-bottom: 0px;
            font-size: 22px !important;
            font-weight: normal !important;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }

        .navbar-brand span {
            color: #e63946;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-size: 40px;
        }

        .btn-outline-secondary {
            border-color: #8064A2 !important;
        }

        .btn-outline-secondary:hover {
            background-color: #023047 !important;
            color: antiquewhite !important;
        }

        .btn-outline-secondary:active {
            background-color: #023047 !important;
            color: antiquewhite !important;
        }

        .btn-outline-secondary:visited {
            background-color: #023047 !important;
            color: antiquewhite !important;
        }
    </style>
</head>

<body>

    <div>
        <div class="sidebar p-4 d-flex flex-column vh-100 flex-shrink-0 p-3 text-white bg-dark" id="sidebar">
            <a class="sidebar-brand logo-sbn">
                <img src="../image/logo2.png" alt="logo" height="75" style="padding-right: 20px; padding-bottom: 2px;">
            </a>

            <a class="judul-sbn navbar-brand" style="" href="#myPage">Sabana<span>.</span>adv</a>

            <div class="margin-set">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="mar">
                        <a class="nav-link text-white" href="index.php">
                            <i class="fa fa-home ic mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="mar">
                        <a class="nav-link text-white active" href="barang.php">
                            <i class="fa fa-wrench ic mr-2"></i>
                            Equipment
                        </a>
                    </li>
                    <li class="mar">
                        <a class="nav-link text-white" href="order.php">
                            <i class="fa fa-truck-fast ic mr-2"></i>Order
                        </a>
                    </li>
                    <li class="mar">
                        <a class="nav-link text-white" href="offline.php">
                            <i class="fa fa-user-xmark ic mr-2"></i>Offline Rent
                        </a>
                    </li>
                    <li class="mar">
                        <a class="nav-link text-white" href="history.php">
                            <i class="fa fa-clock-rotate-left ic mr-2"></i>
                            Rent History
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <section class="p-4" id="main-content">
        <div class="row">
            <div class="col-md-1">
                <button class="btn btn-outline-secondary mc" id="button-toggle">
                    <i class="bi bi-list"></i>
                </button>
            </div>
            <div class="col-md-9 float-start">
                <h1><b>DATA ORDER</b></h1>
                <p style="margin-bottom: -7px; margin-top: -5px; color: #7B8FA1 !important;">Sabana Adventure </p>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary mc float-end" id="button-toggle">
                    <i class="fa fa-right-from-bracket"></i>
                </button>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-body">

                <form action="" method="post">
                    <div class="row utama">
                        <div class="col-md-1">
                            <label style="margin-top: 5px;" for="cari">Cari data</label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control float-start"
                                style="margin-right: 0px; margin-left: 0px;" name="pencarian" id="cari"
                                placeholder="masukkan pencarian">
                        </div>
                        <div class="col-md-5" style="margin-left: 0px;">
                            <button type="submit" class="btn btn-primary float-start" href=""
                                name="btnCari">CARI</button>
                            <button type="submit" class="btn btn-danger" href="" name="btnReset"
                                style="margin-left: 4px;">RESET</button>
                        </div>
                    </div>
                </form>

                <!-- tabel data barang -->
                <div class="row dataku">

                    <div class="col-md-12 table-responsive-md">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="ctr">NO</th>
                                    <th class="ctr">ID TRANS USER</th>
                                    <th class="ctr">ID USER</th>
                                    <th class="ctr">NAMA</th>
                                    <th class="ctr">NO HP</th>
                                    <th class="ctr">TANGGAL AMBIL</th>
                                    <th class="ctr">TANGGAL KEMBALI</th>
                                    <th class="ctr">JUMLAH ITEM</th>
                                    <th class="ctr">TOTAL</th>
                                    <th class="ctr">AKSI</th>
                                </tr>
                            </thead>

                            <?php $i = 1; ?>
                            <?php foreach ($trans as $row): ?>
                                <tbody>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <?= $i + $awalData; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?= $row["id_trans_user"]; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?= $row["id_user"]; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?= $row["nama"]; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?= $row["no_hp"]; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?= $row["tgl_ambil"]; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?= $row["tgl_kembali"]; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?= $row["jml_item"]; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?= $row["total"]; ?>
                                        </td>

                                        <td class="text-center align-middle">
                                            <button style="margin-right: 5px;" type="submit" class="btn btn-primary btn-sm"
                                                name="ubah" data-toggle="modal"
                                                data-target="#editModal<?= $row["id_trans_user"]; ?>" href=""><i
                                                    class="fa fa-edit"></i> EDIT</button>
                                            <a class="btn btn-danger btn-sm" name="hapus"
                                                href="hapus.php?id=<?= $row["id_trans_user"]; ?>"><i
                                                    class="fa fa-trash"></i> HAPUS</a>
                                        </td>
                                    </tr>

                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>


                    <nav aria-label="...">
                        <ul class="pagination float-end">
                            <?php if ($halamanAktif > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?hal=<?= $halamanAktif - 1; ?>">
                                        &laquo
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $jumlahHalaman; $i++): ?>
                                <?php if ($i == $halamanAktif): ?>
                                    <li class="page-item active"><a class="page-link" href="?hal=<?= $i; ?>"><?= $i; ?></a></li>
                                <?php else: ?>
                                    <li class="page-item"><a class="page-link" href="?hal=<?= $i; ?>"><?= $i; ?></a></li>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php if ($halamanAktif < $jumlahHalaman): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?hal=<?= $halamanAktif + 1; ?>">
                                        &raquo
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>



                </div>
            </div>
        </div>
    </section>

    <script>
        // event will be executed when the toggle-button is clicked
        document.getElementById("button-toggle").addEventListener("click", () => {

            // when the button-toggle is clicked, it will add/remove the active-sidebar class
            document.getElementById("sidebar").classList.toggle("active-sidebar");

            // when the button-toggle is clicked, it will add/remove the active-main-content class
            document.getElementById("main-content").classList.toggle("active-main-content");
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>

</html>