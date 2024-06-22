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
    <title>Добавление автора</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>

    <div class="form_add">
        <form action="../php/authors/create.php" method="post">
            <p>Фамилия Имя Отчество</p>
            <input required type="text" name="name">
            <br><br>
            <button type="submit">Добавить автора</button>
        </form>

    </div>
</body>

</html>