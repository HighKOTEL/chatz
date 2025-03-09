<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=messenger', 'username', 'password');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nickname = $_POST['nickname'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_id = uniqid();

    $stmt = $pdo->prepare("INSERT INTO users (nickname, password, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$nickname, $password, $user_id]);

    $_SESSION['user_id'] = $user_id;
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Регистрация</title>
</head>
<body>
    <h1>Регистрация</h1>
    <form method="POST">
        <input type="text" name="nickname" placeholder="Ник" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>
