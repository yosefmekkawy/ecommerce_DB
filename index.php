

<?php
session_start();
$title = 'Home';
include_once "Models/User.php";
include_once "Models/Product.php";
include_once "Models/Order.php";

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location:login.php');
    exit();
}

$user = new User();
$product = new Product();
$order = new Order();

$user_data = $user->getUserById($_SESSION['id']);
$user_type = $user_data['type'];

include_once 'helpers/DBConnect.php';
$conn = connectToDB();

$stmt = $conn->prepare("SELECT id, title, description, image FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

include_once 'template/header.php';
?>
<style>
    .card{
        transition: 600ms;
    }
    .card:hover{
        scale:1.03;
    }
</style>
<div class="home-page">
    <div class="container my-5">
        <h2 class="text-center mb-4">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2>

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs" id="homePageTabs" role="tablist">
            <?php if ($user_type == 'admin'): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="true">Users</button>
                </li>
            <?php endif; ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= ($user_type != 'admin') ? 'active' : '' ?>" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="false">Orders</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab" aria-controls="products" aria-selected="false">Products</button>
            </li>
        </ul>


        <div class="tab-content mt-4" id="homePageTabsContent">
            <!-- Users Tab (Admin Only) -->
            <?php if ($user_type == 'admin'): ?>
                <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
                    <h3 class="mb-4">All Users</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover text-center">
                            <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Password</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($user->getAllUsers() as $u): ?>
                                <tr>
                                    <td><?= htmlspecialchars($u['id']) ?></td>
                                    <td><?= htmlspecialchars($u['username']) ?></td>
                                    <td><?= htmlspecialchars($u['email']) ?></td>
                                    <td><?= htmlspecialchars($u['phone']) ?></td>
                                    <td><?= htmlspecialchars($u['pass']) ?></td>
                                    <td><?= htmlspecialchars($u['type']) ?></td>
                                    <td>
                                        <button class="btn btn-primary">Edit</button>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Orders Tab -->
            <div class="tab-pane fade <?= ($user_type != 'admin') ? 'show active' : '' ?>" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                <h3 class="mb-4"><?= $user_type == 'admin' ? 'All Orders' : 'Your Orders' ?></h3>
                <ul class="list-group mb-4">
                    <?php
                    $orders = ($user_type == 'admin') ? $order->getAllOrders() : $order->getUserOrders($_SESSION['id']);
                    foreach ($orders as $o): ?>
                        <li class="list-group-item">
                            Order #<?= htmlspecialchars($o['id']) ?> <?= $user_type == 'admin' ? 'by ' . htmlspecialchars($o['username']) : '' ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>


            <div class="tab-pane fade <?= ($user_type != 'admin') ? 'show active' : '' ?>" id="products" role="tabpanel" aria-labelledby="products-tab">
                <h3 class="mb-4">Available Products</h3>
                <div class="row justify-content-center">
                    <?php foreach ($products as $p): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">

                                <?php if (!empty($p['image'])): ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($p['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['title']) ?>">
                                <?php else: ?>

                                    <img src="path_to_placeholder_image.jpg" class="card-img-top" alt="No Image Available">
                                <?php endif; ?>

                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($p['title']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($p['description']) ?></p>
                                    <a href="product.php?id=<?= htmlspecialchars($p['id']) ?>" class="btn btn-primary my-2">View Product</a>
                                    <a href="add_to_cart.php?product_id=<?= htmlspecialchars($p['id']) ?>" class="btn btn-success">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row justify-content-center">
                    <a href="view_cart.php" class="btn btn-success mt-4 col-4">View Cart & Checkout</a>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include_once 'template/footer.php'; ?>
