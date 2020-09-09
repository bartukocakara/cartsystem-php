<?php

session_id("session1");
session_start();
$_SESSION["name"] = "1";
echo "<pre>", print_r($_SESSION, 1), "</pre>";
session_write_close();

session_id("session2");
$_SESSION["name"] = "5";
echo "<pre>", print_r($_SESSION, 2), "</pre>";
session_write_close();

session_id("session1");
echo "<pre>", print_r($_SESSION['poyraz'], 1), "</pre>";
session_write_close();

session_id("session2");
echo "<pre>", print_r($_SESSION['bartu'], 1), "</pre>";


?>