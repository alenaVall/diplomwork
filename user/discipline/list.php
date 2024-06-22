<?php
session_start();

if (!$_SESSION['user']) {
    header('Location:/user/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

$id_role = $_SESSION["user"]["id_role"];
$search = $_GET['search'];
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Дисциплины</title>

    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <table>
        <caption>Дисциплины
            <form action="https://bible.bfuunit.ru/user/discipline/list.php?search=<?= $search ?>">
                <input type="text" placeholder="Поиск по дисциплине" name="search">
                <button>
                    Поиск
                </button>
            </form>
        </caption>
        <thead>

            <tr>

                <th scope="col">№</th>
                <th scope="col">Название</th>
                <? if ($id_role == 2) {
                    ?>
                    <th><button><a href="create.php">Добавить</a></button></th>
                <? } ?>

            </tr>
        </thead>
        <tbody>
            <?php
            if ($search != NULL) {
                $disciplines = mysqli_query($connect, "SELECT * FROM `discipline`  WHERE `title` LIKE '%$search%' ") or die(mysqli_error($connect));
            } else {
                $disciplines = mysqli_query($connect, "SELECT * FROM `discipline` ") or die(mysqli_error($connect));
            }
            $disciplines = mysqli_fetch_all($disciplines);

            foreach ($disciplines as $discipline) {
                if ($discipline[0] == 0)
                    continue;
                ?>

                <tr>
                    <td>
                        <?= $discipline[0] ?>
                    </td>
                    <td>
                        <?= $discipline[1] ?>
                    </td>
                    <? if ($id_role == 2) {
                        ?>
                        <td>
                            <a href="../php/discipline/delete.php?id=<?= $discipline[0] ?>" onclick="if (confirm('Вы уверены?')){return true;}else{event.stopPropagation(); event.preventDefault();};">Удалить</a>
                            <br>
                            <a href="update.php?id=<?= $discipline[0] ?>">Изменить</a>
                        </td>
                    <? } ?>

                </tr>
                <?php
            }
            ?>

        </tbody>

    </table>

</body>

</html>