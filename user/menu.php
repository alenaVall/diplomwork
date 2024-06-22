<?php
session_start();

require_once "php/connect.php";

$id = $_SESSION["user"]["id"];
$id_role = $_SESSION["user"]["id_role"];
$first_name = $_SESSION["user"]["first_name"];
$middle_name = $_SESSION["user"]["middle_name"];

$roles = mysqli_query($connect, "SELECT * FROM `role` WHERE `id`='$id_role'") or die(mysqli_error($connect));
$roles = mysqli_fetch_assoc($roles);
?>

<nav class="menu">
    <ul>

        <?php
        if ($_SESSION['user']) {
            ?>
            <li><a href="https://bible.bfuunit.ru/user/liter/list.php?page=<?= 1 ?>">Литература</a></li>
            <li><a href="http://bible.bfuunit.ru/user/bible/list.php">Библиотека</a></li>


            <li><a href="http://bible.bfuunit.ru/user/discipline/list.php">Дисциплины</a></li>


            <li style="float: right;"><a href="http://bible.bfuunit.ru/user/php/account/logout.php">Выход</a></li>
            <li style="float: right;"><a><?= $roles['title'] ?>     <?= $first_name ?>     <?= $middle_name ?></a></li>
            <? if ($id_role == 2) {
                ?>
                <li style="float: right;"><a href="http://bible.bfuunit.ru/user/liter/create.php">Добавить литературу</a></li>
            <? } ?>

        <?
        } else {
            ?>

            <li><a href="http://bible.bfuunit.ru/admin/index.php">Администратор</a></li>
            <li><a href="http://bible.bfuunit.ru/index.php">Назад</a></li>
        <?
        } ?>

    </ul>
</nav>