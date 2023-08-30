<?php

session_start();
include_once 'fungsi/fungsi.php';
if (isset($_SESSION["login"])) {
    $ses_id = $_SESSION["user"];

    $wait_confirm = query("SELECT no_trans, id_user, id_produk, nama, ket, foto, tgl_transaksi, pembayaran,SUM(jumlah) AS jumlah_order, SUM(harga*jumlah) AS total, COUNT(id_produk) AS jumlah_produk, bukti_bayar, nama_penerima, no_hp, alamat, ket_reject, proses_status FROM transaksi_item WHERE id_user='$ses_id' AND (proses_status='waiting for payment' OR proses_status='payment rejected' OR proses_status='payment confirmation' OR proses_status='repayment') GROUP BY no_trans ORDER BY no_trans DESC");

    $on_process = query("SELECT no_trans, id_user, id_produk, nama, ket, foto, tgl_transaksi, pembayaran,SUM(jumlah) AS jumlah_order, SUM(harga*jumlah) AS total, COUNT(id_produk) AS jumlah_produk, bukti_bayar, nama_penerima, no_hp, alamat, ket_reject, proses_status, ekspedisi, no_resi FROM transaksi_item WHERE id_user='$ses_id' AND (proses_status='on process' OR proses_status='on delivery') GROUP BY no_trans ORDER BY no_trans DESC");

    $history = query("SELECT no_trans, id_user, id_produk, nama, ket, foto, tgl_transaksi, pembayaran,SUM(jumlah) AS jumlah_order, SUM(harga*jumlah) AS total, COUNT(id_produk) AS jumlah_produk, bukti_bayar, nama_penerima, no_hp, alamat, ket_reject, proses_status, ekspedisi, no_resi FROM transaksi_item WHERE id_user='$ses_id' AND proses_status='done' GROUP BY no_trans ORDER BY no_trans DESC");

    $query = mysqli_query($konek, "SELECT COUNT(id_produk) AS jml_cart FROM cart WHERE id_user='$ses_id'");
    $res = mysqli_fetch_assoc($query);
    $count_cart = $res["jml_cart"];

    $query = mysqli_query($konek, "SELECT COUNT(no_trans) AS jml_trans FROM transaksi_item WHERE id_user='$ses_id' AND (proses_status='waiting for payment' OR proses_status='payment rejected' OR proses_status='payment confirmation' OR proses_status='repayment') GROUP BY no_trans");
    $res = mysqli_num_rows($query);
    $count_payment = $res;

    $query = mysqli_query($konek, "SELECT COUNT(no_trans) AS jml_process FROM transaksi_item WHERE id_user='$ses_id' AND (proses_status='on process' OR proses_status='on delivery') GROUP BY no_trans");
    $res = mysqli_num_rows($query);
    $count_process = $res;

    $query = mysqli_query($konek, "SELECT COUNT(no_trans) AS jml_process FROM transaksi_item WHERE id_user='$ses_id' AND proses_status='done' GROUP BY no_trans");
    $res = mysqli_num_rows($query);
    $count_history = $res;

} else {
    $count_cart = "0";
    $count_payment = "0";
    $count_process = "0";
    $count_history = "0";
}

$lemari = query("SELECT * FROM tb_produk WHERE kategori='Lemari'");
$kursi = query("SELECT * FROM tb_produk WHERE kategori='Kursi'");
$slider = query("SELECT * FROM tb_produk ORDER BY id_produk LIMIT 6");

if (isset($_POST["cart"])) {
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

if (isset($_POST["btn-order-done"])) {
    if (orderDone($_POST)) {
        header('Location: index.php#cart');
    }
}

$tahun = date("Y");

?>