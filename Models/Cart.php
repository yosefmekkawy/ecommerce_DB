<?php
//
//class Cart
//{
//    private $conn;
//    private $table_name = "cart";
//
//    public function __construct($db)
//    {
//        $this->conn = $db;
//    }
//
//    // Add a product to the cart
//    public function addProduct($user_id, $product_id, $quantity = 1)
//    {
//        // Check if the product is already in the cart
//        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id AND product_id = :product_id";
//        $stmt = $this->conn->prepare($query);
//        $stmt->bindParam(':user_id', $user_id);
//        $stmt->bindParam(':product_id', $product_id);
//        $stmt->execute();
//
//        if ($stmt->rowCount() > 0) {
//            // If the product is already in the cart, update the quantity
//            $query = "UPDATE " . $this->table_name . " SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id";
//        } else {
//            // Otherwise, insert the product into the cart
//            $query = "INSERT INTO " . $this->table_name . " (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
//        }
//
//        $stmt = $this->conn->prepare($query);
//        $stmt->bindParam(':user_id', $user_id);
//        $stmt->bindParam(':product_id', $product_id);
//        $stmt->bindParam(':quantity', $quantity);
//        return $stmt->execute();
//    }
//
//    // Get all items in the user's cart
//    public function getUserCart($user_id)
//    {
//        $query = "SELECT c.id as cart_id, c.quantity, p.id as product_id, p.title, p.description, p.image
//                  FROM " . $this->table_name . " c
//                  JOIN products p ON c.product_id = p.id
//                  WHERE c.user_id = :user_id";
//        $stmt = $this->conn->prepare($query);
//        $stmt->bindParam(':user_id', $user_id);
//        $stmt->execute();
//
//        return $stmt->fetchAll(PDO::FETCH_ASSOC);
//    }
//
//    // Remove an item from the cart
//    public function removeProduct($cart_id, $user_id)
//    {
//        $query = "DELETE FROM " . $this->table_name . " WHERE id = :cart_id AND user_id = :user_id";
//        $stmt = $this->conn->prepare($query);
//        $stmt->bindParam(':cart_id', $cart_id);
//        $stmt->bindParam(':user_id', $user_id);
//        return $stmt->execute();
//    }
//
//    // Clear the user's cart
//    public function clearCart($user_id)
//    {
//        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id";
//        $stmt = $this->conn->prepare($query);
//        $stmt->bindParam(':user_id', $user_id);
//        return $stmt->execute();
//    }
//}


class Cart
{
    private $conn;
    private $table_name = "cart";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addProduct($user_id, $product_id, $quantity = 1)
    {
        // Check if the product is already in the cart
        $query = "SELECT quantity FROM " . $this->table_name . " WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $query = "UPDATE " . $this->table_name . " SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id";
        } else {
            $query = "INSERT INTO " . $this->table_name . " (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }
}
