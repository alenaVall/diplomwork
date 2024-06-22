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
  <title>Библиотеки</title>

  <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
  <table>
    <caption>Библиотеки
      <form action="https://bible.bfuunit.ru/user/bible/list.php?search=<?= $search ?>">
        <input type="text" placeholder="Поиск по названию, городу и адресу" name="search">
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
        <? if ($id_role == 2) {
          ?>
          <th><button><a href="create.php">Добавить</a></button></th>
        <? } ?>

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
        if ($bible[0] == 0)
          continue;
        ?>

        <tr>
          <td>
            <?= $bible[0] ?>
          </td>
          <td>
            <?= $bible[1] ?>
          </td>
          <td>
            Открыть на карте: <a href="https://maps.yandex.ru/?text=Россия, <?= $bible[2] ?>, <?= $bible[3] ?>">
              <?= $bible[2] ?>, <?= $bible[3] ?></a>

          </td>
          <? if ($id_role == 2) {
          ?>
         <td>
            <a href="../php/bible/delete.php?id=<?= $bible[0] ?>" onclick="if (confirm('Вы уверены?')){return true;}else{event.stopPropagation(); event.preventDefault();};">Удалить</a>
            <br>
            <a href="update.php?id=<?= $bible[0] ?>">Изменить</a>
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