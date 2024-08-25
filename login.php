<?php
session_start();
$title = 'Login';
include_once "Models/User.php"; // Updated to use OOP

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User(); // Instantiate the User class
    $data_check = $user->login($_POST['email'], $_POST['password']); // OOP login function

    if ($data_check) {
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['id'] = $data_check['id'];
        $_SESSION['username'] = $data_check['username'];
        header('Location: index.php');
        exit();
    } else {
        $error_message = "Email or password are invalid";
    }
}
include_once 'template/header.php';
?>

<div class="login">
    <div class="container">
        <h2 class="text-center my-4">Login</h2>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?= $error_message ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="mx-auto p-4 border rounded bg-light" style="max-width: 400px;">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">Login</button>
            </div>

            <p class="mt-3 text-center">
                Don't have an account? <a href="register.php">Click here</a>
            </p>
        </form>
    </div>
</div>

<?php include_once 'template/footer.php'; ?>
