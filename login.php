<?php
session_start();
$error=NULL;
date_default_timezone_set("Asia/Kolkata");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'mail/Exception.php';
require 'mail/PHPMailer.php';
require 'mail/SMTP.php';

if(isset($_POST['submit'])){
  //Get form Data
  $email = $_POST['email'];
  $_SESSION['email'] = $email;

  //Connect to Database
  $mysqli = NEW MySQLi('localhost','root','','project');
  
  //Sanitize Data
  $email = $mysqli->real_escape_string($email);

  $result = $mysqli->query("SELECT * FROM users WHERE email = '$email'");
  if($result->num_rows == 1){
    //Collect data from database
    $row = $result->fetch_assoc();
    $uname = $row['username'];
    $_SESSION['uname'] = $uname;
    $verified = $row['verified'];
    $is_generated = $row['is_generated'];
    $date = $row['createdate'];
    $date = strtotime($date);
    $date = date('d M Y',$date);
    $_SESSION['access'] = '1';
    $_SESSION["value"] = 0;

    if($verified == 1){
        if($is_generated == 0){
          header('location:generate.php');
          exit;
        }
        header('location:auth.php');
              
    }else{
      $error = "This account has not yet been verified. An email was sent to $email on $date.";
    }
  }else{
    $error = "Email does not exist.";
  }
}
// if($_SESSION["value"]==0){ 
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="images/favicon.png" type="image">
</head>
<body>

    <div class="login-box">
        <div class="lb-header">
        <a class="active" id="login-box-link">Login</a>
        </div>
        <form class="email-login" method = "POST" name="emaillogin" id="emaillogin">
        <div class="u-form-group1">
            <input type="email" placeholder="Email" name = "email" required/><button type="SUBMIT" name = "submit" >Log in</button>
        </div>
        <div class="u-form-group-login">
            <center><p> Dont have an account? <a style="text-decoration:none" href="register.php">Sign up</a></p></center>
        </div>
        </form>
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
// }else{
//   header('location:main');
// }
?>