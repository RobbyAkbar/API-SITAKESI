<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 28/06/19
 * Time: 22:12
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'con.php';
    getDana();
}

function getDana() {
    global $connect;
    $idOrganisasi = $_POST["idOrganisasi"];
    $query1 = "SELECT SUM(pembayaran.jumlahBayar) AS bayar from pembayaran INNER JOIN tagihan ON pembayaran.idTagihan = tagihan.idTagihan WHERE tagihan.idOrganisasi = $idOrganisasi";
    $query2 = "SELECT SUM(jumlah) AS jumlah, jenisLaporan from laporan WHERE idOrganisasi = $idOrganisasi GROUP BY jenisLaporan";
    $result1 = mysqli_query($connect,$query1);
    $result2 = mysqli_query($connect,$query2);

    while ($row = mysqli_fetch_assoc($result1)) {
        if ($row["bayar"]==null){
            echo "0~";
        } else echo $row["bayar"]."~";
    }

    if(mysqli_num_rows($result2)==1){
        while ($row = mysqli_fetch_assoc($result2)) {
            if ($row["jenisLaporan"]=="pemasukan") echo $row["jumlah"]."~0~";
            else if ($row["jenisLaporan"]=="pengeluaran") echo "0~".$row["jumlah"]."~";
        }
    } else if (mysqli_num_rows($result2)==2){
        while ($row = mysqli_fetch_assoc($result2)) {
            echo $row["jumlah"]."~";
        }
    } else { echo "0~0~"; }

    mysqli_close($connect);
}
