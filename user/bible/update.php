<?php
session_start();

if (!$_SESSION['user']) {
    header('Location: http://bible.bfuunit.ru/user/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

$id=$_GET['id'];

$bibleupd = mysqli_query($connect, "SELECT * FROM `bible` WHERE `bible`.`id`='$id' ") or die(mysqli_error($connect));
$bibleupd = mysqli_fetch_assoc($bibleupd);
?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Добавление библиотеки</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    
        <div class="form_add">
            <form action="../php/bible/update.php?id=<?= $id ?>" method="post">

                <p>Название библиотеки</p>
                <input required type="text" name="title" value="<?= $bibleupd['title'] ?>">
                <p>Город</p>
                <input required type="text" name="city" value="<?= $bibleupd['city'] ?>">
                <p>Адрес</p>
                <input required type="text" name="street_address" value="<?= $bibleupd['street_address'] ?>">

                <br><br>
                <button type="submit">Изменить библиотеку</button>
            </form>
        </div>
    
</body>

</html>