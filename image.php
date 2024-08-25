<?php

include_once 'helpers/DBConnect.php'; // Connect to your database
connectToDB();
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare the SQL statement to get the image
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $imageData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($imageData) {
        // Output the image header
        header("Content-Type: image/jpeg"); // Adjust content type based on the actual image type
        echo $imageData['image']; // Output the image data directly
    } else {
        // Handle the case where there is no image
        header("Content-Type: image/jpeg");
        readfile('placeholder.jpg'); // Send a placeholder image if no image is found
    }
}

