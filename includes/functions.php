<?php
function echoPage($title, $content, $nav){
	echo "<!DOCTYPE HTML>
<html>
<head>
<link href='bootstrap/css/bootstrap.css' type='text/css' rel='stylesheet'>
<script src='js/jquery.min.js'></script>
</head>
<body>";

	echo '
	<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="#">CTF 2</a>
          <div class="nav-collapse collapse">
            <ul class="nav">';

	$navTextArray = array("Login", "Register", "Reset Password");
	$navLinkArray = array("index.php", "register.php", "reset.php");
	for($i = 0; $i < count($navTextArray); $i++){
		if($nav == $i){

			echo  "<li class='active'><a href='$navLinkArray[$i]'>$navTextArray[$i]</a></li>";
		} else {

			echo "<li><a href='$navLinkArray[$i]'>$navTextArray[$i]</a></li>";
		}
	}
	echo '</ul>';
    echo '</div>
        </div>
      </div>
    </div>';

	echo "<div class='container'>$content</div>";

	echo "</body></html>";
}

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
