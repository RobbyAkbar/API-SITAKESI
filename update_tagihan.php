<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 27/06/19
 * Time: 21:20
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'con.php';
    updateTagihan();
}

function updateTagihan() {
    global $connect;
    $idAnggota = $_POST["idAnggota"];
    $idTagihan = $_POST["idTagihan"];
    $jumlahBayar = $_POST["jumlahBayar"];
    $query = "INSERT INTO pembayaran (idAnggota, idTagihan, jumlahBayar) VALUES ('$idAnggota','$idTagihan','$jumlahBayar')";
    if (mysqli_query($connect, $query)) {
        echo "success";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }
    mysqli_close($connect);
}
