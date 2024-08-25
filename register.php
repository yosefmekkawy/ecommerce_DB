<?php
session_start();
$title = 'Register';
include_once "Models/User.php"; // OOP User class

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User(); // Instantiate the User class
    $check_email = $user->checkEmailExists($_POST['email']); // Check if email exists

    if (!$check_email) {
        $data_check = $user->register($_POST['username'], $_POST['email'], $_POST['password'], $_POST['phone']);

        if (is_array($data_check)) {
            header('Location: index.php');
            exit();
        }
    } else {
        $error_message = "This email is already registered";
    }
}
include_once 'template/header.php';
?>

<div class="register">
    <div class="container">
        <h2 class="text-center my-4">Register</h2>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?= $error_message ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="mx-auto p-4 border rounded bg-light" style="max-width: 400px;">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                <?php if (isset($check_email) && $check_email): ?>
                    <div class="alert alert-danger mt-2">This email is already registered</div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">Register</button>
            </div>

            <p class="mt-3 text-center">
                Already have an account? <a href="login.php">Click here to login</a>
            </p>
        </form>
    </div>
</div>

<?php include_once 'template/footer.php'; ?>
