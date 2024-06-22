<?php
session_start();

if (!$_SESSION['user']) {
    header('Location: http://bible.bfuunit.ru/user/index.php');
}
require_once '../php/connect.php';
include "../menu.php";



$discipline = mysqli_query($connect, "SELECT * FROM `discipline` ") or die(mysqli_error($connect));

$bible = mysqli_query($connect, "SELECT * FROM `bible` ") or die(mysqli_error($connect));

$author = mysqli_query($connect, "SELECT * FROM `author` ") or die(mysqli_error($connect));

$resource = mysqli_query($connect, "SELECT * FROM `resource` ") or die(mysqli_error($connect));

$type = mysqli_query($connect, "SELECT * FROM `type_of_liter` ") or die(mysqli_error($connect));

$status = mysqli_query($connect, "SELECT * FROM `status` ") or die(mysqli_error($connect));
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
        <form action="../php/liter/create.php" method="post" enctype="multipart/form-data">

            <table>
                <caption>
                    Добавление новой литературы
                </caption>

                <tr>
                    <th colspan="2">
                        <p>Название*</p>
                        <input type="text" name="title" placeholder="Экономика">
                    </th>
                    <th> 
                        <p>Автор*</p>
                        <input type="text" name="author" placeholder="ФИО автора">
                        
                    </th>
                </tr>
                <tr>
                    <th>
                        <p>Год издания*</p>
                        <input type="text" name="year_of_pub" placeholder="2000">
                    </th>
                    <th>
                        <p>Дисциплина*</p>
                        <input type="text" name="title_discipline" placeholder="Добавьте дисциплину, если нет в списке">
                        <select name="id_discipline">
                            <option selected disabled>Выберите дисциплину</option>
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
                        <input type="number" name="amount" value="1">
                    </th>
                </tr>
                <tr>

                    <th>
                        <p>Ресурс*</p>
                        <select required name="id_resource">
                            <option selected disabled>Выберите ресурс</option>
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
                            <option selected disabled>Выберите статус</option>
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
                            <option selected disabled>Выберите библиотеку</option>
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
                        <input type="file" name="file">
                    </th>
                    <th>
                        <p>Ссылка</p>
                        <input type="link" name="link" placeholder="http://example.com">
                    </th>
                    <th>
                        <p>Тип*</p>
                        <select required name="id_type">
                            <option selected>Выберите тип</option>
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

            <button type="submit">Добавить литературу</button>
        </form>
    </div>
</body>

</html>