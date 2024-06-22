<?php
require_once '../connect.php';

$id=$_GET['id'];
$title = trim($_POST['title']);
$city = trim($_POST['city']);
$street_address = trim($_POST['street_address']);

mysqli_query($connect, "UPDATE `bible` SET `title`='$title',`city`='$city', `street_address`='$street_address' WHERE `bible`.`id`=$id");

header("Location: http://bible.bfuunit.ru/admin/bible/list.php");
