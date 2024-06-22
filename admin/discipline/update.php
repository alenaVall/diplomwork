<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://bible.bfuunit.ru/admin/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

$id=$_GET['id'];

$disciplineupd = mysqli_query($connect, "SELECT * FROM `discipline` WHERE `discipline`.`id`='$id' ") or die(mysqli_error($connect));
$disciplineupd = mysqli_fetch_assoc($disciplineupd);

?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Изменение дисциплины</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    
        <div class="form_add">
            <form action="../php/discipline/update.php?id=<?= $id ?>" method="post">
                <p>Название дисциплины</p>
                <input required type="text" name="title" value="<?= $disciplineupd['title'] ?>">
               
                
                <button type="submit">Изменить дисциплину</button>
            </form>
        </div>
    
</body>

</html>