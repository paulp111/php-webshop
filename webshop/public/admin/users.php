<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || $_SESSION['role'] !== 'admin') {
    header('Location: /webshop/public/index.php');
    exit();
}

require_once '../../config/database.php';

function getAllUsers($pdo)
{
    $stmt = $pdo->query("SELECT id, username, role FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET role = :role WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['role' => $role, 'user_id' => $user_id]);

    header('Location: users.php');
    exit();
}

$users = getAllUsers($pdo);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>

<body>
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

    <main>
        <h2>User Management</h2>

        <table>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <form action="users.php" method="post">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <select name="role">
                                <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                                <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                            </select>
                            <button type="submit">Update Role</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>

</html>