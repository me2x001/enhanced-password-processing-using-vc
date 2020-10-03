<?php 
session_start();
$error=NULL;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'mail/Exception.php';
require 'mail/PHPMailer.php';
require 'mail/SMTP.php';

if(isset($_SESSION['access'])){
  if(isset($_POST['generate'])) { 
    $mysqli = NEW MySQLi('localhost','root','','project');
    $uname = $_SESSION['uname'];
    $email = $_SESSION['email'];
    $result = $mysqli->query("SELECT is_generated FROM users WHERE username = '$uname'");
    if($result->num_rows == 1){
      $row = $result->fetch_assoc();
      $is_generated = $row['is_generated'];
      if($is_generated == 0){
        //execute python scripts      
        exec("C:\Python38\python.exe ./vc/init.py $uname");
        exec("C:\Python38\python.exe ./vc/encrypt.py ./vc/images/image.png $uname");
              
        //Send Mail 
        $mail = new PHPMailer(true);
        $mail->isSMTP(); 
        $mail->SMTPDebug = 0;
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = '';
        $mail->setFrom('', '');
        $mail->addAddress($email, $uname);
        $mail->Subject = 'Password';
        $mail->msgHTML('
                        <p style="font-size:16px; line-height:1.5em;">Hello <b>'.$uname.'</b>, Please find attachment for your password.<br />Best Regards,<br />Project X</p>
                      ');
        $mail->addAttachment("./vc/shares/".$uname.".png");
        if($mail->send() == true){ 
          $path = "C:/wamp64/www/projectx/vc/shares/".$uname."_2.png";
          $insertpasskey = $mysqli->query("UPDATE users SET passkey = '$path' WHERE username = '$uname' LIMIT 1");
          if($insertpasskey){
            $update = $mysqli->query("UPDATE users SET is_generated = 1 WHERE username = '$uname' LIMIT 1");
            if($update){
              exec("C:\Python38\python.exe ./vc/delete.py ./vc/shares/$uname.png");
              header('location:auth.php');
            }else{
              $error = $mysqli->error;
            }
          }else{
            $error = $mysqli->error;
          }
        }else{
          $error = "Mailer Error";
        }
      }else{
        $error = "Password is already generated. Please check your email.";
      }
    }
  }
  if($_SESSION["value"]==0){
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Log in</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="images/favicon.png" type="image">
</head>
<body>
  <div class="login-box">
    <div class="lb-header">
      <a class="active" id="login-box-link">Activated</a>
    </div>
    <center>
    <br><br><img src="images/success.png">
    <p>Your account was sucessfully verified. <br>Please generate your password by pressing button.</p>
    <form method="post">
      <div class="u-form-group">
        <button type="submit" name="generate">Generate Password</button><br><br>
      </div>
    </form>
    <div class="u-form-group-generate"></div>
    </center>
    <center>
    <?php
      echo $error;
    ?>
    </center>
    </div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

</body>
</html>
<?php
  }else{
    header('location:main');
  }
}else{
    header('location:login');
}
?>