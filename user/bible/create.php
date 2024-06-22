<?php
session_start();

if (!$_SESSION['user']) {
    header('Location: http://bible.bfuunit.ru/user/index.php');
}

include "../menu.php";

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
            <form action="../php/bible/create.php" method="post">
                <p>Название библиотеки</p>
                <input required type="text" name="title">
                <p>Город</p>
                <input required type="text" name="city">
                <p>Адрес</p>
                <input required type="text" name="street_address">

                <br><br>
                <button type="submit">Добавить библиотеку</button>
            </form>
        </div>
    
</body>

</html>