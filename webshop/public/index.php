<?php
require '../includes/functions.php';
require '../config/database.php';
require '../src/vendor/autoload.php';
require '../src/classes/Database.php';
require '../src/classes/Product.php';
require '../src/classes/Review.php';

$db = new Database($config);
$pdo = $db->getConnection();

$productObj = new Product($pdo);
$reviewObj = new Review($pdo);

$products = $productObj->getAllProducts();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing Shop</title>
    <link rel="stylesheet" href="/webshop/public/css/pico.classless.min.css">
    <style>
        .products {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .product {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            width: calc(33.333% - 40px);
            box-sizing: border-box;
            text-align: center;
        }

        .product img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 16px;
        }
    </style>
    <script src="/webshop/public/js/theme-toggle.js"></script>
</head>

<body>
    <div class="theme-switch-wrapper">
        <label class="theme-switch">
            <input type="checkbox" id="theme-switch" onclick="toggleTheme()">
            <span class="slider"></span>
        </label>
    </div>
    <header>
        <?php include '../includes/header.php'; ?>
    </header>
    <main class="container">
        <h2>Amazing Shop</h2>
        <p>Most amazing items in the shop</p>
        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            echo '<p>Welcome, ' . $_SESSION['username'] . '!</p>';
        }
        ?>
        <div class="products">
            <?php foreach ($products as $product) : ?>
                <div class="product">
                    <a href="/webshop/public/views/product.view.php?id=<?php echo $product['id']; ?>">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    </a>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p>Price: <?php echo htmlspecialchars($product['price']); ?> EUR</p>
                    <p>Rating:
                        <?php
                        $average_rating = $reviewObj->getAverageRatingByProductId($product['id']);
                        echo $average_rating ? number_format($average_rating, 1) : 'No ratings yet';
                        ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <footer>
        <?php include '../includes/footer.php'; ?>
    </footer>
</body>

</html>
