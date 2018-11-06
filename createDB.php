<?php
require('includes/config.php');
require('includes/functions.php');
$con = mysql_connect($host, $dbusername, $dbpassword);
echoPage("Create Database", "", 5);
if (!$con)
  {
  die(mysql_error());
  }
$db_selected = mysql_select_db($db_name, $con);
echo '<div style = "text-align:center; margin-top: 200px;">';
$sql = 'CREATE DATABASE ' . $db_name;

if (mysql_query($sql, $con)) {
    echo "Database " . $db_name . " created successfully<br>";
} else {
    echo 'Error creating database: ' . mysql_error() . "<br>";
}

$db_selected = mysql_select_db($db_name, $con);


$sql = '
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `RowKey` int NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `resetHash` text NOT NULL,
  `salt` text NOT NULL,
  
  PRIMARY KEY (`RowKey`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';


if (mysql_query($sql, $con)) {
  echo "Database table 'tbl_users' created successfully<br>";
} else {
  echo 'Error creating table: ' . mysql_error() . "<br>";
}
mysql_close($con); 
?>
