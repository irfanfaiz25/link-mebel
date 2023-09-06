<?php

$db_server = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "db_mebel";
$konek = mysqli_connect($db_server, $db_username, $db_password, $db_name);

date_default_timezone_set("Asia/Jakarta");

function query($query)
{
    global $konek;
    $result = mysqli_query($konek, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data)
{
    global $konek;

    $nama = htmlspecialchars($data["nama"]);
    $harga = htmlspecialchars($data["harga"]);
    $stok = htmlspecialchars($data["stok"]);
    $ket = htmlspecialchars($data["ket"]);
    $kategori = htmlspecialchars($data["kategori"]);

    $foto = upload();
    if (!$foto) {
        return false;
    }

    $input = "INSERT IGNORE INTO tb_produk VALUES ('','$nama','$harga','$stok','$ket','$kategori','$foto')";
    mysqli_query($konek, $input);

    return mysqli_affected_rows($konek);
}

function upload()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuran = $_FILES['foto']['size'];
    $eror = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    if ($eror === 4) {
        echo "
                <script>
                    alert('Pilih foto yang akan di upload');
                </script>
            ";
        return false;
    }

    $valEkstensiFoto = ['jpg', 'jpeg', 'png'];
    $ekstensiFoto = explode('.', $namaFile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));

    if (!in_array($ekstensiFoto, $valEkstensiFoto)) {
        echo "
                <script>
                    alert('Tidak ada file yang di ambil');
                </script>
            ";
        return false;
    }

    if ($ukuran > 2000000) {
        echo "
                <script>
                    alert('Tidak ada file yang di ambil');
                </script>
            ";
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiFoto;

    move_uploaded_file($tmpName, '../image/' . $namaFileBaru);
    return $namaFileBaru;
}

function uploadBukti($no_trans)
{
    $namaFile = $_FILES['foto']['name'];
    $ukuran = $_FILES['foto']['size'];
    $eror = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    if ($eror === 4) {
        echo "
                <script>
                    alert('Pilih foto yang akan di upload');
                </script>
            ";
        return false;
    }

    $valEkstensiFoto = ['jpg', 'jpeg', 'png'];
    $ekstensiFoto = explode('.', $namaFile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));

    if (!in_array($ekstensiFoto, $valEkstensiFoto)) {
        echo "
                <script>
                    alert('Tidak ada file yang di ambil');
                </script>
            ";
        return false;
    }

    if ($ukuran > 2000000) {
        echo "
                <script>
                    alert('Tidak ada file yang di ambil');
                </script>
            ";
        return false;
    }

    $namaFileBaru = $no_trans . "_" . date("Y-m-d H.i.s");
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiFoto;

    move_uploaded_file($tmpName, 'image/bukti-pembayaran/' . $namaFileBaru);
    return $namaFileBaru;
}

function ubah($data)
{
    global $konek;

    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $harga = htmlspecialchars($data["harga"]);
    $stok = htmlspecialchars($data["stok"]);
    $ket = htmlspecialchars($data["ket"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $fotoLama = htmlspecialchars($data["fotoLama"]);

    if ($_FILES["foto"]["error"] === 4) {
        $foto = $fotoLama;
    } else {
        $foto = upload();
    }

    $edit = "UPDATE tb_produk SET nama='$nama', harga='$harga', 
                stok='$stok', keterangan='$ket', kategori='$kategori', foto='$foto' WHERE id_produk='$id'";
    mysqli_query($konek, $edit);

    return mysqli_affected_rows($konek);
}

function hapus($id)
{
    global $konek;

    mysqli_query($konek, "DELETE FROM tb_produk WHERE id_produk = $id");

    return mysqli_affected_rows($konek);
}

function cariData($pencarian)
{
    global $konek;

    $query1 = "SELECT * FROM tb_produk WHERE id_produk LIKE '%$pencarian%' OR nama LIKE '%$pencarian%' OR kategori LIKE '%$pencarian%'";

    return query($query1);
}

function formatRupiah($angka)
{
    if ($angka > 0) {
        $hasilRupiah = "Rp. " . number_format($angka, 0, ',', '.');
    } else {
        $hasilRupiah = "Rp. 0";
    }
    return $hasilRupiah;
}

function addCart($id, $nm, $hrg, $ket, $foto, $jumlah)
{
    session_start();
    global $konek;
    $id_user = $_SESSION["user"];

    $cartId = $id;
    $cartNama = $nm;
    $cartHarga = $hrg;
    $cartKet = $ket;
    $cartFoto = $foto;
    $cartJumlah = $jumlah;

    $query = "INSERT IGNORE INTO cart VALUES ('','$id_user','$cartId','$cartNama','$cartHarga','$cartKet','$cartFoto','$cartJumlah')";

    mysqli_query($konek, $query);

    return mysqli_affected_rows($konek);
}

function hapusCart($id_cart)
{
    global $konek;

    $del = "DELETE FROM cart WHERE id_cart = $id_cart";
    mysqli_query($konek, $del);

    return mysqli_affected_rows($konek);
}

function daftar($data)
{
    global $konek;

    $nama = $data["nama"];
    $no_hp = $data["no_hp"];
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($konek, $data["password"]);
    $password2 = mysqli_real_escape_string($konek, $data["passwordConfirm"]);

    $rs = mysqli_query($konek, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($rs)) {
        echo "
            <script>
                alert('Username sudah ada !');
            </script>
        ";
        return false;
    }

    if ($password != $password2) {
        echo "
            <script>
                alert('Masukkan konfirmasi password dengan benar !');
            </script>
        ";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $inp = "INSERT IGNORE INTO user VALUES ('','$nama','$username','$password','$no_hp','')";
    mysqli_query($konek, $inp);

    return mysqli_affected_rows($konek);
}

function checkout($data)
{
    global $konek;
    $id_user = $_SESSION["user"];
    $nama_penerima = $data["nama_penerima"];
    $no_hp = $data["no_hp"];
    $alamat = $data["alamat"];
    $pembayaran = $data["pembayaran"];
    // $notes = $data["notes"];
    // membuat kode
    $query = mysqli_query($konek, "SELECT max(no_trans) AS kodeTerbesar FROM transaksi_item");
    $data = mysqli_fetch_array($query);
    $kode_sample = $data['kodeTerbesar'];
    $year_now = date("y");
    $urutan = (int) substr($kode_sample, 4, 4);
    $urutan++;
    $huruf = "TR";
    $kode_sample = $huruf . $year_now . sprintf("%04s", $urutan);
    // kode selesai

    $co = query("SELECT * FROM cart WHERE id_user = $id_user");

    foreach ($co as $trans) {
        // $id_cart = $trans["id_cart"];
        $id_produk = $trans["id_produk"];
        $nm_brg = $trans["nama"];
        $harga = $trans["harga"];
        $jumlah = $trans["jumlah"];
        $foto = $trans["foto"];
        $notes = $trans["ket"];
        $tgl = date("Y-m-d H:i:s");

        $query = "INSERT IGNORE INTO transaksi_item VALUES ('$kode_sample','$id_user','$id_produk','$nm_brg','$harga','$jumlah','$notes','$foto','$tgl','$nama_penerima','$no_hp','$alamat','$pembayaran','waiting for payment','','','','','')";
        mysqli_query($konek, $query);
    }

    $del = "DELETE FROM cart WHERE id_user = '$id_user'";
    mysqli_query($konek, $del);

    return mysqli_affected_rows($konek);
}

function hapusTrans($no_trans)
{
    global $konek;

    $query = "DELETE FROM transaksi_item WHERE no_trans='$no_trans'";
    mysqli_query($konek, $query);

    return mysqli_affected_rows($konek);
}

function updatePayment($data)
{
    global $konek;

    $no_trans = $data["no_trans"];

    $foto = uploadBukti($no_trans);
    if (!$foto) {
        return false;
    }

    $query_cek = mysqli_query($konek, "SELECT * FROM transaksi_item WHERE no_trans='$no_trans'");
    $cek_bukti = mysqli_fetch_assoc($query_cek);

    if ($cek_bukti["bukti_bayar"] == "") {
        $proses = "payment confirmation";
    } else {
        $proses = "repayment";
    }

    $query = "UPDATE transaksi_item SET bukti_bayar='$foto', proses_status='$proses' WHERE no_trans='$no_trans'";
    mysqli_query($konek, $query);

    return mysqli_affected_rows($konek);
}

function orderRejected($data)
{
    global $konek;

    $no_trans = $data["no_trans"];
    $ket_reject = $data["ket_reject"];

    $query = "UPDATE transaksi_item SET proses_status='payment rejected',ket_reject='$ket_reject' WHERE no_trans='$no_trans'";
    mysqli_query($konek, $query);

    return mysqli_affected_rows($konek);
}

function orderAccepted($data)
{
    global $konek;

    $no_trans = $data["no_trans"];
    $query = mysqli_query($konek, "SELECT * FROM transaksi_item WHERE no_trans='$no_trans' GROUP BY id_produk");
    while ($row = mysqli_fetch_assoc($query)) {
        $id_produk = $row["id_produk"];
        $jumlah = $row["jumlah"];
        mysqli_query($konek, "UPDATE tb_produk SET stok=(stok-$jumlah) WHERE id_produk=$id_produk");
    }

    $query = "UPDATE transaksi_item SET proses_status='on process' WHERE no_trans='$no_trans'";
    mysqli_query($konek, $query);

    return mysqli_affected_rows($konek);
}

function addResi($data)
{
    global $konek;

    $no_trans = $data["no_trans"];
    $no_resi = $data["no_resi"];
    $ekspedisi = $data["ekspedisi"];

    $query = "UPDATE transaksi_item SET no_resi='$no_resi', ekspedisi='$ekspedisi', proses_status='on delivery' WHERE no_trans='$no_trans'";
    mysqli_query($konek, $query);

    return mysqli_affected_rows($konek);
}

function statusBadges($data)
{
    if ($data == "waiting for payment") {
        $badges = '<span class="badge bg-secondary">' . $data . '</span>';
    } elseif ($data == "payment confirmation") {
        $badges = '<span class="badge bg-primary">' . $data . '</span>';
    } elseif ($data == "payment rejected") {
        $badges = '<span class="badge bg-danger">' . $data . '</span>';
    } elseif ($data == "repayment") {
        $badges = '<span class="badge bg-dark">' . $data . '</span>';
    } elseif ($data == "on process") {
        $badges = '<span class="badge bg-warning">' . $data . '</span>';
    } elseif ($data == "on delivery") {
        $badges = '<span class="badge bg-success">' . $data . '</span>';
    }

    return $badges;
}

function orderDone($data)
{
    global $konek;

    $no_trans = $data["no_trans"];

    $query = "UPDATE transaksi_item SET proses_status='done' WHERE no_trans='$no_trans'";
    mysqli_query($konek, $query);

    return mysqli_affected_rows($konek);
}