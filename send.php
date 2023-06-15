<?php
session_start();
require 'fungsi/fungsi.php';

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
    $rs = mysqli_query($konek, "SELECT * FROM user WHERE id = $user");
    $row = mysqli_fetch_assoc($rs);
    $cartCek = mysqli_query($konek, "SELECT * FROM cart WHERE id_user = $user");
    $rowCek = mysqli_num_rows($cartCek);

    if ($rowCek == 0) {
        echo "
            <script>
                alert('Keranjang masih kosong !');
            </script>
        ";
        return false;
    } else {
        $order = $row["nama"];
        $no_hp = $row["no_hp"];

        $pesanan = query("SELECT * FROM cart WHERE id_user = $user");
    }

} else {
    echo "
            <script>
                alert('Silahkan login terlebih dahulu !');
            </script>
        ";
    return false;
}


$token = "gBcStP9Rv-!jxQIcABmT";
$target = $no_hp;

$curl = curl_init();

curl_setopt_array(
    $curl,
    array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $target,
            'message' => "Pesanan dari atas nama " . $order . " " . $no_hp,
            'countryCode' => '62',
            //optional
        ),
        CURLOPT_HTTPHEADER => array(
            "Authorization: $token" //change TOKEN to your actual token
        ),
    )
);

$response = curl_exec($curl);

curl_close($curl);
echo $response;