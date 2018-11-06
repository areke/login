<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'mail/Exception.php';
    require 'mail/PHPMailer.php';
    require 'mail/SMTP.php';
    require('includes/config.php');
    require('includes/functions.php');
    require('includes/login.php');
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
    $con = mysql_connect($host, $dbusername, $dbpassword);
    if (!$con) {
        die(mysql_error());
    }
    $db_selected = mysql_select_db($db_name, $con) or die(mysql_error());
    if (isset($_POST["key"]) && isset($_POST["password"]) && isset($_POST["username"])) {
        $key = mysql_real_escape_string($_POST["key"]);
        $password = mysql_real_escape_string($_POST["password"]);
        $username = mysql_real_escape_string($_POST["username"]);
        $resetHash = generateRandomString();
        $query = "SELECT * FROM tbl_users WHERE resetHash = '$key' AND username = '$username'";
        $result = mysql_query($query, $con) or die(mysql_error());
        $num_rows = mysql_num_rows($result);
        if ($num_rows == 1) {
            $row = mysql_fetch_row($result);
            $hashed_password = md5($password . $row[4]);
            $query = "UPDATE tbl_users SET password = '$hashed_password', resetHash = '$resetHash' WHERE username = '$username' AND resetHash = '$key'";
            $result = mysql_query($query, $con) or die(mysql_error());
            $content .= "<div class='alert alert-success' style = 'margin-top:100px; text-align:center;'>Successfully reset password</div>";
        }
    }
    elseif (isset($_GET["key"]) && isset($_GET["username"])) {
        $key = mysql_real_escape_string($_GET["key"]);
        $username = mysql_real_escape_string($_GET["username"]);
        
        $query = "SELECT * FROM tbl_users WHERE resetHash = '$key' AND username = '$username'";
        $result = mysql_query($query, $con) or die(mysql_error());
        $num_rows = mysql_num_rows($result);
        if ($num_rows == 1) {
            $key = mysql_real_escape_string($_GET["key"]);
            $username = mysql_real_escape_string($_GET["username"]);
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
            <input type='hidden' name='username' value='" . $username . "'/>
            </form>";
        }
    }
    elseif (isset($_POST["username"])) {
        $username = mysql_real_escape_string($_POST["username"]);
        
        $query = "SELECT * FROM tbl_users WHERE username = '$username'";
        $result = mysql_query($query, $con) or die(mysql_error());
        $num_rows = mysql_num_rows($result);
        if ($num_rows == 1) {
            $row = mysql_fetch_row($result);
            $resetHash = $row[3];
            $mail = new PHPMailer();
            try {
                $mail->IsSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPDebug = 0;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->Username = $email_username;
                $mail->Password = $email_password;
                $mail->setFrom($email_username);
                $mail->addAddress($username);
                $mail->isHTML(true);
                $mail->Subject = 'Team 3 CTF Password Reset';
                $mail->Body = 'You can reset your password <a href = "http://localhost:8888/login/reset.php?username=' . $username . '&key=' . $resetHash . '">here.</a>';
                if (!$mail->send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }

            $content .= "<div class='alert alert-success' style = 'margin-top:100px; text-align:center;'>Successfully requested password reset</div>";
        } else {
            $content .= "<div class='alert alert-error' style = 'margin-top:100px; text-align:center;'>Username not found :(</div>";
        }
    }
    echoPage("Reset", $content, 2);
    ?>
