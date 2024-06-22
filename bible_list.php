<?php

require_once 'connect.php';
include "menu.php";

$search = $_GET['search'];
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <title>Библиотеки</title>
  <link rel="stylesheet" href="style/style.css">
</head>

<body>
  <table>
    <caption>Библиотеки
      <form action="http://bible.bfuunit.ru/bible_list.php?search=<?= $search ?>">
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
        <th scope="col">Адрес</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($search != NULL) {
        $bibles = mysqli_query($connect, "SELECT * FROM `bible`  WHERE `title` LIKE '%$search%' OR `city` LIKE '%$search%' OR `street_address` LIKE '%$search%'") or die(mysqli_error($connect));
      } else {
        $bibles = mysqli_query($connect, "SELECT * FROM `bible` ") or die(mysqli_error($connect));
      }
      $bibles = mysqli_fetch_all($bibles);

      foreach ($bibles as $bible) {
        if($bible[0]==0) continue;
      ?>
        <tr>
          <td>
            <?= $bible[0] ?>
          </td>
          <td>
            <?= $bible[1] ?>
          </td>
          <td>
            Открыть на карте: <a href="https://maps.yandex.ru/?text=Россия, <?= $bible[2] ?>, <?= $bible[3] ?>"> <?= $bible[2] ?>, <?= $bible[3] ?></a>

          </td>

        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
</body>
</html>