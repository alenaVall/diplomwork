<?php

session_start();
session_unset();
unset($_SESSION['user']);
session_destroy();
header("location:http://bible.bfuunit.ru/user/index.php");
?>
