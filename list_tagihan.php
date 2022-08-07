<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 25/06/19
 * Time: 01:23
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'con.php';
    listTagihan();
}

function listTagihan() {
    global $connect;
    $idOrganisasi = $_POST["idOrganisasi"];
    $query = "SELECT idTagihan, namaTagihan, jumlahTagihan, dtDeadline, statusTagihan FROM tagihan WHERE idOrganisasi = $idOrganisasi ORDER BY statusTagihan, dtBuat DESC";
    $result = mysqli_query($connect,$query);

    if(mysqli_num_rows($result)>0){
        $arr = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $temp = array("idTagihan" => $row["idTagihan"],"namaTagihan" => $row["namaTagihan"], "jumlahTagihan" => $row["jumlahTagihan"], "dtDeadline" => $row["dtDeadline"], "statusTagihan" => $row["statusTagihan"]);
            array_push($arr, $temp);
        }
        $data = json_encode($arr);
        echo "$data";
    } else {
        echo "failure";
    }

    mysqli_close($connect);
}
