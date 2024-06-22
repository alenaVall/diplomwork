<?php
require_once '../connect.php';

$title = trim($_POST['title']);
$accident=0;


$discipline = mysqli_query($connect, "SELECT * FROM `discipline` ") or die(mysqli_error($connect));
foreach ($discipline as $disciplines) {
    if (mb_strtolower($title) == trim(mb_strtolower($disciplines['title']))) {
        $accident=1;
        break;
    }

}
if($accident==1){
    header("Location: http://bible.bfuunit.ru/admin/discipline/list.php");
}else{
    $title = trim(mb_ucfirst($_POST['title']));
    mysqli_query($connect, "INSERT INTO `discipline` (`id`, `title`) VALUES (NULL, '$title')");
}

header("Location: http://bible.bfuunit.ru/admin/discipline/list.php");