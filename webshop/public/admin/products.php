<?php
session_start();

require '../../config/database.php';
require '../../src/classes/Product.php';

$productObj = new Product($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $name = $_POST['name'] ?? null;
        $description = $_POST['description'] ?? null;
        $price = $_POST['price'] ?? null;

        if ($name && $description && $price) {
            $productObj->addProduct($name, $description, $price);
        } else {
            echo "Bitte füllen Sie alle Felder aus.";
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? null;
        $description = $_POST['description'] ?? null;
        $price = $_POST['price'] ?? null;

        if ($id && $name && $description && $price) {
            $productObj->updateProduct($id, $name, $description, $price);
        } else {
            echo "Bitte füllen Sie alle Felder aus.";
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'] ?? null;

        if ($id) {
            $productObj->deleteProduct($id);
        } else {
            echo "Produkt-ID nicht angegeben.";
        }
    }
}

$products = $productObj->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Produkte verwalten</title>
</head>
<header>
    <nav>
        <ul>
            <li><a href="/webshop/public/admin/index.php">Home</a></li>
            <li><a href="/webshop/public/admin/products.php">Products</a></li>
            <li><a href="/webshop/public/admin/users.php">Users</a></li>
            <li><a href="/webshop/public/admin/logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<body>
    <h2>Produkte verwalten</h2>

    <h3>Produkt hinzufügen</h3>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Beschreibung:</label>
        <input type="text" id="description" name="description" required><br><br>

        <label for="price">Preis:</label>
        <input type="number" id="price" name="price" step="0.01" required><br><br>

        <input type="submit" name="add" value="Hinzufügen">
    </form>

    <h3>Vorhandene Produkte</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Beschreibung</th>
            <th>Preis</th>
        </tr>
        <?php foreach ($products as $product) : ?>
            <tr>
                <form method="post" action="">
                    <td><?php echo $product['id']; ?></td>
                    <td><input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>"></td>
                    <td><input type="text" name="description" value="<?php echo htmlspecialchars($product['description']); ?>"></td>
                    <td><input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>"></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <input type="submit" name="update" value="Aktualisieren">
                        <input type="submit" name="delete" value="Löschen">
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>