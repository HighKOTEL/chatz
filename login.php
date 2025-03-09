<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=messenger', 'username', 'password'); // Замените 'username' и 'password' на ваши данные для подключения к базе данных

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];

    // Получаем пользователя по нику
    $stmt = $pdo->prepare("SELECT * FROM users WHERE nickname = ?");
    $stmt->execute([$nickname]);
    $user = $stmt->fetch();

    // Проверяем, существует ли пользователь и правильный ли пароль
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id']; // Сохраняем user_id в сессии
        header("Location: index.php"); // Перенаправляем на главную страницу
        exit();
    } else {
        $error = "Неверный ник или пароль."; // Сообщение об ошибке
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Подключаем файл стилей -->
    <title>Вход</title>
</head>
<body>
    <h1>Вход</h1>
    <form method="POST">
        <input type="text" name="nickname" placeholder="Ник" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?> <!-- Выводим сообщение об ошибке, если оно есть -->
</body>
</html>
