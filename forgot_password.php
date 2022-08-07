<?php
include('con.php');
if(isset($_POST["email"]) && (!empty($_POST["email"]))){
  $email = $_POST["email"];
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  if (!$email) {
    $error .="invalid email";//Invalid email address please type a valid email address!
  }else{
    $sel_query = "SELECT * FROM anggota WHERE email='$email'";
    $results = mysqli_query($connect,$sel_query);
    $row = mysqli_num_rows($results);
    if ($row==""){
      $error .= "no user";//No user is registered with this email address!
    }
  }
  if($error!=""){
    echo $error;
  }else{
    while ($row = mysqli_fetch_assoc($results)) {
      $nama = $row["namaAnggota"];
    }
    $expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
    $expDate = date("Y-m-d H:i:s",$expFormat);
    $key = md5(2418*2+$email);
    $addKey = substr(md5(uniqid(rand(),1)),3,10);
    $key = $key . $addKey;
    // Insert Temp Table
    mysqli_query($connect,"INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
    VALUES ('".$email."', '".$key."', '".$expDate."');");

    $base_url = "http://zeecodeku.xyz/sikeu/api/";
    $output='<p>Dear '.$nama.',</p>';
    $output.='<p>Please click on the following link to reset your password.</p>';
    $output.='<p>-------------------------------------------------------------</p>';
    $output.='<p><a href="'.$base_url.'reset-password.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">
    '.$base_url.'reset-password.php?key='.$key.'&email='.$email.'&action=reset</a></p>';
    $output.='<p>-------------------------------------------------------------</p>';
    $output.='<p>Please be sure to copy the entire link into your browser.
    The link will expire after 1 day for security reason.</p>';
    $output.='<p>If you did not request this forgotten password email, no action
    is needed, your password will not be reset. However, you may want to log into
    your account and change your security password as someone may have guessed it.</p>';
    $output.='<p>Thanks,</p>';
    $output.='<p>Zeecodeku Dev Team</p>';
    $body = $output;
    $subject = "Password Recovery - SITAKESI";

    $email_to = $email;
    require 'class/class.phpmailer.php';
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 2;
    $mail->IsSMTP();

    $mail->Host = 'srv68.niagahoster.com';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
    $mail->SMTPAuth = true;						//Sets SMTP authentication. Utilizes the Username and Password variables
    $mail->Username = 'admin@zeecodeku.xyz';	//Sets SMTP username
    $mail->Password = '@qazpoi*';				//Sets SMTP password
    $mail->SMTPSecure = 'ssl';					//Sets connection prefix. Options are "", "ssl" or "tls"
    $mail->Port = '465';						//Sets the default SMTP server port
    $mail->setFrom('noreply@zeecodeku.xyz', 'noreply');  //Sets the From email address and From name for the message
    $mail->addAddress($email_to);		    //Adds a "To" address
    $mail->IsHTML(true);					//Sets message type to HTML
    $mail->Subject = $subject; //Sets the Subject of the message
    $mail->Body = $body; //An HTML or plain text message body

    if(!$mail->Send()){
      echo "Mailer Error: " . $mail->ErrorInfo;
    }else{
      echo "success";//An email has been sent to you with instructions on how to reset your password.
    }
  }
}else{
?>
<form method="post" action="" name="reset"><br /><br />
<label><strong>Enter Your Email Address:</strong></label><br /><br />
<input type="email" name="email" placeholder="username@email.com" />
<br /><br />
<input type="submit" value="Reset Password"/>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php } ?>
