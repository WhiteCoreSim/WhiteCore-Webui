<?php
session_start();
$error = $_GET['error'];
setcookie("ERROR", $error, time()+5);

header("location:index.php?page=register");
?>