<?php
/**
 * Created by PhpStorm.
 * User: robby
 * Date: 10/03/19
 * Time: 17:22
 */

if($_SERVER['REQUEST_METHOD']=='POST'){
    require_once('connect.php');
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM anggota WHERE email = :user_email";

    $statement = $conn->prepare($sql);
    $statement->execute(
        array(
            ':user_email'	=>	$email
        )
    );
    $count = $statement->rowCount();
    if($count > 0) {
        $result = $statement->fetchAll();
        foreach($result as $row) {
            if($row['status'] == 'verified') {
                if(password_verify($password, $row["password"])) {
                    echo "success~".$row['idAnggota']."~".$row['namaAnggota']."~".$row['dtBuat'];
                } else {
                    echo "wrong password";
                }
            } else {
                echo "not verified";
            }
        }
    } else {
        echo "wrong email";
    }
}

//if($_SERVER['REQUEST_METHOD']=='POST'){
//    require_once('con.php');
//    $email = $_POST['email'];
//    $password = $_POST['password'];
//    $sql = "SELECT * FROM anggota WHERE email='$email' AND password='$password'";
//
//    $result = mysqli_query($connect,$sql);
//
//    if(mysqli_num_rows($result)>0){
//        $row = mysqli_fetch_assoc($result);
//        echo "success~".$row['idAnggota']."~".$row['namaAnggota']."~".$row['dtBuat'];
//    }else{
//        echo "failure";
//    }
//    mysqli_close($connect);
//}
