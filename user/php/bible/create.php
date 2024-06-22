<?php
require_once '../connect.php';


$title = trim($_POST['title']);
$city = trim($_POST['city']);
$street_address = trim($_POST['street_address']);

$accident = 0;

$bible = mysqli_query($connect, "SELECT * FROM `bible` ") or die(mysqli_error($connect));
foreach ($bible as $bibles) {
    if (mb_strtolower($title) == trim(mb_strtolower($bibles['title']))) {
        $accident = 1;
        break;
    }
}
if ($accident == 1) {
    header("Location: http://bible.bfuunit.ru/user/bible/list.php");
} else {
    $title = trim(mb_ucfirst($_POST['title']));
    mysqli_query($connect, "INSERT INTO `bible` (`id`, `title`,`city`, `street_address`) VALUES (NULL, '$title','$city','$street_address')");
}




header("Location: http://bible.bfuunit.ru/user/bible/list.php");
