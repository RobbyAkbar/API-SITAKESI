<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 16/06/19
 * Time: 02:20
 */
require 'con.php';

$query = "SELECT * FROM agreement";
$result = mysqli_query($connect,$query);
$arr = array();

while ($row = mysqli_fetch_assoc($result)) {
    $temp = array("idAgree" => $row["idAgree"],"nameAgree" => $row["nameAgree"]);
    array_push($arr, $temp);
}

$data = json_encode($arr);
echo "$data";

mysqli_close($connect);
