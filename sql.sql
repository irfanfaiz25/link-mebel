CREATE DATABASE `db_mebel`;

CREATE TABLE `tb_produk` (
	id_produk int NOT NULL AUTO_INCREMENT,
	nama_produk varchar(35),
	harga int(20),
	stok int(10),
	keterangan varchar(100),
	kategori varchar(35),
	foto varchar(255),
	PRIMARY KEY (id_produk)
);

CREATE TABLE `cart` (
	id_cart int NOT NULL AUTO_INCREMENT,
	id_user int(20),
	id_produk int(15),
	nama_produk varchar(35),
	harga int(20),
	ket varchar(35),
	foto varchar(225),
	jumlah int(10),
	PRIMARY KEY (id_cart)
);

CREATE TABLE `transaksi_item` (
	no_trans varchar(100) NOT NULL,
	id_user int(50),
	id_produk int(10),
	nama_produk varchar(100),
	harga int(100),
	jumlah int(50),
	ket varchar(200),
	foto varchar(100),
	tgl_transaksi varchar(50),
	nama_penerima varchar(100),
	no_hp varchar(50),
	alamat varchar(225),
	pembayaran varchar(50),
	proses_status varchar(50),
	bukti_bayar varchar(100),
	ket_reject varchar(100),
	no_resi varchar(50),
	ekspedisi varchar(50)
);

CREATE TABLE `user` (
    id_user int NOT NULL AUTO_INCREMENT,
    nama varchar(50),
    username varchar(50),
    password varchar(225),
    no_hp varchar(100),
    level_user varchar(25),
    PRIMARY KEY (id_user)
);