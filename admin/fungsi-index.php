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


?>