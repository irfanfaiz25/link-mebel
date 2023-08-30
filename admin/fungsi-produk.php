<?php
include_once '../fungsi/fungsi.php';

if (isset($_POST["add"])) {
    if (tambah($_POST)) {
        header('Location: produk.php');
    } else {
        echo "
        <script>
            alert('data tidak berhasil ditambahkan');
            document.location.href = 'produk.php';
        </script>
        ";
    }
}


if (isset($_POST["edit"])) {
    if (ubah($_POST)) {
        header('Location: produk.php');
    } else {
        echo "
            <script>
                alert('data tidak berhasil di ubah');
                document.location.href = 'produk.php';
            </script>
            ";
    }
}

$barang = query("SELECT * FROM tb_produk ORDER BY kategori");