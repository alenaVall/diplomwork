<?php
session_start();
include "menu.php";
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <title>Личный кабинет</title>

  <link rel="stylesheet" href="../style/style.css">
</head>

<body>

  <div class="login-page">
    <div class="form">
      <form action="php/account/login.php" method="post" class="login-form">
        <input type="text" name="login" placeholder="Логин" />
        <input type="password" name="password" placeholder="Пароль" />
        <button type="submit">Авторизация</button>

      </form>
      <a href="account/register.php">
        <button>Регистрация</button>
      </a>
    </div>
  </div>

</body>

</html>