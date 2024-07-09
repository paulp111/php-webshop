<?php


require '../../config/database.php';
require '../../src/classes/Cart.php';
include '../../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /webshop/public/views/login.view.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$cart = new Cart($pdo, $user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $cart->updateItem($product_id, $quantity);
    } elseif (isset($_POST['remove_item'])) {
        $product_id = $_POST['product_id'];
        $cart->removeItem($product_id);
    }
}

$cartItems = $cart->getCartItems();
$totalPrice = $cart->getTotalPrice();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>

<body>
    <div class="cart">
        <h2>Your Cart</h2>
        <?php if (empty($cartItems)) : ?>
            <p>Your cart is empty.</p>
        <?php else : ?>
            <form action="cart.view.php" method="post">
                <table>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                    <?php
                    $totalPrice = 0;
                    foreach ($cartItems as $item) :
                        $total = $item['price'] * $item['quantity'];
                        $totalPrice += $total;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="update_quantity">Update</button>
                            </td>
                            <td><?php echo htmlspecialchars($item['price']); ?> EUR</td>
                            <td><?php echo $total; ?> EUR</td>
                            <td>
                                <button type="submit" name="remove_item">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3">Total</td>
                        <td><?php echo $totalPrice; ?> EUR</td>
                        <td></td>
                    </tr>
                </table>
            </form>
            <a href="checkout.view.php">Checkout</a>
        <?php endif; ?>
    </div>
    <?php include '../../includes/footer.php'; ?>
</body>

</html>