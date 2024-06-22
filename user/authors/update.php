<?php
session_start();

if (!$_SESSION['user']) {
    header('Location: http://bible.bfuunit.ru/user/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

$id=$_GET['id'];

$authorupd = mysqli_query($connect, "SELECT * FROM `author` WHERE `author`.`id`='$id' ") or die(mysqli_error($connect));
$authorupd = mysqli_fetch_assoc($authorupd);
?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Добавление автора</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>

    <div class="form_add">
        <form action="../php/authors/update.php?id=<?= $id ?>" method="post">
            <p>Фамилия Имя Отчество</p>
            <input required type="text" name="name" value="<?=$authorupd['name']?>">
            
            <br><br>
            <button type="submit">Изменить автора</button>
        </form>

    </div>
</body>

</html>