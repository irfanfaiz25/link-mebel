<?php
include_once '../fungsi/fungsi.php';

$sales_history = query("SELECT no_trans, id_user, id_produk, nama, ket, foto, tgl_transaksi, tgl_selesai, pembayaran, nama_penerima, no_hp, alamat, SUM(jumlah) AS jumlah_order, SUM(harga*jumlah) AS total, COUNT(id_produk) AS jumlah_produk, bukti_bayar, proses_status, no_resi FROM transaksi_item WHERE proses_status='done' GROUP BY no_trans ORDER BY no_trans DESC");
?>