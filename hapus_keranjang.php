<?php
require 'fungsi/fungsi.php';

$id_cart = $_GET["id_cart"];

if (hapusCart($id_cart) > 0) {
    header('Location: index.php?#cart');
} else {
    echo "
        <script>
            alert('Data gagal dihapus');
        </script>
    ";
    header('Location: index.php#cart');
}

?>