<?php
session_start();

$id = $_SESSION["admin"]["id"];
$name = $_SESSION["admin"]["name"];

?>

<nav class="menu">
    <ul>

        <?php
        if ($_SESSION['admin']) {
        ?>
            <li><a href="http://bible.bfuunit.ru/admin/liter/list.php?page=<?=1?>">Литература</a></li>
            <li><a href="http://bible.bfuunit.ru/admin/bible/list.php">Библиотека</a></li>
            <li><a href="http://bible.bfuunit.ru/admin/discipline/list.php">Дисциплины</a></li>
        
            <li style="float: right;"><a href="http://bible.bfuunit.ru/admin/php/auth/logout.php">Выход</a></li>
            <li style="float: right;"><a>Администратор <?= $name ?></a></li>
        <?
        } else {
        ?>
            <li><a href="http://bible.bfuunit.ru/user/index.php">Пользователь</a></li>
            <li><a href="http://bible.bfuunit.ru/index.php">Назад</a></li>
        <?
        } ?>

    </ul>
</nav>