<?php
include_once '../fungsi/fungsi.php';

$transaction = query("SELECT no_trans, id_user, id_produk, nama, ket, foto, tgl_transaksi, pembayaran, nama_penerima, no_hp, alamat, SUM(jumlah) AS jumlah_order, SUM(harga*jumlah) AS total, COUNT(id_produk) AS jumlah_produk, bukti_bayar, proses_status, no_resi FROM transaksi_item WHERE proses_status='on process' OR proses_status='on delivery' GROUP BY no_trans ORDER BY no_trans DESC");

if (isset($_POST["btn-add-resi"])) {
    if (addResi($_POST)) {
        header('Location: transaction.php');
    }
}

?>