<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require 'mail/Exception.php';
  require 'mail/PHPMailer.php';
  require 'mail/SMTP.php'; 
  $error = NULL;

  if(isset($_POST['submit'])){
    //Get form data
    $uname = $_POST['uname'];
    $email = $_POST['email'];

    //Remove whitespaces from username
    $uname = preg_replace("/\s+/", "", $uname);


    if(strlen($uname)<5){
      $error = "Username must be atleast 5 Characters";
    }else{
      //Form is valid

      //Connect to database
      $mysqli = NEW MySQLi('localhost','root','','project');

      //Sanitize Form Data
      $uname = $mysqli->real_escape_string($uname);
      $email = $mysqli->real_escape_string($email);

      //Generate VKey
      $vkey = md5(time().$uname);
      
      //Insert Account into Database
      $insert = $mysqli->query("INSERT INTO users(username,email,vkey)VALUES('$uname','$email','$vkey')");
      if($insert){
        //Send email
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
        $mail->Subject = 'Email Verification';
        $mail->isHTML(true);
        $mail->Body = '
        <p style="font-size:16px; line-height:1.5em;">Hi <b>'.$_POST['uname'].'</b>,<br>
        Thanks for Registering with us, You are one step away to activate your account.</p>
        <br><a href="http://localhost/projectx/verify.php?vkey='.$vkey.'" style="text-decoration : none; padding : 0.7em 1em; background-color : #3282b8; color : #fff; border-radius : 7px;  ">Click here to activate</a><br>
        <br><p style="font-size:16px; line-height:1.5em;">Best Regards,<br>Project X</p>
        ';
        if($mail->send() == true){
          header('location:thankyou.php');
        }else{
          $error = "Mailer Error";
        }
      }else{
        $error=$mysqli->error;
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="images/favicon.png" type="image">
</head>
<body>

    <div class="login-box">
        <div class="lb-header">
        <a class="active" id="signup-box-link">Sign Up</a>
        </div>
        <form class="email-signup" method="POST" id="signup">
        <div class="u-form-group">
            <input type="text" name="uname" placeholder="Username" required/>
        </div>
        <div class="u-form-group">
            <input type="email" name="email" placeholder="Email" required/>
        </div>
        <div class="u-form-group">
            <button type="SUBMIT" name="submit">Sign Up</button>
        </div>
        <div class="u-form-group-login">
        <center><p> Already Registered ? <a style="text-decoration:none" href="login.php">Login</a></p></center>
        </div>
        </form>
        <center>
        <?php
            echo $error;
        ?>
        </center>
    </div>

</body>
</html>