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
    <title>Добавление дисциплины</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    
        <div class="form_add">
            <form action="../php/discipline/create.php" method="post">
                <p>Название дисциплины</p>
                <input required type="text" name="title">

                
                <button type="submit">Добавить дисциплину</button>
            </form>
        </div>
    
</body>

</html>