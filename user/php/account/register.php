<?php

require_once '../connect.php';

$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$last_name = $_POST['last_name'];
$email=$_POST['email'];
$password = $_POST['password'];
$id_role = $_POST['id_role'];

mysqli_query($connect, "INSERT INTO `user` (`id`, `first_name`,`middle_name`,`last_name`,`email`,`password`, `id_role`) 
VALUES (NULL, '$first_name', '$middle_name','$last_name', '$email','$password','$id_role')");

header("Location: http://bible.bfuunit.ru/user/index.php");
