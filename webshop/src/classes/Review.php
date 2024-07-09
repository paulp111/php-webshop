<?php

class Review
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addReview($product_id, $user_id, $rating, $comment)
    {
        $sql = "INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (:product_id, :user_id, :rating, :comment)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':product_id' => $product_id,
            ':user_id' => $user_id,
            ':rating' => $rating,
            ':comment' => $comment
        ]);
    }

    public function getReviewsByProductId($product_id)
    {
        $sql = "SELECT r.*, u.username FROM reviews r JOIN users u ON r.user_id = u.id WHERE product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':product_id' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAverageRatingByProductId($product_id)
    {
        $sql = "SELECT AVG(rating) as average_rating FROM reviews WHERE product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':product_id' => $product_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['average_rating'];
    }
}
