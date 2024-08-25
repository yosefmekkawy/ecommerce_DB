<?php

class Product {
    private $conn;
    private $table_name = "products";

    public function __construct() {
        $this->conn = $this->connectToDB();
    }

    private function connectToDB() {
        return new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
    }

    public function getAllProducts() {
        $stmt = $this->conn->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProductById($product_id)
    {
        $query = "SELECT p.id, p.title, p.description, p.quantity, p.image, c.name as category
                  FROM " . $this->table_name . " p
                  JOIN categories c ON p.category = c.id
                  WHERE p.id = :product_id";


        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
