<?php
session_start();
include "menu.php";
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <title>Администратор</title>

  <link rel="stylesheet" href="../style/style.css">
</head>

<body>

  <div class="login-page">
    <div class="form">
      <form action="php/auth/login.php" method="post" class="login-form">
        <input type="text" name="login" placeholder="Логин" />
        <input type="password" name="password" placeholder="Пароль" />
        <button type="submit">Авторизация</button>
      </form>
    </div>
  </div>

</body>

</html>