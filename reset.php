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
    <td>
    <td style = 'text-align: center;'><input type = 'submit' value = 'Request Password Reset' style = 'width: 200px; padding-top: 20px; padding-bottom: 20px; '/></td>
    </tr>
    </table>
    </form>";
    $show_email_form = true;
    $con = mysql_connect($host, $dbusername, $dbpassword);
    if (!$con) {
        die(mysql_error());
    }
    $db_selected = mysql_select_db($db_name, $con) or die(mysql_error());
    if (isset($_POST["key"]) && isset($_POST["password"])) {
        $key = mysql_real_escape_string($_POST["key"]);
        $password = mysql_real_escape_string($_POST["password"]);
        $query = "UPDATE tbl_users WHERE resetHash = '$key'";
    }
    if (isset($_GET["key"])) {
        $key = mysql_real_escape_string($_GET["key"]);
        
        $query = "SELECT * FROM tbl_users WHERE resetHash = '$key'";
        $result = mysql_query($query, $con) or die(mysql_error());
        $num_rows = mysql_num_rows($result);
        $success = false;
        if ($num_rows == 1) {
            $show_email_form = false;
        }
    }
    if (isset($_POST["username"])) {
        $content .= "<div class='alert alert-success' style = 'margin-top:100px; text-align:center;'>Successfully requested password reset</div>";
        echoPage("Reset", $content, 2);
    }
    elseif ($show_email_form) {
        echoPage("Reset", $content, 2);
    }
    else {
        $key = mysql_real_escape_string($_POST["key"]);
        $content = "
        <form id = 'login' method = 'POST'>
        <table id = 'loginTable' style = 'margin-left: auto; margin-right:auto; margin-top: 100px;'>
        <tr>
        <td>New Password</td>
        <td><input type = 'text' name = 'password'/></td>
        </tr>
        <tr>
        <td>
        <td style = 'text-align: center;'><input type = 'submit' value = 'Reset Password' style = 'width: 200px; padding-top: 20px; padding-bottom: 20px; '/></td>
        </tr>
        </table>
        <input type='hidden' name='key' value='" . $key . "'/>
        </form>";
        echoPage("Reset", $content, 2);
    }
    
    ?>
