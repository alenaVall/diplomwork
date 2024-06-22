<?php

session_start();

if (!$_SESSION['user']) {
  header('Location:/user/index.php');
}

require_once '../php/connect.php';
include "../menu.php";
$id = $_GET['id'];
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
    <caption>Список литературы
      <form action="http://bible.bfuunit.ru/index.php?search=<?= $search ?>">
        <input type="text" placeholder="Поиск" name="search">
        <button>
          Поиск
        </button>
      </form>
    </caption>
    <thead>

      <tr>
        <th scope="col">№</th>
        <th scope="col">Название</th>
        <th scope="col">Автор</th>
        <th scope="col">Ресурс</th>
        <th scope="col">Дисциплина</th>
        <th scope="col">Библиотека</th>
        <th scope="col">Файл</th>
        <th scope="col">Бронь</th>

      </tr>
    </thead>
    <tbody>
      <?php
      if ($search != NULL) {
        $literatures = mysqli_query($connect, "SELECT * FROM `literature`  WHERE `title` LIKE '%$search%' 
        OR `autor` LIKE '%$search%'") or die(mysqli_error($connect));
      } else {
        $literatures = mysqli_query($connect, "SELECT * FROM `literature` ") or die(mysqli_error($connect));
      }
      $literatures = mysqli_fetch_all($literatures);

      foreach ($literatures as $literature) {

        $bible = mysqli_query($connect, "SELECT * FROM `bible` WHERE `id`='$literature[7]'") or die(mysqli_error($connect));
        $bible = mysqli_fetch_assoc($bible);

        $discipline = mysqli_query($connect, "SELECT * FROM `discipline` WHERE `id`='$literature[6]'") or die(mysqli_error($connect));
        $discipline = mysqli_fetch_assoc($discipline);
      ?>

        <tr>
          <td>
            <?= $literature[0] ?>
          </td>
          <td>
            <?= $literature[1] ?>
          </td>
          <td>
            <?= $literature[2] ?>
          </td>
          <td>
            <?= $literature[3] ?>
          </td>
          <td>
            <?= $discipline['title'] ?>
          </td>
          <td>
            <?= $bible['title'] ?>
          </td>
          <td>
            <a href="<?= $literature[5] ?>">Скачать</a>
          </td>
          <td>
            <a href="https://bible.bfuunit.ru/user/reservation/reserve.php?id=<?= $literature[0] ?>">Забронировать</a>
          </td>

        </tr>

      <?php
      }
      ?>

    </tbody>

  </table>

</body>

</html>