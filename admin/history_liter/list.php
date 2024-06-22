<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location:/admin/index.php');
}
require_once '../php/connect.php';
include "../menu.php";
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Литература</title>

    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <table>
        <caption>Список истории изменении статусов литературы</caption>
        <thead>
            <tr>
                <th>№</th>
                <th colspan="3">[Автор] Название (Год)</th>
                <th>Статус</th>
                <th>Кем добавлено</th>
                <th>Дата изменения</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $history_liters = mysqli_query($connect, "SELECT * FROM `history_liter` ORDER BY `date` DESC") or die(mysqli_error($connect));
            $history_liters = mysqli_fetch_all($history_liters);

            foreach ($history_liters as $history_liter) {
                $literature = mysqli_query($connect, "SELECT * FROM `literature` WHERE `id`='$history_liter[1]'") or die(mysqli_error($connect));
                $literature = mysqli_fetch_assoc($literature);

                $author = mysqli_query($connect, "SELECT * FROM `author` WHERE `id`='$literature[id_author]'") or die(mysqli_error($connect));
                $author = mysqli_fetch_assoc($author);

                $status = mysqli_query($connect, "SELECT * FROM `status` WHERE `id`='$history_liter[2]'") or die(mysqli_error($connect));
                $status = mysqli_fetch_assoc($status);

                $user = mysqli_query($connect, "SELECT * FROM `user` WHERE `id`='$history_liter[4]'") or die(mysqli_error($connect));
                $user = mysqli_fetch_assoc($user);
            ?>

                <tr>

                    <td>
                        <?= $history_liter[0] ?>
                    </td>

                    <td colspan="3">
                        [<?= $literature['author'] ?>]
                        <?= $literature['title'] ?>
                        (<?= $literature['year_of_pub'] ?>)

                    </td>

                    <td>
                        <?= $status['title'] ?>
                    </td>
                    <td>
                        <? if ($history_liter[4] == NULL) { ?>
                            Администратор
                        <? } else { ?>
                            <?= $history_liter[4] ?>
                        <? }
                        ?>
                    </td>
                    <td>
                        <?= $history_liter[3] ?>
                    </td>
                    <td>
                        <a href="../php/history_liter/delete.php?id=<?= $history_liter[0] ?>" onclick="if (confirm('Вы уверены?')){return true;}else{event.stopPropagation(); event.preventDefault();};">Удалить</a>
                    </td>

                </tr>

            <?php
            }
            ?>

        </tbody>

    </table>

</body>

</html>