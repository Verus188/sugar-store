<?php
// auth.php
// Обязательно стартуем сессию в самом начале, чтобы сервер "помнил" пользователя
session_start();

// Подтягиваем файлик с настройками базы
require 'db.php';

// Говорим браузеру, что будем отвечать в формате JSON (это для JavaScript)
header('Content-Type: application/json');

// Смотрим, что за действие от нас хотят (регистрация, вход или выход)
$action = $_POST['action'] ?? '';

// --- РЕГИСТРАЦИЯ ---
if ($action === 'register') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    // Хешируем пароль! Никогда не храните пароли в открытом виде, это дыра в безопасности.
    // PASSWORD_DEFAULT сам выберет лучший алгоритм (сейчас это вроде bcrypt)
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        // Подготавливаем запрос (защита от SQL-инъекций, препод говорил это важно)
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        
        // Если все ок, отправляем успех
        echo json_encode(['success' => true, 'message' => 'Ура, вы зарегистрировались!']);
    } catch (PDOException $e) {
        // Скорее всего, такой email уже есть в базе
        echo json_encode(['success' => false, 'message' => 'Эй, такой email уже занят!']);
    }

// --- ВХОД ---
} elseif ($action === 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Ищем юзера по email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Если юзер есть И пароль подходит (сверяем хеш)
    if ($user && password_verify($password, $user['password'])) {
        // Запоминаем ID и имя в сессии
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        echo json_encode(['success' => true, 'message' => 'Вход выполнен! Добро пожаловать.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Что-то не так с логином или паролем.']);
    }

// --- ВЫХОД ---
} elseif ($action === 'logout') {
    // Просто убиваем сессию
    session_destroy();
    // И кидаем на главную
    header('Location: index.php');
}
?>