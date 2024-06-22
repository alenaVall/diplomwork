<?php
require_once '../connect.php';

$name=trim($_POST['name']);

$author = mysqli_query($connect, "SELECT * FROM `author` ") or die(mysqli_error($connect));
foreach ($author as $authors) {
    if (mb_strtolower($name) == trim(mb_strtolower($authors['name']))) {
        $accident = 1;
        break;
    }
}
if ($accident == 1) {
    header("Location: http://bible.bfuunit.ru/user/authors/list.php");
} else {
    $name = trim(mb_convert_case($_POST['name'], MB_CASE_TITLE, 'UTF-8'));
    mysqli_query($connect,"INSERT INTO `author` (`id`, `name`) VALUES (NULL, '$name')");
}

header("Location: http://bible.bfuunit.ru/user/authors/list.php");