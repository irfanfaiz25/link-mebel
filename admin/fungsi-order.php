<?php
include_once '../fungsi/fungsi.php';

$order = query("SELECT no_trans, id_user, id_produk, nama, ket, foto, tgl_transaksi, pembayaran, nama_penerima, no_hp, alamat, SUM(jumlah) AS jumlah_order, SUM(harga*jumlah) AS total, COUNT(id_produk) AS jumlah_produk, bukti_bayar, proses_status FROM transaksi_item WHERE proses_status='waiting for payment' OR proses_status='payment rejected' OR proses_status='payment confirmation' OR proses_status='repayment' GROUP BY no_trans ORDER BY no_trans DESC");

if (isset($_POST["btn-reject"])) {
    if (orderRejected($_POST)) {
        header('Location: order.php');
    }
}

if (isset($_POST["btn-acc"])) {
    if (orderAccepted($_POST)) {
        header('Location: order.php');
    }
}


?>