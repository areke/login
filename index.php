<?php
    require('includes/config.php');
    require('includes/login.php');
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
    <td>
    <td style = 'text-align: center;'><input type = 'submit' value = 'Login' style = 'width: 200px; padding-top: 20px; padding-bottom: 20px; '/></td>
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
        if ($num_rows == 1) {
            $row = mysql_fetch_row($result);
            if (md5($password . $row[4]) == $row[2]) {
                $success = true;
            }
        }
        
        if ($success) {
            $_SESSION["username"] = $username;
            header("Location: success.php");
        }
        else {
            header("Location: failure.php");
            $content .= "<div class='alert alert-error' style = 'margin-top:15px; text-align:center;'>You entered the wrong username and password combination. Please try again.</div>";
        }
        echoPage("Login", $content, 0);
    }
    else {
        echoPage("Login", $content, 0);
    }
    
    ?>
