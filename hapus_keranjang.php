<?php
require 'fungsi/fungsi.php';

$id_rent = $_GET["id_rent"];

if (hapusCart($id_rent) > 0) {
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