<?php

class Cart
{
    private $db;
    private $user_id;

    public function __construct($db, $user_id)
    {
        $this->db = $db;
        $this->user_id = $user_id;
    }

    public function addItem($user_id, $product_id, $quantity)
    {
        $stmt = $this->db->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity]);
    }

    public function updateItem($product_id, $quantity)
    {
        $sql = "UPDATE carts SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $this->user_id,
            ':product_id' => $product_id,
            ':quantity' => $quantity
        ]);
    }

    public function removeItem($product_id)
    {
        $sql = "DELETE FROM carts WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $this->user_id,
            ':product_id' => $product_id
        ]);
    }

    public function getItemById($product_id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $product_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCartItems()
    {
        $sql = "SELECT p.*, c.quantity FROM products p 
                INNER JOIN carts c ON p.id = c.product_id 
                WHERE c.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $this->user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalPrice()
    {
        $sql = "SELECT SUM(p.price * c.quantity) as total FROM products p 
                INNER JOIN carts c ON p.id = c.product_id 
                WHERE c.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $this->user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
