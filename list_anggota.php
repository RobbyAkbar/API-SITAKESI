<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 10/03/19
 * Time: 17:20
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'con.php';
    listAnggota();
}

function listAnggota() {
    global $connect;
    $idOrganisasi = $_POST["idOrganisasi"];
    $query = "SELECT lingkup.idAnggota, anggota.namaAnggota, lingkup.statusAnggota FROM lingkup INNER JOIN anggota ON lingkup.idAnggota = anggota.idAnggota WHERE lingkup.idOrganisasi = $idOrganisasi ORDER BY statusAnggota, namaAnggota";
    $result = mysqli_query($connect,$query);
    $arr = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $temp = array("idAnggota" => $row["idAnggota"],"namaAnggota" => $row["namaAnggota"], "statusAnggota" => $row["statusAnggota"]);
        array_push($arr, $temp);
    }

    $data = json_encode($arr);
    echo "$data";

    mysqli_close($connect);
}
