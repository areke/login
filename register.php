<?php
    require('includes/config.php');
    require('includes/functions.php');
    $content = "
    <form id = 'login' method = 'POST'>
    <table id = 'loginTable' style = 'margin-left: auto; margin-right:auto; margin-top: 100px;'>
    <tr>
    <td>Username</td>
    <td><input type = 'text' name = 'username'/></td>
    </tr>
    <tr>
    <td>Password&nbsp&nbsp&nbsp</td>
    <td><input type = 'password' name = 'password'/></td>
    </tr>
    <tr>
    <tr>
    <td>
    <td style = 'text-align: center;'><input type = 'submit' value = 'Register' style = 'width: 200px; padding-top: 20px; padding-bottom: 20px; '/></td>
    </tr>
    </table>
    </form>";
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = mysql_real_escape_string($_POST["username"]);
        $password = $_POST["password"];
        
        $con = mysql_connect($host, $dbusername, $dbpassword);
        if (!$con) {
            die(mysql_error());
        }
        $db_selected = mysql_select_db($db_name, $con) or die(mysql_error());
        $query = "SELECT * FROM tbl_users WHERE username = '$username'";
        $result = mysql_query($query, $con) or die(mysql_error());
        $num_rows = mysql_num_rows($result);
        $success = false;
        if ($num_rows == 0) {
            
            $salt = generateRandomString();
            $passwordnsalt = md5($password . $salt);
            $resetHash = generateRandomString(20);
            $query = "INSERT INTO tbl_users (username, password, salt, resetHash) VALUES ('$username', '$passwordnsalt', '$salt', '$resetHash')";
            mysql_query($query, $con) or die(mysql_error());
            $success = true;
            
        } else {
            $content .= "<div class='alert alert-error' style = 'margin-top:15px; text-align:center;'>Username already exists. Please try again.</div>";
        }
        
        if ($success) {
            $_SESSION["username"] = $username;
            $content = "<div class='alert alert-success' style = 'margin-top:100px; text-align:center;'>Successfully Registered Account ".$_SESSION['username']."</div>";
            
        }
        echoPage("Login", $content, 1);
    }
    else {
        echoPage("Login", $content, 1);
    }
    
    ?>
