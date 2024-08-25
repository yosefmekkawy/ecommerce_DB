<?php
session_start();
$title = 'View Cart';
include_once "Models/User.php";
include_once "Models/Product.php";
include_once "Models/Cart.php";


if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id'];

include_once 'helpers/DBConnect.php';
$conn = connectToDB();


$stmt = $conn->prepare("
    SELECT c.id, c.quantity, p.title, p.description, p.image, p.id as product_id
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = :user_id
");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

include_once 'template/header.php';
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Your Cart</h2>

    <?php if (count($cart_items) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Actions</th>
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
                        <td>
                            <a href="remove_from_cart.php?cart_id=<?= $item['id'] ?>" class="btn btn-danger">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="text-end mt-4">
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        </div>
    <?php else: ?>
        <p class="text-center">Your cart is empty.</p>
        <div class="text-center">
            <a href="index.php#products" class="btn btn-primary">Continue Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?php include_once 'template/footer.php'; ?>
