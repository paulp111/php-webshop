<?php include '../../includes/header.php'; ?>
<main>
    <h2>Customer Reviews</h2>
    <?php include 'layouts/review.main.php'; ?>
    <ul>
        <?php foreach ($reviews as $review) : ?>
            <li>
                Product: <?php echo htmlspecialchars($review['product_id']); ?><br>
                Rating: <?php echo htmlspecialchars($review['rating']); ?><br>
                Comment: <?php echo htmlspecialchars($review['comment']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</main>
<?php include '../../includes/footer.php'; ?>