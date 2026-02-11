<?php
// cart_action.php
// Тут обрабатываем всё, что связано с корзиной

session_start();
header('Content-Type: application/json');

// Если корзины еще нет в сессии, создаем пустой массив, чтобы не было ошибок
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Получаем данные. Тут хитро: PHP не всегда видит JSON в $_POST, 
// поэтому читаем сырой ввод (php://input) и декодируем его
$data = json_decode(file_get_contents('php://input'), true);

// Определяем действие. Оно может прийти в JSON или в GET параметрах (для получения корзины)
$action = $data['action'] ?? $_GET['action'] ?? '';

// --- ДОБАВЛЕНИЕ В КОРЗИНУ ---
if ($action === 'add') {
    $product = [
        'name' => $data['name'],
        'price' => $data['price'],
        'image' => $data['image']
    ];
    // Добавляем товар в массив корзины
    $_SESSION['cart'][] = $product;
    // Возвращаем новую длину массива, чтобы обновить циферку в шапке
    echo json_encode(['success' => true, 'count' => count($_SESSION['cart'])]);

// --- ПОЛУЧЕНИЕ КОРЗИНЫ ---
} elseif ($action === 'get') {
    // Просто отдаем всё, что есть в сессии
    echo json_encode(['cart' => $_SESSION['cart']]);

// --- УДАЛЕНИЕ ОДНОГО ТОВАРА ---
} elseif ($action === 'remove') {
    $index = $data['index'] ?? null;
    // Проверяем, что индекс валидный и такой товар есть
    if ($index !== null && isset($_SESSION['cart'][$index])) {
        // Удаляем элемент массива и сдвигаем ключи (array_splice делает это сам)
        array_splice($_SESSION['cart'], $index, 1);
    }
    echo json_encode(['success' => true, 'count' => count($_SESSION['cart'])]);

// --- ОЧИСТКА КОРЗИНЫ (ПОКУПКА) ---
} elseif ($action === 'clear') {
    $_SESSION['cart'] = []; // Просто обнуляем массив
    echo json_encode(['success' => true]);
}
?>