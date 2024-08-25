<?php
class User {
    private $conn;

    public function __construct() {
        $this->conn = $this->connectToDB();
    }

    private function connectToDB() {

        return new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email AND pass = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':password' => $password
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function checkEmailExists($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function register($username, $email, $password, $phone) {
        $sql = "INSERT INTO users (username, email, pass, phone,type) VALUES (:username, :email, :password, :phone,'client')";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':phone' => $phone
        ]);
        return $this->checkEmailExists($email);
    }
    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        $stmt = $this->conn->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
