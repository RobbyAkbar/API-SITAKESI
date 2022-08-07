<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 10/03/19
 * Time: 17:23
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'con.php';
    searchOrganisasi();
}
function searchOrganisasi() {
    global $connect;
    $referral = $_POST["referral"];
    $query = "SELECT idOrganisasi FROM organisasi WHERE referral = '$referral'";
    $result = mysqli_query($connect,$query);

    while ($row = mysqli_fetch_assoc($result)) {
      joinOrganisasi($row["idOrganisasi"]);
    }
}

function joinOrganisasi($idOrganisasi) {
    global $connect;
    $idAnggota = $_POST["idAnggota"];
    $sql = "SELECT idAnggota FROM lingkup WHERE idAnggota = $idAnggota AND idOrganisasi = $idOrganisasi";
    $result = mysqli_query($connect,$sql);
    if(mysqli_num_rows($result)>0){
      echo "failure";
      return;
    }

    $query = "INSERT INTO lingkup (idAnggota, idOrganisasi, statusAnggota) VALUES ($idAnggota, $idOrganisasi,'anggota')";
    if (mysqli_query($connect, $query)) {
        echo "success~".$idOrganisasi;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }
}

mysqli_close($connect);
