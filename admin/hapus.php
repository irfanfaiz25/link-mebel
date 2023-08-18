<?php
require '../fungsi/fungsi.php';

$id = $_GET["id"];

if (hapus($id) > 0) {
    header('Location: produk.php');
} else {
    echo "
            <script>
                alert('data tidak berhasil dihapus');
                document.location.href = 'produk.php';
            </script>
            ";
}