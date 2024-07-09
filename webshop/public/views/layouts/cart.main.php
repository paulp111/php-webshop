<?php
session_start();
require '../../../config/database.php';
require '../../../src/classes/Cart.php';



if (!isset($_SESSION['user_id'])) {
    $_SESSION['pending_cart'] = [
        'product_id' => $_POST['product_id'],
        'quantity' => $_POST['quantity']
    ];
    header('Location: /webshop/public/views/login.view.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$cart = new Cart($pdo, $user_id);
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

$cart->addItem($user_id, $product_id, $quantity);

header('Location: /webshop/public/views/cart.view.php');
exit();
