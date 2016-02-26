<?php
$user = "white"; ///database user
$password = "xxxxx";  ////database password
$database = "white";  //// database
$host = "localhost";  //// database sql host
$con = mysql_connect($host,$user,$password) or die(mysql_error());
mysql_select_db($database);
?>