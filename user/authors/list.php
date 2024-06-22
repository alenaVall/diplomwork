<?php
session_start();

if (!$_SESSION['user']) {
  header('Location:/user/index.php');
}
require_once '../php/connect.php';
include "../menu.php";

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
      <form action="http://bible.bfuunit.ru/user/authors/list.php?search=<?= $search ?>">
        <input type="text" placeholder="Поиск" name="search">
        <button>
          Поиск
        </button>
      </form>
    </caption>
    <thead>

      <tr>

        <th scope="col">№</th>
        <th scope="col">Фамилия Имя Отчество</th>
        <th><button><a href="create.php">Добавить</a></button></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($search != NULL) {
        $authors = mysqli_query($connect, "SELECT * FROM `author`  WHERE `name` LIKE '%$search%'") or die(mysqli_error($connect));
      } else {
        $authors = mysqli_query($connect, "SELECT * FROM `author` ") or die(mysqli_error($connect));

      }
      $authors = mysqli_fetch_all($authors);

      foreach ($authors as $author) {
        if($author[0]==0) continue;
        ?>

        <tr>
          <td>
            <?= $author[0] ?>
          </td>
          <td>
            <?= $author[1] ?>
          </td>
          <td>
            <a href="../php/authors/delete.php?id=<?= $author[0] ?>">Удалить</a>
            <br>
            <a href="update.php?id=<?= $author[0] ?>">Изменить</a>
          </td>
          
        </tr>
        <?php
      }
      ?>

    </tbody>

  </table>

</body>

</html>