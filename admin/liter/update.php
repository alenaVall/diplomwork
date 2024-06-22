<?php
session_start();

if (!$_SESSION['admin']) {
    header('Location: http://bible.bfuunit.ru/admin/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

$id = $_GET['id'];

$literature = mysqli_query($connect, "SELECT * FROM `literature` WHERE `literature`.`id`='$id'") or die(mysqli_error($connect));
$literature = mysqli_fetch_assoc($literature);

$authorupd = mysqli_query($connect, "SELECT * FROM `author` WHERE `author`.`id`='$literature[id_author]' ") or die(mysqli_error($connect));
$authorupd = mysqli_fetch_assoc($authorupd);

$bibleupd = mysqli_query($connect, "SELECT * FROM `bible` WHERE `bible`.`id`='$literature[id_bible]' ") or die(mysqli_error($connect));
$bibleupd = mysqli_fetch_assoc($bibleupd);

$disciplineupd = mysqli_query($connect, "SELECT * FROM `discipline` WHERE `discipline`.`id`='$literature[id_discipline]' ") or die(mysqli_error($connect));
$disciplineupd = mysqli_fetch_assoc($disciplineupd);

$resourceupd = mysqli_query($connect, "SELECT * FROM `resource` WHERE `resource`.`id`='$literature[id_resource]' ") or die(mysqli_error($connect));
$resourceupd = mysqli_fetch_assoc($resourceupd);

$statusupd = mysqli_query($connect, "SELECT * FROM `status` WHERE `status`.`id`='$literature[id_status]' ") or die(mysqli_error($connect));
$statusupd = mysqli_fetch_assoc($statusupd);

$typeupd = mysqli_query($connect, "SELECT * FROM `type_of_liter` WHERE `type_of_liter`.`id`='$literature[id_type]' ") or die(mysqli_error($connect));
$typeupd = mysqli_fetch_assoc($typeupd);

$author = mysqli_query($connect, "SELECT * FROM `author` ") or die(mysqli_error($connect));
$bible = mysqli_query($connect, "SELECT * FROM `bible` ") or die(mysqli_error($connect));
$discipline = mysqli_query($connect, "SELECT * FROM `discipline` ") or die(mysqli_error($connect));
$resource = mysqli_query($connect, "SELECT * FROM `resource` ") or die(mysqli_error($connect));
$status = mysqli_query($connect, "SELECT * FROM `status` ") or die(mysqli_error($connect));
$type = mysqli_query($connect, "SELECT * FROM `type_of_liter` ") or die(mysqli_error($connect));
?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Добавление литературы</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>

    <div class="form_add">
        <form action="../php/liter/update.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
            <table>
                <caption>
                    Изменение литературы
                </caption>

                <tr>
                    <th colspan="2">
                        <p>Название*</p>
                        <input type="text" name="title" value="<?= $literature['title'] ?>">
                    </th>
                    <th>
                        <p>Автор*</p>
                        <input type="text" name="author" value="<?= $literature['author'] ?>">
                    </th>
                </tr>
                <tr>
                    <th>
                        <p>Год издания*</p>
                        <input required type="text" name="year_of_pub" value="<?= $literature['year_of_pub'] ?>">
                    </th>
                    <th>
                        <p>Дисциплина*</p>
                        <select required name="id_discipline">
                            <option selected  value="<?= $disciplineupd['id'] ?>">Выбрано: <?= $disciplineupd['title'] ?> </option>
                            <?php
                            foreach ($discipline as $disciplines) {
                            ?>
                                <option value="<?= $disciplines['id'] ?>">
                                    <?= $disciplines['title'] ?>
                                </option>
                            <?
                            }
                            ?>
                        </select>
                    </th>
                    <th>
                        <p>Количество</p>
                        <input type="number" name="amount" value="<?= $literature['amount'] ?>">
                    </th>
                </tr>
                <tr>

                    <th>
                        <p>Ресурс*</p>
                        <select required name="id_resource">
                            <option selected  value="<?= $resourceupd['id'] ?>">Выбрано: <?= $resourceupd['title'] ?> </option>
                            <?php
                            foreach ($resource as $resources) {
                            ?>
                                <option value="<?= $resources['id'] ?>">
                                    <?= $resources['title'] ?>
                                </option>
                            <?
                            }
                            ?>
                        </select>
                    </th>
                    <th>
                        <p>Статус*</p>
                        <select required name="id_status">
                            <option selected  value="<?= $statusupd['id'] ?>">Выбрано: <?= $statusupd['title'] ?> </option>
                            <?php
                            foreach ($status as $statuses) {
                            ?>
                                <option value="<?= $statuses['id'] ?>">
                                    <?= $statuses['title'] ?>
                                </option>
                            <?
                            }
                            ?>
                        </select>
                    </th>
                    <th>
                        <p>Библиотека*</p>
                        <select required name="id_bible">
                            <option selected value="<?= $bibleupd['id'] ?>">Выбрано: <?= $bibleupd['title'] ?> </option>
                            <?php
                            foreach ($bible as $bibles) {
                            ?>
                                <option value="<?= $bibles['id'] ?>">
                                    <?= $bibles['title'] ?>
                                </option>
                            <?
                            }
                            ?>
                        </select>
                    </th>
                </tr>
                <tr>
                    <th>
                        <p>Файл (при наличии)</p>
                        <input type="file" name="file" value="<?= $literature['file'] ?>">
                    </th>
                    <th>
                        <p>Ссылка*</p>
                        <input type="text" name="link" value="<?= $literature['link'] ?>">
                    </th>
                    <th>
                        <p>Тип*</p>
                        <select required name="id_type">
                            <option selected value="<?= $typeupd['id']  ?>">Выбрано: <?= $typeupd['title'] ?> </option>
                            <?php
                            foreach ($type as $types) {
                            ?>
                                <option value="<?= $types['id'] ?>">
                                    <?= $types['title'] ?>
                                </option>
                            <?
                            }
                            ?>
                        </select>
                    </th>
                </tr>
                <tr>

                </tr>

            </table>

            <button type="submit">Изменить литературу</button>
        </form>
    </div>
</body>

</html>