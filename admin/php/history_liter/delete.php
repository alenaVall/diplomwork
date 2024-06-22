<?php

require_once '../connect.php';

$id=$_GET['id'];

mysqli_query($connect, "DELETE FROM `history_liter` WHERE `history_liter`.`id` = '$id'");

header("Location: http://bible.bfuunit.ru/admin/history_liter/list.php");