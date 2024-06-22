<?php
session_start();
include "menu.php";

require_once "../php/connect.php";

$role = mysqli_query($connect, "SELECT * FROM `role` ") or die(mysqli_error($connect));
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>

    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>

    <div class="login-page">
        <div class="form">
            <form action="../php/account/register.php" method="post" class="login-form" enctype="multipart/form-data">

                <input type="text" name="first_name" placeholder="Фамилия" />
                <input type="text" name="middle_name" placeholder="Имя" />
                <input type="text" name="last_name" placeholder="Отчество" />
                <select required name="id_role">
                            <option selected disabled>Кем вы являетесь?</option>
                            <?php
                            foreach ($role as $roles) {
                            ?>
                                <option value="<?= $roles['id'] ?>">
                                    <?= $roles['title'] ?>
                                </option>
                            <?
                            }
                            ?>
                        </select>
                <input type="text" name="email" placeholder="Логин" />
                <input type="password" name="password" placeholder="Пароль" />
                <button type="submit">Регистрация</button>
            </form>
        </div>
    </div>

</body>

</html>