<?php
require '../../config/database.php';
require '../../src/vendor/autoload.php';
require_once '../../src/classes/Database.php';
$products = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
