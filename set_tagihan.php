<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 29/06/19
 * Time: 10:00
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'con.php';
    setTagihan();
}

function setTagihan() {
    global $connect;
    $idTagihan = $_POST["idTagihan"];
    $query = "UPDATE tagihan SET statusTagihan = 'selesai' WHERE idTagihan = $idTagihan";
    if (mysqli_query($connect, $query)) {
        echo "success";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }

    mysqli_close($connect);
}
