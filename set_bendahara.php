<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 10/03/19
 * Time: 17:24
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'con.php';
    $statusAnggota = $_POST["statusAnggota"];
    if ($statusAnggota=="anggota") changeStatus();
    if ($statusAnggota=="bendahara") countBendahara();
}
function countBendahara() {
    global $connect;
    $idOrganisasi = $_POST["idOrganisasi"];
    $query = "SELECT count(idLingkup) FROM lingkup WHERE idOrganisasi = $idOrganisasi AND statusAnggota = 'bendahara'";
    $result = mysqli_query($connect,$query);
    $row = mysqli_fetch_assoc($result);
    if ($row["count(idLingkup)"] < 2) changeStatus();
    else echo "failure";
}
function changeStatus() {
    global $connect;
    $idAnggota = $_POST["idAnggota"];
    $idOrganisasi = $_POST["idOrganisasi"];
    $statusAnggota = $_POST["statusAnggota"];
    $query = "UPDATE lingkup SET statusAnggota = '$statusAnggota' WHERE idAnggota = $idAnggota AND idOrganisasi = $idOrganisasi";
    if (mysqli_query($connect, $query)) {
        echo "success";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }
}
mysqli_close($connect);
