<?php
session_start();

require '../../config/database.php';
require '../../src/classes/Product.php';
require '../../src/classes/Review.php';

$productObj = new Product($pdo);
$reviewObj = new Review($pdo);

$product_id = $_GET['id'] ?? null;

if (!$product_id) {
    header('Location: /webshop/public/views/products.view.php');
    exit();
}

$product = $productObj->getProductById($product_id);
$reviews = $reviewObj->getReviewsByProductId($product_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        if (isset($_POST['rating']) && isset($_POST['comment'])) {
            $rating = $_POST['rating'];
            $comment = $_POST['comment'];
            $user_id = $_SESSION['user_id'];

            $reviewObj->addReview($product_id, $user_id, $rating, $comment);

            header('Location: product.view.php?id=' . $product_id);
            exit();
        }
    } else {
        header('Location: /webshop/public/views/login.view.php');
        exit();
    }
}

$average_rating = $reviewObj->getAverageRatingByProductId($product_id);
