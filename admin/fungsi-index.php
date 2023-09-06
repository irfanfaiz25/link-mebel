<?php
include_once '../fungsi/fungsi.php';

$query = mysqli_query($konek, "SELECT COUNT(id_produk) AS jumlah FROM tb_produk");
$res = mysqli_fetch_assoc($query);
$count_total_product = $res["jumlah"];

$query = mysqli_query($konek, "SELECT * FROM transaksi_item WHERE proses_status='payment confirmation' GROUP BY no_trans");
$res = mysqli_num_rows($query);
$count_total_new_order = $res;

$query = mysqli_query($konek, "SELECT * FROM transaksi_item WHERE proses_status='done' GROUP BY no_trans");
$res = mysqli_num_rows($query);
$count_total_sold_items = $res;

$query = mysqli_query($konek, "SELECT SUM(harga*jumlah) AS income FROM transaksi_item WHERE proses_status='done'");
$res = mysqli_fetch_assoc($query);
$count_income = $res["income"];

$new_product = query("SELECT * FROM tb_produk ORDER BY id_produk DESC LIMIT 4");

$new_order = query("SELECT *, SUM(transaksi_item.jumlah) AS jml_item FROM transaksi_item LEFT JOIN user ON transaksi_item.id_user = user.id WHERE proses_status='payment confirmation' OR proses_status='repayment' GROUP BY no_trans ORDER BY no_trans DESC");


?>