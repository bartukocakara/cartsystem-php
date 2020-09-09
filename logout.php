<?php 

session_start();
unset($_SESSION['userLoggedIn']);

header("location:index.php");

?>