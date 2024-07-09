<?php
require '../../config/database.php';
require '../../src/vendor/autoload.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product ID is required.";
}
