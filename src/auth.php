<?php
// auth.php
session_start();
require 'db.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

if ($action === 'register') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        echo json_encode(['success' => true, 'message' => 'Регистрация успешна!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Ошибка: такой email уже используется.']);
    }

} elseif ($action === 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        echo json_encode(['success' => true, 'message' => 'Вход выполнен!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Неверный email или пароль.']);
    }

} elseif ($action === 'logout') {
    session_destroy();
    header('Location: index.php');
}
?>
