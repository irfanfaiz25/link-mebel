<?php

$konek = mysqli_connect("localhost", "root", "", "db_sabana");

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

    $input = "INSERT IGNORE INTO tb_barang VALUES ('','$nama','$harga','$stok','$ket','$kategori','$foto')";
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

    $edit = "UPDATE tb_barang SET nama='$nama', harga_sewa='$harga', 
                stok='$stok', keterangan='$ket', kategori='$kategori', foto='$foto' WHERE id='$id'";
    mysqli_query($konek, $edit);

    return mysqli_affected_rows($konek);
}

function hapus($id)
{
    global $konek;

    mysqli_query($konek, "DELETE FROM tb_barang WHERE id = $id");

    return mysqli_affected_rows($konek);
}

function cariData($pencarian)
{
    global $konek;

    $query1 = "SELECT * FROM tb_barang WHERE id LIKE '%$pencarian%' OR nama LIKE '%$pencarian%' OR kategori LIKE '%$pencarian%'";

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

function hapusCart($id_rent)
{
    global $konek;

    $del = "DELETE FROM cart WHERE id_rent = $id_rent";
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
    // session_start();
    global $konek;
    $id_user = $_SESSION["user"];

    $co = query("SELECT * FROM cart WHERE id_user = $id_user");

    foreach ($co as $trans) {
        $id_barang = $trans["id_barang"];
        $nm_brg = $trans["nama"];
        $harga = $trans["harga_sewa"];
        $jumlah = $trans["jumlah"];
        $ket = $trans["ket"];
        $tgl_ambil = $data["tanggalambil"];
        $tgl_kembali = $data["tanggalkembali"];
        $selisih = strtotime($tgl_kembali) - strtotime($tgl_ambil);
        $lama_sewa = $selisih / (24 * 60 * 60);

        $query = "INSERT IGNORE INTO transaksi_item VALUES ('','$id_user','$id_barang','$nm_brg','$harga','$jumlah','$ket','$tgl_ambil','$tgl_kembali','$lama_sewa','online')";
        mysqli_query($konek, $query);


    }
    $result = mysqli_query($konek, "SELECT * FROM user WHERE id = '$id_user'");
    $row = mysqli_fetch_assoc($result);

    $jml_item = count(query("SELECT * FROM cart WHERE id_user = '$id_user' GROUP BY nama"));

    $nm_user = $row["nama"];
    $no_hp = $row["no_hp"];
    $tot = $_SESSION["total"];
    $total_sewa = $tot * $lama_sewa;
    $tgl_ambil = $data["tanggalambil"];
    $tgl_kembali = $data["tanggalkembali"];
    $selisih = strtotime($tgl_kembali) - strtotime($tgl_ambil);
    $lama_sewa = $selisih / (24 * 60 * 60);

    $queryUser = "INSERT IGNORE INTO transaksi_user VALUES ('','$id_user','$nm_user','$no_hp','$tgl_ambil','$tgl_kembali','$jml_item','$total_sewa')";
    mysqli_query($konek, $queryUser);

    return mysqli_affected_rows($konek);
}
?>