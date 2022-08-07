<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 28/06/19
 * Time: 15:55
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'con.php';
    listLaporan();
}

function listLaporan() {
    global $connect;
    $idOrganisasi = $_POST["idOrganisasi"];
    $query = "SELECT idLaporan, ketLaporan, jenisLaporan, jumlah, dtBuat FROM laporan WHERE idOrganisasi = $idOrganisasi ORDER BY dtBuat DESC";
    $result = mysqli_query($connect,$query);

    if(mysqli_num_rows($result)>0){
        $arr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $temp = array("idLaporan" => $row["idLaporan"],"ketLaporan" => $row["ketLaporan"], "jenisLaporan" => $row["jenisLaporan"], "jumlah" => $row["jumlah"], "dtBuat" => $row["dtBuat"]);
            array_push($arr, $temp);
        }
        $data = json_encode($arr);
        echo "$data";
    } else {
        echo "failure";
    }

    mysqli_close($connect);
}
