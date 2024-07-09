<?php

class Product
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllProducts()
    {
        $stmt = $this->db->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addProduct($name, $description, $price)
    {
        $sql = "INSERT INTO products(name, description, price) VALUES (:name, :description, :price)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':name' => $name, ':description' => $description, ':price' => $price]);
    }

    public function updateProduct($id, $name, $description, $price)
    {
        $sql = "UPDATE products SET name = :name, description=:description, price=:price WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':name' => $name, ':description' => $description, ':price' => $price, ':id' => $id]);
    }

    public function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE id =:id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
