<?php

require '../../config/database.php';
require '../../src/classes/Product.php';
require '../../src/classes/Review.php';

$productObj = new Product($pdo);
$reviewObj = new Review($pdo);

$products = $productObj->getAllProducts();
?>

<!DOCTYPE html>
<html lang="de" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="/webshop/public/css/pico.classless.min.css">
    <style>
        .products {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .product-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            width: 300px;
            box-sizing: border-box;
            text-align: center;
            background-color: var(--pico-background-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-bottom: 16px;
        }

        .product-card h3 {
            margin: 0 0 10px;
        }

        .product-card p {
            margin: 0 0 10px;
        }

        .product-card .price {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-card .rating {
            color: #ff9800;
        }
    </style>
    <script src="/webshop/public/js/theme-toggle.js"></script>
</head>

<body>
    <header>
        <?php include '../../includes/header.php'; ?>
    </header>
    <main class="container">
        <h2>Products</h2>
        <div class="products">
            <?php foreach ($products as $product) : ?>
                <div class="product-card">
                    <a href="product.view.php?id=<?php echo $product['id']; ?>">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </a>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p class="price"><?php echo htmlspecialchars($product['price']); ?> EUR</p>
                    <p class="rating">
                        <?php
                        $average_rating = $reviewObj->getAverageRatingByProductId($product['id']);
                        echo $average_rating ? number_format($average_rating, 1) : 'No ratings yet';
                        ?>
                    </p>
                    <a href="product.view.php?id=<?php echo $product['id']; ?>" class="button">View Product</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <footer>
        <?php include '../../includes/footer.php'; ?>
    </footer>
</body>

</html>
