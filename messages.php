<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=messenger', 'username', 'password'); // Замените 'username' и 'password' на ваши данные для подключения к базе данных

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Перенаправляет на страницу входа, если пользователь не авторизован
    exit();
}

// Обработка отправки сообщения
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipient_id = $_POST['recipient_id'];
    $message = $_POST['message'];

    // Вставка сообщения в базу данных
    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $recipient_id, $message]);
}

// Получение сообщений
$stmt = $pdo->prepare("SELECT * FROM messages WHERE recipient_id = ? OR sender_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Подключаем файл стилей -->
    <title>Сообщения</title>
</head>
<body>
    <h1>Сообщения</h1>
    
    <form method="POST">
        <input type="text" name="recipient_id" placeholder="ID получателя" required>
        <textarea name="message" placeholder="Ваше сообщение" required></textarea>
        <button type="submit">Отправить</button>
    </form>

    <h2>Ваши сообщения:</h2>
    <ul>
        <?php foreach ($messages as $msg): ?>
            <li>
                <strong><?php echo htmlspecialchars($msg['sender_id']); ?>:</strong>
                <?php echo htmlspecialchars($msg['message']); ?> <em>(<?php echo $msg['created_at']; ?>)</em>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="index.php">Назад</a> <!-- Ссылка на главную страницу -->
</body>
</html>
