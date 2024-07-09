<?php
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
if (!$product) {
    echo "Product not found.";
    exit();
}

$reviews = $reviewObj->getReviewsByProductId($product_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
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
?>

<!DOCTYPE html>
<html lang="de" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="/webshop/public/css/pico.classless.min.css">
    <style>
        .product-detail {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin: 20px;
        }

        .product-detail img {
            max-width: 300px;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .product-detail h2 {
            margin-top: 0;
        }

        .reviews-section {
            margin-top: 40px;
        }

        .reviews-section h3 {
            margin-bottom: 20px;
        }

        .reviews-section ul {
            list-style: none;
            padding: 0;
        }

        .reviews-section ul li {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        
    </style>
    <script src="/webshop/public/js/theme-toggle.js"></script>
</head>

<body>
    <?php include '../../includes/header.php'; ?>

    <main class="container">
        <h2>Product Details</h2>
        <div class="product-detail">
            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p><?php echo htmlspecialchars($product['price']); ?> EUR</p>
            <form action="/webshop/public/views/layouts/cart.main.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" value="1" min="1">
                <button type="submit">Add to Cart</button>
            </form>
        </div>

        <div class="reviews-section">
            <p>Average Rating: <?php echo $average_rating ? number_format($average_rating, 1) : 'No ratings yet'; ?></p>
            <h3>Reviews</h3>
            <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) : ?>
                <form method="post" action="">
                    <label for="rating">Rating:</label>
                    <select id="rating" name="rating" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select><br><br>

                    <label for="comment">Comment:</label>
                    <textarea id="comment" name="comment" required></textarea><br><br>

                    <input type="submit" value="Submit Review">
                </form>
            <?php else : ?>
                <p>You must be logged in to write a review.</p>
            <?php endif; ?>

            <?php if ($reviews) : ?>
                <ul>
                    <?php foreach ($reviews as $review) : ?>
                        <li>
                            <strong><?php echo htmlspecialchars($review['username']); ?></strong>
                            <span><?php echo htmlspecialchars($review['rating']); ?> stars</span>
                            <p><?php echo htmlspecialchars($review['comment']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>No reviews yet.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include '../../includes/footer.php'; ?>
</body>

</html>
