<?php
session_start();
include_once 'helpers/DBConnect.php';

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$cart_id = isset($_GET['cart_id']) ? intval($_GET['cart_id']) : 0;
$user_id = $_SESSION['id'];

if ($cart_id > 0) {
    $conn = connectToDB();
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = :cart_id AND user_id = :user_id");
    $stmt->bindParam(':cart_id', $cart_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}

header('Location: view_cart.php');
exit();
