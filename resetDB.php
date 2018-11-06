<?php
require('includes/config.php');
$con = mysql_connect($host, $dbusername, $dbpassword);
if (!$con)
{
    die(mysql_error());
}
$db_selected = mysql_select_db($db_name, $con);
$sql = 'DROP DATABASE ' . $db_name;
mysql_query($sql, $con) or die(mysql_error());
header("Location: createDB.php");
?>
