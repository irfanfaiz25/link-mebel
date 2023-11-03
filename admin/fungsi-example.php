<?php
$jenengku = "jenengku akbar";

$db_server = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "db_example";

// $data = ['nama_user' => 'akbar pranowo', 'username' => 'akbar1', 'password' => 'akbar123'];

$konek_db = mysqli_connect($db_server, $db_username, $db_password, $db_name);

function tambahUser($data)
{
    global $konek_db;

    $nama_user = $data["nama_user"];
    $username = $data["username"];
    $password = $data["password"];

    mysqli_query($konek_db, "INSERT INTO tb_user (nama_user, username, password) VALUES ('$nama_user','$username','$password')");

    return mysqli_affected_rows($konek_db);
}

?>