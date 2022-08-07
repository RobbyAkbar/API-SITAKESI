<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 10/03/19
 * Time: 17:21
 */
require 'con.php';
$query = "SELECT idOrganisasi, namaOrganisasi, statusOrganisasi, namaInstansi FROM organisasi ORDER BY statusOrganisasi, namaOrganisasi";
$result = mysqli_query($connect,$query);
$arr = array();

while ($row = mysqli_fetch_assoc($result)) {
    $temp = array("idOrganisasi" => $row["idOrganisasi"],"namaOrganisasi" => $row["namaOrganisasi"], "statusOrganisasi" => $row["statusOrganisasi"], "namaInstansi" => $row["namaInstansi"]);
    array_push($arr, $temp);
}

$data = json_encode($arr);
echo "$data";

mysqli_close($connect);
