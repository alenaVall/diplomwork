<?php
session_start();

require_once '../connect.php';

date_default_timezone_set("Asia/Yekaterinburg");

$id = $_GET['id'];
$title = trim($_POST['title']);
$author = trim($_POST['author']);
$year_of_pub = trim($_POST['year_of_pub']);
$amount = trim($_POST['amount']);
$link = trim($_POST['link']);
$file = $_POST['file'];

$literature = mysqli_query($connect, "SELECT * FROM `literature` WHERE `literature`.`id`='$id'") or die(mysqli_error($connect));
$literature = mysqli_fetch_assoc($literature);

$id_discipline = $_POST['id_discipline'];
$id_bible = $_POST['id_bible'];
$id_type = $_POST['id_type'];
$id_resource = $_POST['id_resource'];
$id_status = $_POST['id_status'];

if ($_FILES['file']['name'] == null) {
    $file = null;
} else {
    $file = '../../../uploads/' . $_FILES['file']['name'];
}

move_uploaded_file($_FILES['file']['tmp_name'], $file);

if ($file == "" or $file == null) {
    mysqli_query($connect, "UPDATE `literature` 
SET `title`='$title',
    `author`='$author',
    `year_of_pub`='$year_of_pub',
    `amount`='$amount',
    `link`='$link',
    `id_discipline`='$id_discipline',
    `id_bible`='$id_bible',
    `id_type`='$id_type',
    `id_resource`='$id_resource',
    `id_status`='$id_status'
WHERE `literature`.`id` = $id");
} else {
    mysqli_query($connect, "UPDATE `literature` 
SET `title`='$title',
    `author`='$author',
    `year_of_pub`='$year_of_pub',
    `amount`='$amount',
    `file`='$file',
    `link`='$link',
    `id_discipline`='$id_discipline',
    `id_bible`='$id_bible',
    `id_type`='$id_type',
    `id_resource`='$id_resource',
    `id_status`='$id_status'
WHERE `literature`.`id` = $id");
}

if ($id_status != $literature['id_status']) {
    $today = date("Y-m-d H:i:s");

    mysqli_query($connect, "INSERT INTO `history_liter` (`id`, `id_liter`,`id_status`,`date`,`user`) 
    VALUES (NULL,'$id','$id_status','$today',NULL)");
}



header("Location: http://bible.bfuunit.ru/admin/liter/list.php?page=1");

# mysqli_query($connect, "UPDATE `programs` 
# SET `title_association` = '$title_association', 
# `program_title` = '$program_title', 
# `direction` = '$direction'
# WHERE `programs`.`id` = $id");
