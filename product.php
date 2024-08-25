<?php
session_start();
$title = 'Product Details';

include_once "Models/User.php";
include_once "Models/Product.php";

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$product = new Product();
$product_details = $product->getProductById($product_id);

if (!$product_details) {
    echo "<p>Product not found.</p>";
    exit();
}

include_once 'template/header.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <?php if (!empty($product_details['image'])): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($product_details['image']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product_details['title']) ?>">
            <?php else: ?>
                <img src="https://via.placeholder.com/500" class="img-fluid rounded" alt="No Image Available">
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h2 class="mb-4"><?= htmlspecialchars($product_details['title']) ?></h2>
            <p class="mb-4"><?= nl2br(htmlspecialchars($product_details['description'])) ?></p>

            <h4>Details</h4>
            <ul class="list-unstyled mb-4">
                <li><strong>Category:</strong> <?= htmlspecialchars($product_details['category']) ?></li>
                <li><strong>Quantity Available:</strong> <?= htmlspecialchars($product_details['quantity']) ?></li>
            </ul>

            <a href="add_to_cart.php?product_id=<?= htmlspecialchars($product_details['id']) ?>" class="btn btn-success btn-lg mb-2">Add to Cart</a>
            <a href="index.php" class="btn btn-secondary btn-lg mb-2">Back to Products</a>
        </div>
    </div>
</div>

<?php include_once 'template/footer.php'; ?>
