<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Мессенджер</title>
</head>
<body>
    <h1>Добро пожаловать в мессенджер!</h1>
    <a href="messages.php">Перейти к сообщениям</a>
    <a href="logout.php">Выйти</a>
</body>
</html>
