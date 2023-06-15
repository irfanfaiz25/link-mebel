<?php
require 'fungsi/fungsi.php';

$id = $_GET["id_barang"];
$jumlah = $_GET["quant"];


$pilih = query("SELECT * FROM tb_barang WHERE id=$id");
$pilihId = query("SELECT * FROM user_log ORDER BY id DESC");

$cartId = $pilih["id"];
$id_user = $pilihId["id_user"];
$cartNama = $pilih["nama"];
$cartHarga = $pilih["harga_sewa"];
$cartKet = $pilih["keterangan"];
$cartFoto = $pilih["foto"];
$cartJumlah = $jumlah;

$query = "INSERT IGNORE INTO cart VALUES ('','$id_user','$cartId','$cartNama','$cartHarga','$cartKet','$cartFoto','$cartJumlah')";

mysqli_query($konek, $query);

?>