<?php

class Order {
    private $conn;

    public function __construct() {
        $this->conn = $this->connectToDB();
    }

    private function connectToDB() {
        return new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
    }

    public function getAllOrders() {
        $stmt = $this->conn->query("SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserOrders($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
