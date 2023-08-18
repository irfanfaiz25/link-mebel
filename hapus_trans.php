<?php
require 'fungsi/fungsi.php';

$no_trans = $_GET["no_trans"];

if (hapusTrans($no_trans) > 0) {
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