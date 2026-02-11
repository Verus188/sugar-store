<?php
// db.php
// Тут мы подключаемся к базе данных.
// Использую try-catch, чтобы если что-то сломается, сайт не упал совсем, а показал ошибку.

try {
    // Подключаем SQLite. Это удобно, потому что вся база - это один файл, не надо ставить MySQL сервер.
    // Файл будет называться database.sqlite
    $pdo = new PDO('sqlite:database.sqlite');
    
    // Включаем режим ошибок, чтобы видеть исключения, если накосячим в SQL запросах
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Создаем таблицу для юзеров, если её еще нет.
    // ID сам увеличивается (AUTOINCREMENT), email должен быть уникальным.
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Таблица для заказов. Пока простая, просто храним список товаров в тексте (JSON).
    // Потом можно будет сделать нормальную связь таблиц, но пока так сойдет.
    $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        total_price REAL,
        items TEXT, 
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

} catch (PDOException $e) {
    // Если подключиться не вышло, пишем почему
    die("Блин, ошибка с базой данных: " . $e->getMessage());
}
?>