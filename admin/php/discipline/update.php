<?php
session_start();
require_once '../connect.php';

$id=$_GET['id'];
$title = trim($_POST['title']);

mysqli_query($connect, "UPDATE `discipline` SET  `title`='$title' WHERE `discipline`.`id`=$id");

header("Location: http://bible.bfuunit.ru/admin/discipline/list.php");
