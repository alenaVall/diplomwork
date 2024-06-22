<?php
session_start();

require_once '../connect.php';

$email = $_POST['login'];
$password = $_POST['password'];

$check_user = mysqli_query($connect, "SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$password'");

if (mysqli_num_rows($check_user) > 0) {
    $user = mysqli_fetch_assoc($check_user);

    $_SESSION['user'] = [
        "id" => $user['id'],
        "first_name" => $user['first_name'],
        "middle_name" => $user['middle_name'],
        "last_name" => $user['last_name'],
        "id_role"=>$user['id_role']
    ];

    header('Location: https://bible.bfuunit.ru/user/liter/list.php?page=1');

} else {
    $_SESSION['message'] = 'Не верный логин или пароль';
    header('Location: http://bible.bfuunit.ru/user/index.php');
}