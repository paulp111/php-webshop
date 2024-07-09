<?php
require '../includes/functions.php';
require '../config/database.php';
require '../src/vendor/autoload.php';
require '../src/classes/Database.php';

$db = new Database($config);
$pdo = $db->getConnection();

include '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="de" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to our Webshop</title>
    <link rel="stylesheet" href="/webshop/public/css/pico.classless.min.css">
    <script src="/webshop/public/js/theme-toggle.js"></script>
</head>

<body>
    <div class="theme-switch-wrapper">
        <label class="theme-switch">
            <input type="checkbox" id="theme-switch" onclick="toggleTheme()">
            <span class="slider"></span>
        </label>
    </div>
    <main class="container">
        <h2>Welcome to our Webshop</h2>
        <p>With us you can shop whatever, wherever and whenever you want.</p>
        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            echo '<p>Welcome, ' . $_SESSION['username'] . '!</p>';
        }
        ?>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>

</html>
