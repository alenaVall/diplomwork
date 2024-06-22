<?php
session_start();

require_once '../connect.php';

date_default_timezone_set("Asia/Yekaterinburg");

$first_name = $_SESSION["user"]["first_name"];
$middle_name = $_SESSION["user"]["middle_name"];
$last_name = $_SESSION["user"]["last_name"];
$user = $first_name . ' ' . $middle_name . ' ' . $last_name;

$title = trim($_POST['title']);
$author = trim($_POST['author']);
$year_of_pub = trim($_POST['year_of_pub']);
$amount = trim($_POST['amount']);
$link = trim($_POST['link']);

if ($_FILES['file']['name'] == null) {
    $file = null;
} else {
    $file = '../../../uploads/' . $_FILES['file']['name'];
}

if (trim($_POST['author_name']) != "") {

    $author = mysqli_query($connect, "SELECT * FROM `author` ") or die(mysqli_error($connect));
    foreach ($author as $authors) {
        if (trim(mb_strtolower($_POST['author_name']) == trim(mb_strtolower($authors['name'])))) {
            $id_author = $authors['id'];
            break;
        }
    }

    if ($id_author == null) {
        $author_name = trim(mb_convert_case($_POST['author_name'], MB_CASE_TITLE, 'UTF-8'));
        mysqli_query($connect, "INSERT INTO `author` (`id`, `name`) VALUES (NULL, '$author_name')");

        $author = mysqli_query($connect, "SELECT `id` FROM `author` ORDER BY `id` DESC LIMIT 1") or die(mysqli_error($connect));
        $author = mysqli_fetch_assoc($author);

        $id_author = $author['id'];
    }
} else {
    $id_author = $_POST['id_author'];
}

if ($_POST['title_discipline'] != "") {

    $discipline = mysqli_query($connect, "SELECT * FROM `discipline` ") or die(mysqli_error($connect));
    foreach ($discipline as $disciplines) {

        if (trim(mb_strtolower($_POST['title_discipline']) == trim(mb_strtolower($disciplines['title'])))) {
            $id_discipline = $disciplines['id'];
            break;
        }
    }

    if ($id_discipline == null) {
        $title_discipline = trim(mb_ucfirst($_POST['title_discipline']));
        mysqli_query($connect, "INSERT INTO `discipline` (`id`, `title`) VALUES (NULL, '$title_discipline')");

        $discipline = mysqli_query($connect, "SELECT `id` FROM `discipline` ORDER BY `id` DESC LIMIT 1") or die(mysqli_error($connect));
        $discipline = mysqli_fetch_assoc($discipline);

        $id_discipline = $discipline['id'];
    }
} else {
    $id_discipline = $_POST['id_discipline'];
}

$id_bible = $_POST['id_bible'];
$id_type = $_POST['id_type'];
$id_resource = $_POST['id_resource'];
$id_status = $_POST['id_status'];

move_uploaded_file($_FILES['file']['tmp_name'], $file);

mysqli_query($connect, "INSERT INTO `literature` (`id`, `title`,`author`,`year_of_pub`,`amount`,`file`,`link`, `id_discipline`, `id_bible`,`id_type`,`id_resource`,`id_status`) 
VALUES (NULL, '$title','$author','$year_of_pub','$amount','$file','$link','$id_discipline','$id_bible','$id_type','$id_resource','$id_status')");

$literatures = mysqli_query($connect, "SELECT `id` FROM `literature` ORDER BY `id` DESC LIMIT 1") or die(mysqli_error($connect));
$literatures = mysqli_fetch_assoc($literatures);

$today = date("Y-m-d H:i:s");
$id_liter = $literatures['id'];

mysqli_query($connect, "INSERT INTO `history_liter` (`id`, `id_liter`,`id_status`,`date`,`user`) 
    VALUES (NULL,'$id_liter','$id_status','$today','$user')");

header("Location: http://bible.bfuunit.ru/user/liter/list.php?page=1");
