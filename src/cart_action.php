<?php
// cart_action.php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'] ?? $_GET['action'] ?? '';

if ($action === 'add') {
    $product = [
        'name' => $data['name'],
        'price' => $data['price'],
        'image' => $data['image']
    ];
    $_SESSION['cart'][] = $product;
    echo json_encode(['success' => true, 'count' => count($_SESSION['cart'])]);

} elseif ($action === 'get') {
    echo json_encode(['cart' => $_SESSION['cart']]);

} elseif ($action === 'remove') {
    $index = $data['index'] ?? null;
    if ($index !== null && isset($_SESSION['cart'][$index])) {
        array_splice($_SESSION['cart'], $index, 1);
    }
    echo json_encode(['success' => true, 'count' => count($_SESSION['cart'])]);

} elseif ($action === 'clear') {
    $_SESSION['cart'] = [];
    echo json_encode(['success' => true]);
}
?>
