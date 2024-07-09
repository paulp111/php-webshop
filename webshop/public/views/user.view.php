<?php include '../../includes/header.php'; ?>
<main>
    <h2>Our Users</h2>
    <?php include 'layouts/user.main.php'; ?>
    <ul>
        <?php foreach ($users as $user) : ?>
            <li><?php echo htmlspecialchars($user['username']); ?> - <?php echo htmlspecialchars($user['email']); ?></li>
        <?php endforeach; ?>
    </ul>
</main>
<?php include '../../includes/footer.php'; ?>