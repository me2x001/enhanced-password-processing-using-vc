<?php 
session_start();
$error=NULL;
if(isset($_SESSION['access'])){
    if(isset($_POST['submit'])){
        if (isset($_FILES['passkey'])){
            $filePath = $_FILES['passkey']['tmp_name'];
            $fileName = $_FILES['passkey']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $allowedfileExtensions = 'png';
            if ($fileExtension == $allowedfileExtensions){
                $email = $_SESSION['email'];
                $mysqli = NEW MySQLi('localhost','root','','project');
                $result = $mysqli->query("SELECT * FROM users WHERE email = '$email'");
                //Collect data from database
                $row = $result->fetch_assoc();
                $filepath2 = $row['passkey'];
                $uname = $_SESSION['uname'];
                $r=exec("C:\Python38\python.exe ./vc/decrypt.py $filePath $filepath2");
                if($uname == $r){
                    $_SESSION["value"] = 0;
                    $_SESSION["logvalue"]=1;
                    header('location:main.php');
                }else{
                    $error = "Incorrect Password";
                    // $error = $r;
                }
            }else{
                $error = "Please upload valid file";
            }
        }else{
            $error = "Uploading failed";
        }
    }
    if($_SESSION["value"]==0){
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
        <form class="email-login1" method = "POST" name="emaillogin" id="emaillogin" enctype="multipart/form-data" >
        <div class="u-form-group3">
            <p>Hello <b><?php echo $_SESSION["uname"]; ?></b>, Please upload your generated password.</p>
            <div class="file-upload"> <span id="filename">Select your file</span>
                <label for="fileLoader">
                  Browse
                  <input type="file" id="fileLoader" name="passkey" accept="image/*">
            </div>
            <button type="SUBMIT" name = "submit">Log in</button>
        </div>
        </form>
        <center>
        <?php
            echo $error;
        ?>
        </center>
    </div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script>
    $('#fileLoader').change(function() {
        var filepath = this.value;
        var m = filepath.match(/([^\/\\]+)$/);
        var filename = m[1];
        $('#filename').html(filename);
    });
</script>

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