<?php

session_start();
include_once "Models/User.php";
include_once "Models/Product.php";
include_once "Models/Cart.php";

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$user_id = $_SESSION['id'];

if ($product_id > 0) {
    include_once 'helpers/DBConnect.php';
    $conn = connectToDB();

    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = :user_id AND product_id = :product_id");
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)");
    }
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
}

header('Location: index.php#products');
exit();
