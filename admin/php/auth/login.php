<?php
session_start();

require_once '../connect.php';

$login = $_POST['login'];
$password = $_POST['password'];

$check_admin = mysqli_query($connect, "SELECT * FROM `admin` WHERE `login` = '$login' AND `password` = '$password'");

if (mysqli_num_rows($check_admin) > 0) {
    $admin = mysqli_fetch_assoc($check_admin);

    $_SESSION['admin'] = [
        "id" => $admin['id'],
        "name" => $admin['name'],
    ];

    header('Location: http://bible.bfuunit.ru/admin/liter/list.php?page=1');

} else {
    $_SESSION['message'] = 'Не верный логин или пароль';
    header('Location: http://bible.bfuunit.ru/admin/index.php');
}