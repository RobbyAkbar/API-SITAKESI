<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 10/03/19
 * Time: 17:56
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'con.php';
    createTagihan();
}

function createTagihan() {
    global $connect;
    $namaTagihan = $_POST["namaTagihan"];
    $jumlahTagihan = $_POST["jumlahTagihan"];
    $dtDeadline = $_POST["dtDeadline"];
    $idOrganisasi = $_POST["idOrganisasi"];
    $query = "INSERT INTO tagihan (namaTagihan, jumlahTagihan, dtDeadline, idOrganisasi) VALUES ('$namaTagihan','$jumlahTagihan','$dtDeadline','$idOrganisasi')";
    if (mysqli_query($connect, $query)) {
        echo "success";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }
    mysqli_close($connect);
}
