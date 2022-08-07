<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 10/03/19
 * Time: 17:18
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'con.php';
    createOrganisasi();
}

function createOrganisasi() {
    global $connect;
    $organisasi = $_POST["organisasi"];
    $referral = $_POST["referral"];
    $instansi = $_POST["instansi"];
    $query = "INSERT INTO organisasi (namaOrganisasi, referral, namaInstansi) VALUES ('$organisasi', '$referral', '$instansi')";

    if (mysqli_query($connect, $query)) {
        $last_id = mysqli_insert_id($connect);
        createLingkup($last_id);
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }
}

function createLingkup($idOrganisasi){
    global $connect;
    $idAnggota = $_POST["idAnggota"];
    $query = "INSERT INTO lingkup(idAnggota, idOrganisasi) VALUES ($idAnggota, $idOrganisasi)";
    if (mysqli_query($connect, $query)) {
        echo "success~".$idOrganisasi;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }
}

mysqli_close($connect);
