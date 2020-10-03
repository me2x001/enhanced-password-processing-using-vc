<?php 

// $v='test';

// exec("del ./vc/test/$v.txt");
// echo "done";
// shell_exec("C:\Python38\python.exe ./vc/init.py $v");
// shell_exec("C:\Python38\python.exe ./vc/encrypt.py ./vc/images/image.png ");
// echo (shell_exec("C:\Python38\python.exe ./vc/decrypt.py"));
// $mysqli = NEW MySQLi('localhost','root','','project');


// // $insert = $mysqli->query("INSERT INTO users(password)VALUES('$path')");
// $insert = $mysqli->query("INSERT INTO users(passkey)VALUES('aheellotestthisis')");

// if($insert){
//     echo "inserted successfully";
// }


if(isset($_POST['submit'])){
    echo php_ini_loaded_file(); 
    // $uname = "testmittu2";

    // $mysqli = NEW MySQLi('localhost','root','','project'); //Change these database credentials with yours

    // $path = "C:/wamp64/www/projectx/vc/shares/".$uname."_2.png";

    // // $insert = $mysqli->query("INSERT INTO users(passkey)VALUES('this is test')");
    // $insert = $mysqli->query("UPDATE users SET passkey = '$path' WHERE username = '$uname' LIMIT 1");

    // if($insert){
    //     echo "inserted successfully";
    // }

}





?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Record Form</title>
</head>
<body>
<form method="post">
    <input type="submit" name='submit' value="Submit">
</form>
</body>
</html>