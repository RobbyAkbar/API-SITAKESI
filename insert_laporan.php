<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 28/06/19
 * Time: 14:40
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'con.php';
    createLaporan();
}

function createLaporan() {
    global $connect;
    $idOrganisasi = $_POST["idOrganisasi"];
    $jenisLaporan = $_POST["jenisLaporan"];
    $jumlah = $_POST["jumlah"];
    $ketLaporan = $_POST["ketLaporan"];
    $query = "INSERT INTO laporan (idOrganisasi, jenisLaporan, jumlah, ketLaporan) VALUES ('$idOrganisasi','$jenisLaporan','$jumlah','$ketLaporan')";
    if (mysqli_query($connect, $query)) {
        echo "success";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }
    mysqli_close($connect);
}
