<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 02/07/19
 * Time: 06:04
 */

include('connect.php');

$type = "";
$title = "";
$message = "";

if(isset($_GET['activation_code']))
{
    $query = "SELECT * FROM anggota WHERE kode_aktivasi = :activation_code";
    $statement = $conn->prepare($query);
    $statement->execute(
        array(':activation_code' => $_GET['activation_code'])
    );
    $no_of_row = $statement->rowCount();
    if($no_of_row > 0) {
        $result = $statement->fetchAll();
        foreach($result as $row) {
            if($row['status'] == 'not verified') {
                $update_query = "
				UPDATE anggota
				SET status = 'verified' 
				WHERE idAnggota = '".$row['idAnggota']."'
				";
                $statement = $conn->prepare($update_query);
                $statement->execute();
                $sub_result = $statement->fetchAll();
                if(isset($sub_result)) {
                    $type = "#4CAF50";$title = "Success!";
                    $message = "Your Email Address Successfully Verified. Now you can login";
                }
            } else {
                $type = "#2196F3";$title = "Info!";
                $message = "Your Email Address Already Verified";
            }
        }
    }
    else {
        $type = "#f44336";$title = "Danger!";
        $message = "Invalid Link";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Email Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .alert {padding: 20px;background-color: <?php echo $type; ?>;color: white;}
        .closebtn {margin-left: 15px;color: white;font-weight: bold;float: right;font-size: 22px;line-height: 20px;cursor: pointer;transition: 0.3s;}
        .closebtn:hover {color: black;}
    </style>
</head>
<body>
<div class="alert">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    <strong><?php echo $title; ?></strong> <?php echo $message; ?>.
</div>
</body>
</html>
