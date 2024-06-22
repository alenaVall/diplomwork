<?php

require_once 'connect.php';
include "menu.php";

$search = $_GET['search'];
$start_year = $_GET['start_year'];
$end_year = $_GET['end_year'];

$page = $_GET['page'];

$items = ($_GET['page'] - 1) * 10;
$all_pages = mysqli_query($connect, "SELECT * FROM `literature` WHERE `id_status`=3");
if (mysqli_num_rows($all_pages) % 10 > 0) {
    $all_pages = (int) (mysqli_num_rows($all_pages) / 10) + 1;
} else {
    $all_pages = (int) (mysqli_num_rows($all_pages) / 10);
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Литература</title>

    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <table>
        <caption>Список литературы
            <form
                action="https://bible.bfuunit.ru/liter_list.php?page=<?= $page ?>&search=<?= $search ?>&start_year=<?= $start_year ?>&end_year=<?= $end_year ?>">
                <? if ($search == "") { ?>
                    <a style="font-size: 15;">Поиск <input type="text" placeholder="Поиск по названию" name="search"></a>
                <? } else { ?>
                    <a style="font-size: 15;"> Поиск<input type="text" placeholder="Поиск по названию" name="search"
                            value="<?= $search ?>"></a>
                <? } ?>
                <? if ($start_year == "" and $end_year == "") { ?>
                    <a style="font-size: 15;">Фильтрация по годам
                        <input type="text" placeholder="Начинать с года" name="start_year">
                        <input type=" text" placeholder="Заканчивать по год" name="end_year"></a>
                <? } else { ?>
                    <a style="font-size: 15;">Фильтрация по годам
                        <input type="text" placeholder="Начинать с года" name="start_year" value="<?= $start_year ?>">
                        <input type="text" placeholder="Заканчивать по год" name="end_year" value="<?= $end_year ?>"></a>
                <? } ?>

                <input hidden type="text" value="<?= 1 ?>" name="page">
                <button>
                    Поиск
                </button>
            </form>
        </caption>
        <thead>

            <tr>
                <th scope="col">№</th>
                <th colspan="3">[Автор] Название (Год)</th>
                <th scope="col">Ресурс</th>
                <th scope="col">Тип</th>
                <th scope="col">Дисциплина</th>
                <th scope="col">Библиотека</th>
                <th scope="col">Ссылка</th>
                <th scope="col">Статус </th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($search != NULL and $start_year != NULL and $end_year != NULL) {
                $literatures = mysqli_query($connect, "SELECT * FROM `literature`  
                WHERE (`year_of_pub` >= '$start_year' AND `year_of_pub` <='$end_year')  AND (`title` LIKE '%$search%' OR `author` LIKE '%$search%') AND `id_status`=3
                LIMIT $items, 10 ") or die(mysqli_error($connect));
            }  elseif ($search != NULL and $start_year != NULL) {
                $literatures = mysqli_query($connect, "SELECT * FROM `literature`  
                WHERE `year_of_pub` >= '$start_year' AND (`title` LIKE '%$search%' OR `author` LIKE '%$search%') AND `id_status`=3
                LIMIT $items, 10 ") or die(mysqli_error($connect));
            } elseif ($search != NULL and $end_year != NULL) {
                $literatures = mysqli_query($connect, "SELECT * FROM `literature`  
                WHERE `year_of_pub` <= '$end_year' AND `title` LIKE '%$search%' OR `author` LIKE '%$search%' AND `id_status`=3
                LIMIT $items, 10 ") or die(mysqli_error($connect));
            } elseif ($end_year != NULL) {
                $literatures = mysqli_query($connect, "SELECT * FROM `literature`  
                WHERE (`year_of_pub` <= '$end_year') AND `id_status`=3
                LIMIT $items, 10 ") or die(mysqli_error($connect));
            } elseif ($start_year != NULL) {
                $literatures = mysqli_query($connect, "SELECT * FROM `literature`  
                WHERE (`year_of_pub` >= '$start_year') AND `id_status`=3
                LIMIT $items, 10 ") or die(mysqli_error($connect));
            }elseif ($search != NULL) {
                $literatures = mysqli_query($connect, "SELECT * FROM `literature`  
                WHERE  ( `title` LIKE '%$search%' OR `author` LIKE '%$search%') AND `id_status`=3
                LIMIT $items, 10 ") or die(mysqli_error($connect));
            } 
            else {
                $literatures = mysqli_query($connect, "SELECT * FROM `literature` WHERE `id_status`=3 LIMIT $items, 10  ") or die(mysqli_error($connect));
            }
            $literatures = mysqli_fetch_all($literatures);

            foreach ($literatures as $literature) {
                $author = mysqli_query($connect, "SELECT * FROM `author` WHERE `id`='$literature[6]'") or die(mysqli_error($connect));
                $author = mysqli_fetch_assoc($author);

                $bible = mysqli_query($connect, "SELECT * FROM `bible` WHERE `id`='$literature[8]'") or die(mysqli_error($connect));
                $bible = mysqli_fetch_assoc($bible);

                $discipline = mysqli_query($connect, "SELECT * FROM `discipline` WHERE `id`='$literature[7]'") or die(mysqli_error($connect));
                $discipline = mysqli_fetch_assoc($discipline);

                $resource = mysqli_query($connect, "SELECT * FROM `resource` WHERE `id`='$literature[10]'") or die(mysqli_error($connect));
                $resource = mysqli_fetch_assoc($resource);

                $status = mysqli_query($connect, "SELECT * FROM `status` WHERE `id`='$literature[11]'") or die(mysqli_error($connect));
                $status = mysqli_fetch_assoc($status);

                $type = mysqli_query($connect, "SELECT * FROM `type_of_liter` WHERE `id`='$literature[9]'") or die(mysqli_error($connect));
                $type = mysqli_fetch_assoc($type);
                ?>

                <tr>
                    <td>
                        <?= $literature[0] ?>
                    </td>

                    <td colspan="3">
                        [<?= $literature[2] ?>]
                        <?= $literature[1] ?>
                        (<?= $literature[3] ?>)

                    </td>

                    <td>
                        <?= $resource['title'] ?>
                    </td>

                    <td>
                        <?= $type['title'] ?>
                    </td>

                    <td>
                        <?= $discipline['title'] ?>
                    </td>
                    <td>
                        <a
                            href="https://maps.yandex.ru/?text=Россия, <?= $bible['city'] ?>, <?= $bible['street_address'] ?>">
                            <?= $bible['title'] ?></a>
                    </td>
                    <td>
                        <?
                        if ($literature[5] != null) {
                            ?>

                            <a href="<?= $literature[5] ?>" download>Файл</a>
                        <? } ?>
                        <?
                        if ($literature[6] != null) {
                            ?>
                            <br>
                            <a href="<?= $literature[6] ?>">Открыть</a>
                        <? } ?>
                    </td>
                    <td>
                        <?= $status['title'] ?>
                    </td>

                </tr>

                <?php
            }
            ?>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td> <a href="https://bible.bfuunit.ru/export_excel.php?page=<?= $page ?>&search=<?= $search ?>&start_year=<?= $start_year ?>&end_year=<?= $end_year ?>">Экспорт</a></td>
            <td>
                <? if ($_GET['page'] > 1) {
                    if ($search != NULL or $start_year != NULL or $end_year != NULL) { ?>
                        <a
                            href="http://bible.bfuunit.ru/liter_list.php?page=<?= $_GET['page'] - 1 ?>&search=<?= $search ?>&start_year=<?= $start_year ?>&end_year=<?= $end_year ?>"><button>&#9668</button></a>
                    <? } else { ?>
                        <a
                            href="http://bible.bfuunit.ru/liter_list.php?page=<?= $_GET['page'] - 1 ?>"><button>&#9668</button></a>
                    <? }
                } ?>
                <a style="font-weight: bold;">Стр <?= $page ?> </a>
                <? if ($_GET['page'] < $all_pages) {
                    if ($search != NULL or $start_year != NULL or $end_year != NULL) { ?>
                        <a
                            href="http://bible.bfuunit.ru/liter_list.php?page=<?= $_GET['page'] + 1 ?>&search=<?= $search ?>&start_year=<?= $start_year ?>&end_year=<?= $end_year ?>"><button>&#9658</button></a>
                    <? } else { ?>
                        <a
                            href="http://bible.bfuunit.ru/liter_list.php?page=<?= $_GET['page'] + 1 ?>"><button>&#9658</button></a>
                    <? }
                } ?>
            </td>
        </tbody>
    </table>
</body>

</html>