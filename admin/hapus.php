<?php
require '../fungsi/fungsi.php';

$id = $_GET["id"];

if (hapus($id) > 0) {
    header('Location: index.php');
} else {
    echo "
            <script>
                alert('data tidak berhasil dihapus');
                document.location.href = 'index.php';
            </script>
            ";
}
?>