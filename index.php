<?php
header("Location: https://bible.bfuunit.ru/liter_list.php?page=1");
require_once 'connect.php';
include "menu.php";
$search = $_GET['search'];

$page = $_GET['page'] - 1;

$items = $page * 10;
$all_pages = mysqli_query($connect, "SELECT * FROM `literature`");
$all_pages = (int)(mysqli_num_rows($all_pages)/10)+1;
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
      <form action="https://bible.bfuunit.ru/index.php?search=<?= $search ?>">
        <input type="text" placeholder="Поиск по названию" name="search">
        <button>
          Поиск
        </button>
      </form>
      <? if ($_GET['page'] > 1) {?>
          <a href="http://bible.bfuunit.ru/admin/liter/list.php?page=<?= $_GET['page'] - 1 ?>"><button>&#9668</button></a>
        <? } ?>
        <a style="font-weight: bold;"> <?= $page + 1 ?> </a>
        <? if ($_GET['page'] < $all_pages) {?>
        <a href="http://bible.bfuunit.ru/admin/liter/list.php?page=<?= $_GET['page'] + 1 ?>"><button>&#9658</button></a>
        <? } ?>
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
      if ($search != NULL) {
        $literatures = mysqli_query($connect, "SELECT * FROM `literature`  WHERE `id` LIKE '%$search%' OR `title` LIKE '%$search%'") or die(mysqli_error($connect));
      } else {
        $literatures = mysqli_query($connect, "SELECT * FROM `literature` WHERE `id_status`=3 LIMIT $items, 10 ") or die(mysqli_error($connect));
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
            [<?= $author['name'] ?>]
            <?= $literature[1] ?>
            (<?= $literature[2] ?>)

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
            <a href="https://maps.yandex.ru/?text=Россия, <?= $bible['city'] ?>, <?= $bible['street_address'] ?>"> <?= $bible['title'] ?></a>
          </td>
          <td>
          <?
            if ($literature[4] != null) {
            ?>
              
              <a href="<?= $literature[4] ?>">Файл</a>
            <? } ?>
            <?
             if ($literature[5] != null) {
              ?>
                <br>
                <a href="<?= $literature[5] ?>">Открыть</a>
              <? } ?>
          </td>
          <td>
            <?= $status['title'] ?>
          </td>

        </tr>

      <?php
      }
      ?>
    </tbody>
  </table>
</body>

</html>