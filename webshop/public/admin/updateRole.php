<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || $_SESSION['role'] !== 'admin') {
    header('Location: /webshop/public/index.php');
    exit();
}

require '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];
    $sql = "UPDATE users SET role = :role WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['role' => $role, 'username' => $username]);

    header('Location: /webshop/public/admin/users.php');
    exit();
}
