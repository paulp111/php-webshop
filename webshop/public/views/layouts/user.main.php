<?php
require '../../config/database.php';
require '../../src/vendor/autoload.php';
require_once '../../src/classes/Database.php';
$users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
