<?php
session_start();
$title = 'Checkout';
include_once "Models/User.php";
include_once "Models/Product.php";
include_once "Models/Order.php";
include_once "Models/Cart.php";


if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id'];

include_once 'helpers/DBConnect.php';
$conn = connectToDB();


$stmt = $conn->prepare("
    SELECT c.id as cart_id, c.quantity, p.id as product_id, p.title, p.description, p.image
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = :user_id
");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cart_items)) {
    header('Location: view_cart.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = $_POST['address'];


    $stmt = $conn->prepare("INSERT INTO orders (user_id, address, created_at) VALUES (:user_id, :address, NOW())");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':address', $address);
    $stmt->execute();
    $order_id = $conn->lastInsertId();


    foreach ($cart_items as $item) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $item['product_id']);
        $stmt->bindParam(':quantity', $item['quantity']);
        $stmt->execute();
    }

    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    header('Location:index.php');
    exit();
}

include_once 'template/header.php';
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Checkout</h2>

    <form method="POST" action="checkout.php">
        <div class="mb-3">
            <label for="address" class="form-label">Shipping Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
        </div>

        <h4 class="mb-3">Order Summary</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="data:image/jpeg;base64,<?= base64_encode($item['image']) ?>" class="img-thumbnail" style="width: 100px; height: auto;" alt="<?= htmlspecialchars($item['title']) ?>">
                                <span class="ms-3"><?= htmlspecialchars($item['title']) ?></span>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($item['description']) ?></td>
                        <td><?= htmlspecialchars($item['quantity']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success">Place Order</button>
        </div>
    </form>
</div>

<?php include_once 'template/footer.php'; ?>
