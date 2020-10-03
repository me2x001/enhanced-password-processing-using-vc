<?php
session_start();
if(isset($_SESSION['access']) && isset($_SESSION['logvalue'])){
$_SESSION["value"] = 1;
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Main</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <link href="https://fonts.googleapis.com/css?family=Oxygen:700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="images/favicon.png" type="image">
</head>
<body>

  <div class="login-box1">
    <div class="lb-header">
            <a  class = "active" >Password Processing Scheme based on visual cryptography and OCR</a> 
    </div>
    <div class="u-form-group2">    
          <a>&nbsp;&nbsp;&nbsp;&nbsp;Hello, <?php echo $_SESSION["uname"]; ?></a><button id="login-otp" onClick="window.location='logout.php';">Log out</button><br><br><br>
    <div>
    <p>A brief review on Enhanced password processing scheme based on visual cryptography and OCR</p>
    <center><img src="images/Visual_crypto_animation_demo.gif"></center>
        <p>This system has a unique scheme of password processing by sharing IDs using images based visual cryptography and OCR. In traditional cryptographic methods users are authenticated in general systems using ID and passwords in text form, however these methods such as MD5, SHA256 are fast but they are vulnerable to attacks.</p>
        <p>Five negative password managing behaviors that vulnerability of attacks are:
					<ul>
						<li>Choosing a weak password.</li>
						<li>Using other person's passwords.</li>
						<li>Not changing passwords regularly.</li>
						<li>Saving passwords for future use at some place in plain text form.</li>
						<li>Sharing password over weak channels and to unreliable person(s).</li>
					</ul>
				</p>
				<p>To overcome these problems, Visual cryptography and OCR based password processing schemes are suggested.</p>
        <h4>Proposed Schemes : VC and OCR</h4>
        <img align="right" src="images/desc.gif" width="300" height="450" style="margin-right:50px; margin-left: 15px;">
				<p>In proposed scheme user is authenticated based on images which are divided in two shared images, one at user and other is at server for future authentication.</p>
        <h4>Method</h4>
        <p>For new user registration, first, user inputs ID and password, creates an image based on ID entered as black string and white background, then system constructs two shared images based on original image of ID and first shared image is sent to server and second shared image is saved at user for the authentication.</p>
        <p>After registration user logs in by inputting ID and password, and sending second shared image to server, then original image is constructed with shared image at sever-side.</p>
        <p>Original text is extracted from constructed image and if it matches with users ID then user is authenticated. In the end authors explain that their model has Lower computational cost, privacy of users and cyber-attack prevention as compared to traditional methods.</p>
        <h4>Final Words</h4>
        <p>Discussed scheme is more secure and lightweight as compared to traditional text based password schemes because those are often vulnerable to cyber-attacks due to vulnerabilities.
        
  </div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

</body>

</html>
<?php
}else{
    header('location:login');
}
?>