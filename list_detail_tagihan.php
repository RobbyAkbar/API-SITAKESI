<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 27/06/19
 * Time: 00:12
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'con.php';
    listDetailTagihan();
}

function listDetailTagihan() {
    global $connect;
    $idTagihan = $_POST["idTagihan"];
    $idOrganisasi = $_POST["idOrganisasi"];
    $query = "SELECT anggota.idAnggota, anggota.namaAnggota, lingkup.statusAnggota, SUM(pembayaran.jumlahBayar) AS totalBayar,
        CASE
          WHEN SUM(pembayaran.jumlahBayar) = tagihan.jumlahTagihan THEN 'lunas'
          ELSE 'belum lunas'
        END AS 'statusTagihan' FROM anggota
        INNER JOIN lingkup ON anggota.idAnggota = lingkup.idAnggota
        LEFT JOIN pembayaran ON anggota.idAnggota = pembayaran.idAnggota AND pembayaran.idTagihan = $idTagihan
        LEFT JOIN tagihan ON pembayaran.idTagihan = tagihan.idTagihan AND tagihan.idTagihan = $idTagihan
        WHERE lingkup.idOrganisasi = $idOrganisasi GROUP BY anggota.idAnggota, anggota.namaAnggota, lingkup.statusAnggota
        ORDER BY statusTagihan, anggota.namaAnggota";
    $result = mysqli_query($connect,$query);

    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $temp = array("idAnggota" => $row["idAnggota"],"namaAnggota" => $row["namaAnggota"], "statusAnggota" => $row["statusAnggota"], "totalBayar" => $row["totalBayar"], "statusTagihan" => $row["statusTagihan"]);
        array_push($arr, $temp);
    }
    $data = json_encode($arr);
    echo "$data";

    mysqli_close($connect);
}
