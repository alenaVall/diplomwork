<?php
require_once '../connect.php';

$id=$_GET['id'];
$name = trim($_POST['name']);


mysqli_query($connect, "UPDATE `author` SET 
`name`='$name'
WHERE `author`.`id`=$id");

header("Location: http://bible.bfuunit.ru/admin/authors/list.php");
