<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 10/03/19
 * Time: 17:17
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'con.php';
    confirmOrganisasi();
}
function confirmOrganisasi() {
    global $connect;
    $idOrganisasi = $_POST["idOrganisasi"];
    $months = $_POST["months"];
    $date = date("Y-m-d", strtotime("+$months Months"));
    $query = "UPDATE organisasi SET statusOrganisasi = 'aktif', dtAktif = '$date' WHERE idOrganisasi = $idOrganisasi";

    if (mysqli_query($connect, $query)) {
        echo "success";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }
    mysqli_close($connect);
}
